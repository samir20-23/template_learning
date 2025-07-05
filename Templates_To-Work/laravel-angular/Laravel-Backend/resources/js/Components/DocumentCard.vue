<!-- resources/js/Components/DocumentCard.vue -->
<template>
  <div :class="['document-card', viewMode==='list' ? 'list-item' : '']">
    <!-- ... header ... -->
    <div class="document-content">
      <h3 class="document-title">
        <button @click="viewDetails" class="hover:underline text-left w-full">
          {{ document.title }}
        </button>
      </h3>
      <div class="document-meta">
        <span class="document-category">
          <i class="fas fa-folder me-1"></i>
          {{ document.categorie.nom }}
        </span>
        <span class="document-date">
          <i class="fas fa-calendar me-1"></i>
          {{ formatDate(document.created_at) }}
        </span>
      </div>
    </div>
    <div class="document-footer">
      <button @click="viewDetails" class="btn-view">
        <i class="fas fa-eye me-2"></i>View
      </button>
      <button @click="downloadDirect" class="btn-download">
        <i class="fas fa-download me-2"></i>Download
      </button>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
export default {
  props: {
    document: { type: Object, required: true },
    viewMode: { type: String, default: 'grid' }
  },
  emits: ['view-details'],
  setup(props, { emit }) {
    const favorited = ref(false);
    const toggleFavorite = () => {
      favorited.value = !favorited.value;
    };
    const formatDate = (dt) => new Date(dt).toLocaleDateString();
    const viewDetails = () => {
      emit('view-details', props.document.id);
    };
    const downloadDirect = () => {
      window.open(`/documents/${props.document.id}/download`, '_blank');
    };
    return { favorited, toggleFavorite, formatDate, viewDetails, downloadDirect };
  }
};
</script>
