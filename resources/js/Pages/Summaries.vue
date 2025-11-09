<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Summaries</h1>

    <div v-if="loading" class="text-gray-500">Loading...</div>
    <div v-else>
      <div
        v-for="summary in summaries.data"
        :key="summary.id"
        class="p-4 mb-3 bg-white rounded shadow"
      >
        <a :href="summary.url" target="_blank" class="text-blue-600 font-semibold">
          {{ summary.url }}
        </a>
        <p class="mt-2 text-gray-700">{{ summary.summary }}</p>
        <small class="text-gray-400">{{ formatDate(summary.created_at) }}</small>
      </div>

      <div class="my-2 text-gray-600">
        Page {{ summaries.current_page }} of {{ summaries.last_page }} |
        Total items: {{ summaries.total }}
      </div>

      <div class="flex justify-center space-x-2 mt-4">
        <button
          :disabled="!summaries.prev_page_url"
          @click="fetchPage(summaries.current_page - 1)"
          class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
        >
          Previous
        </button>

        <button
          v-for="page in pageNumbers"
          :key="page"
          @click="fetchPage(page)"
          :class="['px-3 py-1 rounded', page === summaries.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200']"
        >
          {{ page }}
        </button>

        <button
          :disabled="!summaries.next_page_url"
          @click="fetchPage(summaries.current_page + 1)"
          class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { ref, computed, onMounted } from "vue";
  import axios from "axios";

  const summaries = ref({ data: [] });
  const loading = ref(true);

  async function fetchPage(page = 1) {
    loading.value = true;
    try {
      const response = await axios.get("/api/summaries?page=" + page);
      summaries.value = response.data;
    } catch (error) {
      console.error("Error fetching summaries:", error);
    } finally {
      loading.value = false;
    }
  }

  const pageNumbers = computed(() => {
    if (!summaries.value.last_page) return [];
    return Array.from({ length: summaries.value.last_page }, (_, i) => i + 1);
  });

  onMounted(() => {
    fetchPage();
  });

  function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleString();
  }
</script>
