<template>
    <div class="container mx-auto px-4 py-6">
      <h1 class="text-3xl font-bold mb-6">Éditeur de modèles</h1>
      
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
          <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Nom du modèle</label>
              <input v-model="template.name" type="text" class="w-full border rounded-md px-3 py-2" placeholder="Ex: Newsletter Standard" />
            </div>
            
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
              <textarea v-model="template.description" class="w-full border rounded-md px-3 py-2 h-24" placeholder="Décrivez votre modèle..."></textarea>
            </div>
            
            <div class="mb-6">
              <h3 class="font-medium mb-2">Éléments disponibles</h3>
              <div class="space-y-2">
                <div v-for="(element, index) in availableElements" :key="index" 
                     class="p-2 bg-gray-100 rounded-md cursor-pointer hover:bg-gray-200"
                     @click="addElementToTemplate(element)">
                  {{ element.name }}
                </div>
              </div>
            </div>
            
            <div class="mb-4">
              <h3 class="font-medium mb-2">Variables disponibles</h3>
              <div class="space-y-2">
                <div v-for="(variable, index) in availableVariables" :key="index" 
                     class="p-2 bg-gray-100 rounded-md cursor-pointer hover:bg-gray-200"
                     @click="insertVariable(variable)">
                  {{ variable.name }}
                </div>
              </div>
            </div>
            
            <div class="flex gap-4 justify-between">
              <button class="px-4 py-2 border rounded-md">Prévisualiser</button>
              <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Enregistrer</button>
            </div>
          </div>
        </div>
        
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4 flex justify-between">
              <div class="flex gap-2">
                <button class="px-3 py-1 border rounded-md">Texte</button>
                <button class="px-3 py-1 border rounded-md">Image</button>
                <button class="px-3 py-1 border rounded-md">Button</button>
                <button class="px-3 py-1 border rounded-md">Divider</button>
              </div>
              <div class="flex gap-2">
                <button class="px-3 py-1 border rounded-md">Source HTML</button>
                <button class="px-3 py-1 border rounded-md">Mobile</button>
              </div>
            </div>
            
            <div class="border rounded-md p-2 min-h-96 bg-gray-50">
              <!-- Template Editor Canvas -->
              <div class="bg-white p-4 min-h-96">
                <div v-for="(section, index) in template.sections" :key="index" 
                     class="mb-4 p-4 border rounded-md relative hover:border-blue-500 cursor-pointer"
                     @click="editSection(index)">
                  <div class="absolute top-2 right-2 flex gap-1">
                    <button class="text-gray-500 hover:text-gray-700">↑</button>
                    <button class="text-gray-500 hover:text-gray-700">↓</button>
                    <button class="text-gray-500 hover:text-gray-700" @click.stop="removeSection(index)">×</button>
                  </div>
                  
                  <div v-if="section.type === 'header'">
                    <h2 class="text-2xl font-bold">{{ section.content }}</h2>
                  </div>
                  
                  <div v-else-if="section.type === 'text'">
                    <p>{{ section.content }}</p>
                  </div>
                  
                  <div v-else-if="section.type === 'image'" class="flex justify-center">
                    <img :src="section.url" :alt="section.alt" class="max-w-full h-auto" />
                  </div>
                  
                  <div v-else-if="section.type === 'button'" class="flex justify-center">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-md">{{ section.text }}</button>
                  </div>
                  
                  <div v-else-if="section.type === 'divider'" class="border-t my-4"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Modal d'édition de section (à implémenter) -->
      <div v-if="showSectionEditor" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <!-- Modal content goes here -->
      </div>
    </div>
  </template>

<script>
export default {
  name: 'TemplateEditor',
  data() {
    return {
      template: {
        name: '',
        description: '',
        sections: [
          { type: 'header', content: 'Titre de la newsletter' },
          { type: 'text', content: 'Voici le contenu de notre newsletter mensuelle avec toutes les dernières actualités.' },
          { type: 'image', url: '/api/placeholder/600/300', alt: 'Image descriptive' },
          { type: 'text', content: 'Découvrez nos dernières offres et promotions.' },
          { type: 'button', text: 'En savoir plus', url: '#' },
          { type: 'divider' },
          { type: 'text', content: 'À bientôt !' }
        ]
      },
      availableElements: [
        { name: 'En-tête', type: 'header' },
        { name: 'Paragraphe', type: 'text' },
        { name: 'Image', type: 'image' },
        { name: 'Bouton', type: 'button' },
        { name: 'Séparateur', type: 'divider' }
      ],
      availableVariables: [
        { name: '{{subscriber.name}}', value: 'subscriber.name' },
        { name: '{{subscriber.email}}', value: 'subscriber.email' },
        { name: '{{date}}', value: 'date' },
        { name: '{{unsubscribe_link}}', value: 'unsubscribe_link' }
      ],
      showSectionEditor: false,
      currentSection: null
    }
  },
  mounted() {
    // Fetch template data if editing an existing template
    this.fetchTemplateData();
  },
  methods: {
    fetchTemplateData() {
      // If editing an existing template, fetch its data
      const templateId = this.$route.params.id;
      if (templateId) {
        // axios.get(`/api/templates/${templateId}`).then(response => {
        //   this.template = response.data;
        // });
      }
    },
    addElementToTemplate(element) {
      let newSection = { type: element.type };
      
      // Set default content based on element type
      switch (element.type) {
        case 'header':
          newSection.content = 'Nouveau titre';
          break;
        case 'text':
          newSection.content = 'Nouveau paragraphe';
          break;
        case 'image':
          newSection.url = '/api/placeholder/600/300';
          newSection.alt = 'Description de l\'image';
          break;
        case 'button':
          newSection.text = 'Cliquez ici';
          newSection.url = '#';
          break;
      }
      
      this.template.sections.push(newSection);
    },
    insertVariable(variable) {
      // Insert variable at cursor position
      // This implementation depends on your editor
      console.log(`Inserting variable: ${variable.name}`);
    },
    editSection(index) {
      this.currentSection = index;
      this.showSectionEditor = true;
    },
    removeSection(index) {
      this.template.sections.splice(index, 1);
    },
    saveTemplate() {
      // Save template to API
      // axios.post('/api/templates', this.template).then(response => {
      //   this.$router.push('/templates');
      // });
    }
  }
}
</script>