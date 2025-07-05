<!-- resources/js/Components/DocumentsGrid.vue -->
<template>
  <div>
    <div v-if="documents.length === 0" class="no-documents text-center py-10">
      <i class="fas fa-search text-3xl text-gray-400"></i>
      <h3 class="no-documents-title mt-4">No documents found</h3>
      <p class="no-documents-text mt-2">Try adjusting your search criteria or browse different categories.</p>
      <button @click="reset" class="btn-view mt-3">
        <i class="fas fa-refresh me-2"></i>Reset Filters
      </button>
    </div>
    <div v-else class="documents-grid" :class="{'list-view': viewMode==='list'}">
      <DocumentCard 
        v-for="doc in documents" 
        :key="doc.id" 
        :document="doc" 
        :view-mode="viewMode"
        @view-details="$emit('view-details', $event)"
      />
    </div>
  </div>
</template>

<script>
import DocumentCard from './DocumentCard.vue';
export default {
  components: { DocumentCard },
  props: {
    documents: { type: Array, required: true },
    viewMode: { type: String, default: 'grid' }
  },
  emits: ['view-details'],
  setup(props, { emit }) {
    const reset = () => {
      window.location.href = window.location.pathname;
    };
    return { reset };
  }
};
</script>
