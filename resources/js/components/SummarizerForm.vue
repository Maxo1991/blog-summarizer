<template>
  <div class="max-w-lg mx-auto mt-10 p-4 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">AI Blog Summarizer</h2>
    
    <input
      v-model="url"
      type="text"
      placeholder="Enter blog post URL"
      class="w-full p-2 border rounded mb-2"
    />
    
    <button
      @click="submit"
      class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
    >
      Summarize
    </button>

    <div v-if="summary" class="mt-4 p-2 bg-gray-100 rounded">
      <h3 class="font-semibold">Summary:</h3>
      <p>{{ summary }}</p>
    </div>

    <div v-if="error" class="mt-2 text-red-500">{{ error }}</div>

    <div class="mt-6">
      <a
        href="http://127.0.0.1:8000/summaries"
        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600"
      >
        View All Summaries
      </a>
    </div>
  </div>
</template>

<script setup>
  import { ref } from 'vue';
  import axios from 'axios';

  const url = ref('');
  const summary = ref('');
  const error = ref('');

  const submit = async () => {
    summary.value = '';
    error.value = '';
    
    try {
      const response = await axios.post('/api/summarize', { url: url.value });
      summary.value = response.data.summary;
    } catch (e) {
      error.value = e.response?.data?.message || 'Something went wrong';
    }
  };
</script>

<style scoped>
</style>
