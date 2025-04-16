<template>
  <div class="campaign-create">
    <h2>Create Campaign</h2>
    <form @submit.prevent="createCampaign">
      <input 
        v-model="campaignData.title" 
        placeholder="Campaign Title" 
        required
      />
      <input 
        v-model="campaignData.subject" 
        placeholder="Email Subject" 
        required
      />
      <textarea 
        v-model="campaignData.content" 
        placeholder="Campaign Content" 
        required
      ></textarea>
      <select 
        v-model="campaignData.list_id" 
        required
      >
        <option 
          v-for="list in lists" 
          :key="list.id" 
          :value="list.id"
        >
          {{ list.name }}
        </option>
      </select>
      <button type="submit">Create Campaign</button>
    </form>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { campaignService } from '@/services/api';

export default {
  setup() {
    const campaignData = ref({
      title: '',
      subject: '',
      content: '',
      list_id: null
    });

    const lists = ref([]);

    const createCampaign = async () => {
      try {
        const response = await campaignService.create(campaignData.value);
        alert('Campaign created successfully!');
        // Reset form or navigate
      } catch (error) {
        alert('Failed to create campaign');
      }
    };

    const fetchLists = async () => {
      try {
        // Implement list fetching logic
        // lists.value = await listService.getLists();
      } catch (error) {
        console.error('Failed to fetch lists');
      }
    };

    onMounted(fetchLists);

    return {
      campaignData,
      lists,
      createCampaign
    };
  }
}
</script>