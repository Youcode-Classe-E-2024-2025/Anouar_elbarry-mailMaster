<template>
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Tableau de bord</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Abonnés</h2>
        <div class="text-4xl font-bold">{{ subscriberCount }}</div>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Campagnes</h2>
        <div class="text-4xl font-bold">{{ campaignCount }}</div>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-2">Listes</h2>
        <div class="text-4xl font-bold">{{ listCount }}</div>
      </div>
    </div>
    
    <div class="mt-8">
      <h2 class="text-2xl font-bold mb-4">Campagnes récentes</h2>
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
          <thead class="bg-gray-100">
            <tr>
              <th class="py-3 px-4 text-left">Titre</th>
              <th class="py-3 px-4 text-left">Date d'envoi</th>
              <th class="py-3 px-4 text-left">Destinataires</th>
              <th class="py-3 px-4 text-left">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="campaign in recentCampaigns" :key="campaign.id" class="border-t">
              <td class="py-3 px-4">{{ campaign.title }}</td>
              <td class="py-3 px-4">{{ campaign.sendDate }}</td>
              <td class="py-3 px-4">{{ campaign.recipients }}</td>
              <td class="py-3 px-4">
                <button class="text-blue-600 hover:underline">Voir</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Dashboard',
  data() {
    return {
      subscriberCount: 1245,
      campaignCount: 24,
      listCount: 5,
      recentCampaigns: [
        {
          id: 1,
          title: 'Nouveautés du mois',
          sendDate: '2025-04-01',
          recipients: 1200
        },
        {
          id: 2,
          title: 'Promotion Printemps',
          sendDate: '2025-03-15',
          recipients: 1150
        },
        {
          id: 3,
          title: 'Newsletter Hebdomadaire',
          sendDate: '2025-03-01',
          recipients: 1100
        }
      ]
    }
  },
  mounted() {
    // Here you would fetch data from your Laravel API
    this.fetchDashboardData();
  },
  methods: {
    fetchDashboardData() {
      // Implementation of API call to Laravel backend
      // axios.get('/api/dashboard').then(response => {
      //   this.subscriberCount = response.data.subscriberCount;
      //   this.campaignCount = response.data.campaignCount;
      //   this.listCount = response.data.listCount;
      //   this.recentCampaigns = response.data.recentCampaigns;
      // });
    }
  }
}
</script>