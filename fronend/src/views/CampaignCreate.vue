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
            <div class="flex flex-wrap gap-2">
              <div v-for="list in lists" :key="list.id" class="flex items-center">
                <input type="checkbox" :id="`list-${list.id}`" v-model="campaign.selectedLists" :value="list.id" class="mr-2" />
                <label :for="`list-${list.id}`">{{ list.name }} ({{ list.subscriberCount }} abonnés)</label>
              </div>
            </div>
          </div>
          
          <div>
            <div class="flex justify-between items-center mb-2">
              <label class="block text-sm font-medium text-gray-700">Filtres supplémentaires</label>
              <button @click="addFilter" class="text-blue-600 hover:underline text-sm">+ Ajouter un filtre</button>
            </div>
            
            <div v-for="(filter, index) in campaign.filters" :key="index" class="flex items-center gap-2 mb-2">
              <select v-model="filter.field" class="border rounded-md px-3 py-2">
                <option value="subscriptionDate">Date d'inscription</option>
                <option value="openRate">Taux d'ouverture</option>
                <option value="clickRate">Taux de clic</option>
              </select>
              <select v-model="filter.operator" class="border rounded-md px-3 py-2">
                <option value="gt">Supérieur à</option>
                <option value="lt">Inférieur à</option>
                <option value="eq">Égal à</option>
              </select>
              <input v-model="filter.value" type="text" class="border rounded-md px-3 py-2" />
              <button @click="removeFilter(index)" class="text-red-600">×</button>
            </div>
          </div>
        </div>
        
        <div class="mb-6">
          <h2 class="text-xl font-semibold mb-4">Contenu de l'email</h2>
          <div class="mb-4">
            <div class="flex justify-between items-center mb-2">
              <label class="block text-sm font-medium text-gray-700">Modèle d'email</label>
              <button class="text-blue-600 hover:underline text-sm">Gérer les modèles</button>
            </div>
            <select v-model="campaign.template" class="w-full border rounded-md px-3 py-2">
              <option v-for="template in templates" :key="template.id" :value="template.id">{{ template.name }}</option>
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Contenu</label>
            <div class="border rounded-md p-2 min-h-64">
              <!-- Ici vous intégreriez un éditeur WYSIWYG -->
              <textarea v-model="campaign.content" class="w-full h-64 p-2 border-none outline-none" placeholder="Écrivez votre contenu ici..."></textarea>
            </div>
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
          <button class="px-4 py-2 border rounded-md">Enregistrer comme brouillon</button>
          <button @click="sendTestEmail" class="px-4 py-2 border rounded-md">Envoyer un test</button>
          <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Programmer l'envoi</button>
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
          template: null,
          content: '',
          sendDate: '',
          sendTime: '',
          filters: []
        },
        lists: [
          { id: 1, name: 'Newsletter', subscriberCount: 1245 },
          { id: 2, name: 'Promotions', subscriberCount: 987 },
          { id: 3, name: 'Mises à jour produit', subscriberCount: 756 }
        ],
        templates: [
          { id: 1, name: 'Template par défaut' },
          { id: 2, name: 'Annonce promotionnelle' },
          { id: 3, name: 'Newsletter mensuelle' }
        ]
      }
    },
    mounted() {
      // Fetch lists and templates from API
      this.fetchLists();
      this.fetchTemplates();
    },
    methods: {
      fetchLists() {
        // API call to get lists
        // axios.get('/api/lists').then(response => {
        //   this.lists = response.data;
        // });
      },
      fetchTemplates() {
        // API call to get templates
        // axios.get('/api/templates').then(response => {
        //   this.templates = response.data;
        // });
      },
      addFilter() {
        this.campaign.filters.push({
          field: 'subscriptionDate',
          operator: 'gt',
          value: ''
        });
      },
      removeFilter(index) {
        this.campaign.filters.splice(index, 1);
      },
      sendTestEmail() {
        // Implementation to send test email
        alert('Email de test envoyé !');
      },
      saveCampaign() {
        // Implementation to save campaign
        // axios.post('/api/campaigns', this.campaign).then(response => {
        //   this.$router.push('/campaigns');
        // });
      }
    }
  }
  </script>
  