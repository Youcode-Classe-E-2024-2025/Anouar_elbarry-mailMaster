<template>
    <div class="container mx-auto px-4 py-6">
      <h1 class="text-3xl font-bold mb-6">Créer une campagne</h1>
      
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-4">Informations générales</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Nom de la campagne</label>
              <input v-model="campaign.name" type="text" class="w-full border rounded-md px-3 py-2" placeholder="Ex: Newsletter Avril 2025" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Objet de l'email</label>
              <input v-model="campaign.subject" type="text" class="w-full border rounded-md px-3 py-2" placeholder="Ex: Nos dernières actualités" />
            </div>
          </div>
        </div>
        
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-4">Destinataires</h2>
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Listes</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <div v-for="list in lists" :key="list.id" class="flex items-center">
                <input type="checkbox" :id="`list-${list.id}`" v-model="campaign.selectedLists" :value="list.id" class="mr-2" />
                <label :for="`list-${list.id}`">{{ list.name }} ({{ list.subscriberCount }} abonnés)</label>
              </div>
            </div>
          </div>
        </div>
        
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-4">Contenu de l'email</h2>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
            <textarea v-model="campaign.content" class="w-full border rounded-md px-3 py-2" rows="10" placeholder="Écrivez votre contenu ici..."></textarea>
          </div>
        </div>
        
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-4">Planification</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Date d'envoi</label>
              <input v-model="campaign.sendDate" type="date" class="w-full border rounded-md px-3 py-2" />
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Heure d'envoi</label>
              <input v-model="campaign.sendTime" type="time" class="w-full border rounded-md px-3 py-2" />
            </div>
          </div>
        </div>
        
        <div class="flex gap-4 justify-end">
          <button class="px-4 py-2 border rounded-md" @click="saveDraft">Enregistrer comme brouillon</button>
          <button class="px-4 py-2 border rounded-md" @click="sendTest">Envoyer un test</button>
          <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" @click="scheduleCampaign">Programmer l'envoi</button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'CampaignCreate',
    data() {
      return {
        campaign: {
          name: '',
          subject: '',
          selectedLists: [],
          content: '',
          sendDate: '',
          sendTime: ''
        },
        lists: [
          { id: 1, name: 'Newsletter', subscriberCount: 1245 },
          { id: 2, name: 'Promotions', subscriberCount: 987 },
          { id: 3, name: 'Mises à jour produit', subscriberCount: 756 }
        ]
      }
    },
    mounted() {
      // Fetch lists from API
      this.fetchLists();
    },
    methods: {
      fetchLists() {
        // API call to get lists
        // axios.get('/api/lists').then(response => {
        //   this.lists = response.data;
        // });
      },
      saveDraft() {
        // Save as draft
        // axios.post('/api/campaigns/draft', this.campaign).then(response => {
        //   this.$router.push('/campaigns');
        // });
        alert('Brouillon enregistré !');
      },
      sendTest() {
        // Send test email
        // axios.post('/api/campaigns/test', this.campaign).then(response => {
        //   alert('Email de test envoyé !');
        // });
        alert('Email de test envoyé !');
      },
      scheduleCampaign() {
        // Schedule campaign
        // axios.post('/api/campaigns', this.campaign).then(response => {
        //   this.$router.push('/campaigns');
        // });
        alert('Campagne programmée !');
        this.$router.push('/campaigns');
      }
    }
  }
  </script>
  