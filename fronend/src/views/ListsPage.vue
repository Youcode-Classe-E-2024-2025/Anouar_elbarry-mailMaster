<template>
  <div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-3xl font-bold">Listes d'abonnés</h1>
      <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700" @click="showAddModal = true">
        Nouvelle liste
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="list in lists" :key="list.id" class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-2">
          <h2 class="text-xl font-semibold">{{ list.name }}</h2>
          <div class="flex gap-2">
            <button @click="editList(list)" class="text-blue-600 hover:underline">Modifier</button>
            <button @click="deleteList(list.id)" class="text-red-600 hover:underline">Supprimer</button>
          </div>
        </div>
        <p class="text-gray-600 mb-2">{{ list.description }}</p>
        <div class="text-sm text-gray-500">{{ list.subscriberCount }} abonnés</div>
        <div class="mt-4">
          <button class="px-4 py-2 border rounded-md w-full">Voir les abonnés</button>
        </div>
      </div>
    </div>

    <!-- Modal pour ajouter une liste -->
    <div v-if="showAddModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
      <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Nouvelle liste</h2>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Nom de la liste</label>
          <input v-model="newList.name" type="text" class="w-full border rounded-md px-3 py-2" />
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
          <textarea v-model="newList.description" class="w-full border rounded-md px-3 py-2" rows="3"></textarea>
        </div>
        <div class="flex justify-end gap-2">
          <button @click="showAddModal = false" class="px-4 py-2 border rounded-md">Annuler</button>
          <button @click="addList" class="px-4 py-2 bg-blue-600 text-white rounded-md">Ajouter</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ListsPage',
  data() {
    return {
      lists: [
        { id: 1, name: 'Newsletter', description: 'Liste principale pour les newsletters mensuelles', subscriberCount: 1245 },
        { id: 2, name: 'Promotions', description: 'Abonnés intéressés par les offres spéciales', subscriberCount: 987 },
        { id: 3, name: 'Mises à jour produit', description: 'Pour les annonces de nouveaux produits et fonctionnalités', subscriberCount: 756 }
      ],
      showAddModal: false,
      newList: {
        name: '',
        description: ''
      }
    }
  },
  mounted() {
    // Fetch lists from API
    this.fetchLists();
  },
  methods: {
    fetchLists() {
      // API call to fetch lists
      // axios.get('/api/lists').then(response => {
      //   this.lists = response.data;
      // });
    },
    editList(list) {
      // Implementation for editing list
    },
    deleteList(id) {
      // Implementation for deleting list
      if (confirm('Êtes-vous sûr de vouloir supprimer cette liste ?')) {
        // axios.delete(`/api/lists/${id}`).then(() => {
        //   this.lists = this.lists.filter(l => l.id !== id);
        // });
      }
    },
    addList() {
      // Add new list
      // axios.post('/api/lists', this.newList).then(response => {
      //   this.lists.push(response.data);
      //   this.newList = { name: '', description: '' };
      //   this.showAddModal = false;
      // });
    }
  }
}
</script>