<template>
  <div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Campagnes</h1>
      <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700" @click="$router.push('/campaigns/create')">
        Nouvelle campagne
      </button>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="p-4 bg-gray-50 flex gap-4">
        <select v-model="filterStatus" class="border rounded-md px-3 py-2">
          <option value="">Tous les statuts</option>
          <option value="draft">Brouillon</option>
          <option value="scheduled">Programmée</option>
          <option value="sent">Envoyée</option>
        </select>
        <input v-model="searchTerm" type="text" placeholder="Rechercher..." class="border rounded-md px-3 py-2 flex-1" />
      </div>
      <table class="w-full">
        <thead class="bg-gray-100">
          <tr>
            <th class="py-3 px-4 text-left">Titre</th>
            <th class="py-3 px-4 text-left">Statut</th>
            <th class="py-3 px-4 text-left">Date d'envoi</th>
            <th class="py-3 px-4 text-left">Destinataires</th>
            <th class="py-3 px-4 text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="campaign in filteredCampaigns" :key="campaign.id" class="border-t">
            <td class="py-3 px-4">{{ campaign.title }}</td>
            <td class="py-3 px-4">
              <span :class="{
                'bg-gray-100': campaign.status === 'draft',
                'bg-blue-100 text-blue-800': campaign.status === 'scheduled',
                'bg-green-100 text-green-800': campaign.status === 'sent'
              }" class="px-2 py-1 rounded-full text-sm">
                {{ statusText(campaign.status) }}
              </span>
            </td>
            <td class="py-3 px-4">{{ campaign.sendDate || '-' }}</td>
            <td class="py-3 px-4">{{ campaign.recipients }}</td>
            <td class="py-3 px-4">
              <button @click="viewCampaign(campaign.id)" class="text-blue-600 hover:underline mr-2">Voir</button>
              <button v-if="campaign.status === 'draft'" @click="editCampaign(campaign.id)" class="text-blue-600 hover:underline mr-2">Modifier</button>
              <button @click="deleteCampaign(campaign.id)" class="text-red-600 hover:underline">Supprimer</button>
            </td>
          </tr>
        </tbody>
      </table>
      
      <div class="p-4 border-t">
        <div class="flex justify-between items-center">
          <div>Affichage de {{ filteredCampaigns.length }} sur {{ campaigns.length }} campagnes</div>
          <div class="flex gap-2">
            <button class="px-3 py-1 border rounded-md" :disabled="currentPage === 1">Précédent</button>
            <button class="px-3 py-1 bg-blue-600 text-white rounded-md">{{ currentPage }}</button>
            <button class="px-3 py-1 border rounded-md" :disabled="currentPage === totalPages">Suivant</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CampaignsList',
  data() {
    return {
      campaigns: [
        {
          id: 1,
          title: 'Newsletter Avril 2025',
          status: 'sent',
          sendDate: '2025-04-01',
          recipients: 1245
        },
        {
          id: 2,
          title: 'Promotion Printemps',
          status: 'scheduled',
          sendDate: '2025-04-15',
          recipients: 987
        },
        {
          id: 3,
          title: 'Annonce Nouveau Produit',
          status: 'draft',
          sendDate: null,
          recipients: 0
        }
      ],
      filterStatus: '',
      searchTerm: '',
      currentPage: 1,
      totalPages: 3
    }
  },
  computed: {
    filteredCampaigns() {
      return this.campaigns.filter(campaign => {
        const matchesSearch = this.searchTerm === '' || 
          campaign.title.toLowerCase().includes(this.searchTerm.toLowerCase());
          
        const matchesStatus = this.filterStatus === '' || 
          campaign.status === this.filterStatus;
          
        return matchesSearch && matchesStatus;
      });
    }
  },
  mounted() {
    // Fetch campaigns from API
    this.fetchCampaigns();
  },
  methods: {
    fetchCampaigns() {
      // API call to fetch campaigns
      // axios.get('/api/campaigns').then(response => {
      //   this.campaigns = response.data;
      // });
    },
    statusText(status) {
      const statusMap = {
        draft: 'Brouillon',
        scheduled: 'Programmée',
        sent: 'Envoyée'
      };
      return statusMap[status] || status;
    },
    viewCampaign(id) {
      this.$router.push(`/campaigns/${id}`);
    },
    editCampaign(id) {
      this.$router.push(`/campaigns/${id}/edit`);
    },
    deleteCampaign(id) {
      if (confirm('Êtes-vous sûr de vouloir supprimer cette campagne ?')) {
        // axios.delete(`/api/campaigns/${id}`).then(() => {
        //   this.campaigns = this.campaigns.filter(c => c.id !== id);
        // });
      }
    }
  }
}
</script>