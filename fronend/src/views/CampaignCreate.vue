<template>
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Créer une campagne</h1>
    
    <div class="bg-white rounded-lg shadow-md p-6">
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Informations générales</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nom de la campagne</label>
            <input 
              v-model="campaign.title" 
              type="text" 
              class="w-full border rounded-md px-3 py-2" 
              placeholder="Ex: Newsletter Avril 2025" 
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Objet de l'email</label>
            <input 
              v-model="campaign.subject" 
              type="text" 
              class="w-full border rounded-md px-3 py-2" 
              placeholder="Ex: Nos dernières actualités" 
              required
            />
          </div>
        </div>
      </div>
      
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Destinataires</h2>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Listes</label>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="list in lists" :key="list.id" class="flex items-center">
              <input 
                type="radio" 
                :id="`list-${list.id}`" 
                v-model="campaign.list_id" 
                :value="list.id" 
                class="mr-2" 
                required
              />
              <label :for="`list-${list.id}`">
                {{ list.name }} ({{ list.subscriberCount }} abonnés)
              </label>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Contenu de l'email</h2>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
          <textarea 
            v-model="campaign.content" 
            class="w-full border rounded-md px-3 py-2" 
            rows="10" 
            placeholder="Écrivez votre contenu ici..."
            required
          ></textarea>
        </div>
      </div>
      
      <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Planification</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date d'envoi</label>
            <input 
              v-model="campaign.send_date" 
              type="date" 
              class="w-full border rounded-md px-3 py-2" 
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Heure d'envoi</label>
            <input 
              v-model="campaign.send_time" 
              type="time" 
              class="w-full border rounded-md px-3 py-2" 
            />
          </div>
        </div>
      </div>
      
      <div class="flex gap-4 justify-end">
        <button 
          class="px-4 py-2 border rounded-md" 
          @click="saveDraft"
        >
          Enregistrer comme brouillon
        </button>
        <button 
          class="px-4 py-2 border rounded-md" 
          @click="sendTestCampaign"
        >
          Envoyer un test
        </button>
        <button 
          class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" 
          @click="createCampaign"
        >
          Programmer l'envoi
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { campaignService, listService } from '@/services/api';

export default {
  name: 'CampaignCreate',
  data() {
    return {
      campaign: {
        title: '',
        subject: '',
        list_id: null,
        content: '',
        send_date: '',
        send_time: ''
      },
      lists: []
    }
  },
  mounted() {
    this.fetchLists();
  },
  methods: {
    async fetchLists() {
      try {
        const response = await listService.getAll();
        this.lists = response.data.lists.map(list => ({
          ...list,
          subscriberCount: list.subscribers_count || 0
        }));
      } catch (error) {
        console.error('Failed to fetch lists', error);
        // Optional: show error toast
      }
    },
    
    async saveDraft() {
      try {
        // Set status to draft
        const draftCampaign = {
          ...this.campaign,
          status: 'draft'
        };
        
        const response = await campaignService.create(draftCampaign);
        this.$router.push('/campaigns');
        // Optional: show success toast
        this.$toast.success('Brouillon enregistré !');
      } catch (error) {
        console.error('Failed to save draft', error);
        // Optional: show error toast
        this.$toast.error('Échec de l\'enregistrement du brouillon');
      }
    },
    
    async sendTestCampaign() {
      try {
        // Implement test campaign sending logic
        const testResponse = await campaignService.sendTest(this.campaign);
        this.$toast.success('Email de test envoyé !');
      } catch (error) {
        console.error('Failed to send test email', error);
        this.$toast.error('Échec de l\'envoi de l\'email de test');
      }
    },
    
    async createCampaign() {
      try {
        // Combine send_date and send_time if both are provided
        if (this.campaign.send_date && this.campaign.send_time) {
          this.campaign.scheduled_at = `${this.campaign.send_date} ${this.campaign.send_time}`;
        }
        
        const response = await campaignService.create({
          ...this.campaign,
          status: 'scheduled'
        });
        
        this.$router.push('/campaigns');
        this.$toast.success('Campagne programmée !');
      } catch (error) {
        console.error('Failed to create campaign', error);
        this.$toast.error('Échec de la création de la campagne');
      }
    }
  }
}
</script>