<template>
    <div class="container mx-auto px-4 py-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Abonnés</h1>
        <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700" @click="showAddSubscriberModal = true">
          Ajouter un abonné
        </button>
      </div>
  
      <div class="bg-white p-4 rounded-lg shadow-md mb-6">
        <div class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
            <input v-model="searchTerm" type="text" placeholder="Rechercher un abonné..." class="w-full border rounded-md px-3 py-2" />
          </div>
          <div class="min-w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Liste</label>
            <select v-model="selectedList" class="w-full border rounded-md px-3 py-2">
              <option value="">Toutes les listes</option>
              <option v-for="list in lists" :key="list.id" :value="list.id">{{ list.name }}</option>
            </select>
          </div>
          <div class="min-w-48">
            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select v-model="selectedStatus" class="w-full border rounded-md px-3 py-2">
              <option value="">Tous</option>
              <option value="active">Actifs</option>
              <option value="inactive">Inactifs</option>
            </select>
          </div>
        </div>
      </div>
  
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="w-full">
          <thead class="bg-gray-100">
            <tr>
              <th class="py-3 px-4 text-left">Email</th>
              <th class="py-3 px-4 text-left">Nom</th>
              <th class="py-3 px-4 text-left">Listes</th>
              <th class="py-3 px-4 text-left">Date d'inscription</th>
              <th class="py-3 px-4 text-left">Statut</th>
              <th class="py-3 px-4 text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="subscriber in filteredSubscribers" :key="subscriber.id" class="border-t">
              <td class="py-3 px-4">{{ subscriber.email }}</td>
              <td class="py-3 px-4">{{ subscriber.name }}</td>
              <td class="py-3 px-4">
                <span v-for="(list, index) in subscriber.lists" :key="list.id" class="inline-block bg-gray-200 px-2 py-1 rounded-full text-sm mr-1">
                  {{ list.name }}
                </span>
              </td>
              <td class="py-3 px-4">{{ subscriber.subscriptionDate }}</td>
              <td class="py-3 px-4">
                <span :class="subscriber.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'" class="px-2 py-1 rounded-full text-sm">
                  {{ subscriber.status === 'active' ? 'Actif' : 'Inactif' }}
                </span>
              </td>
              <td class="py-3 px-4">
                <button @click="editSubscriber(subscriber)" class="text-blue-600 hover:underline mr-2">Modifier</button>
                <button @click="deleteSubscriber(subscriber.id)" class="text-red-600 hover:underline">Supprimer</button>
              </td>
            </tr>
          </tbody>
        </table>
        
        <div class="p-4 border-t">
          <div class="flex justify-between items-center">
            <div>Affichage de {{ filteredSubscribers.length }} sur {{ subscribers.length }} abonnés</div>
            <div class="flex gap-2">
              <button class="px-3 py-1 border rounded-md" :disabled="currentPage === 1">Précédent</button>
              <button class="px-3 py-1 bg-blue-600 text-white rounded-md">{{ currentPage }}</button>
              <button class="px-3 py-1 border rounded-md" :disabled="currentPage === totalPages">Suivant</button>
            </div>
          </div>
        </div>
      </div>
  
      <!-- Modal pour ajouter un abonné (à implémenter) -->
      <div v-if="showAddSubscriberModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <!-- Modal content goes here -->
      </div>
    </div>
  </template>

<script>
export default {
  name: 'SubscribersList',
  data() {
    return {
      subscribers: [
        {
          id: 1, 
          email: 'john.doe@example.com', 
          name: 'John Doe', 
          lists: [{ id: 1, name: 'Newsletter' }, { id: 2, name: 'Promotions' }],
          subscriptionDate: '2025-01-15',
          status: 'active'
        },
        {
          id: 2, 
          email: 'jane.smith@example.com', 
          name: 'Jane Smith', 
          lists: [{ id: 1, name: 'Newsletter' }],
          subscriptionDate: '2025-02-22',
          status: 'active'
        },
        {
          id: 3, 
          email: 'bob.jackson@example.com', 
          name: 'Bob Jackson', 
          lists: [{ id: 2, name: 'Promotions' }],
          subscriptionDate: '2025-03-05',
          status: 'inactive'
        },
      ],
      lists: [
        { id: 1, name: 'Newsletter' },
        { id: 2, name: 'Promotions' },
        { id: 3, name: 'Mises à jour produit' }
      ],
      searchTerm: '',
      selectedList: '',
      selectedStatus: '',
      currentPage: 1,
      totalPages: 5,
      showAddSubscriberModal: false
    }
  },
  computed: {
    filteredSubscribers() {
      return this.subscribers.filter(subscriber => {
        const matchesSearch = this.searchTerm === '' || 
          subscriber.email.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
          subscriber.name.toLowerCase().includes(this.searchTerm.toLowerCase());
          
        const matchesList = this.selectedList === '' || 
          subscriber.lists.some(list => list.id === parseInt(this.selectedList));
          
        const matchesStatus = this.selectedStatus === '' || 
          subscriber.status === this.selectedStatus;
          
        return matchesSearch && matchesList && matchesStatus;
      });
    }
  },
  mounted() {
    // Fetch subscribers from API
    this.fetchSubscribers();
    this.fetchLists();
  },
  methods: {
    fetchSubscribers() {
      // API call to Laravel backend
      // axios.get('/api/subscribers').then(response => {
      //   this.subscribers = response.data;
      // });
    },
    fetchLists() {
      // API call to Laravel backend
      // axios.get('/api/lists').then(response => {
      //   this.lists = response.data;
      // });
    },
    editSubscriber(subscriber) {
      // Implementation for editing subscriber
    },
    deleteSubscriber(id) {
      // Implementation for deleting subscriber
      if (confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?')) {
        // API call to delete
        // axios.delete(`/api/subscribers/${id}`).then(() => {
        //   this.subscribers = this.subscribers.filter(s => s.id !== id);
        // });
      }
    }
  }
}
</script>
