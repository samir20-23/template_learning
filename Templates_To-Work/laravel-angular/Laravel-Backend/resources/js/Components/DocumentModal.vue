<!-- resources/js/Components/DocumentModal.vue -->
<template>
  <transition name="modal-fade">
    <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
          <h3 class="text-xl font-semibold">{{ doc.title }}</h3>
          <button @click="close" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="p-4 max-h-[80vh] overflow-auto">
          <p class="mb-4 text-gray-700">{{ doc.description }}</p>
          <ul class="space-y-2 text-sm text-gray-600">
            <li><strong>Type:</strong> {{ doc.type.toUpperCase() }}</li>
            <li><strong>Category:</strong> {{ doc.categorie.nom }}</li>
            <li><strong>Uploaded by:</strong> {{ doc.user.name }}</li>
            <li><strong>Created at:</strong> {{ formatDate(doc.created_at) }}</li>
            <li><strong>Downloads:</strong> {{ doc.download_count }}</li>
          </ul>
          <div v-if="related.length" class="mt-6">
            <h4 class="font-semibold mb-2">Related Documents</h4>
            <ul class="space-y-2">
              <li v-for="r in related" :key="r.id">
                <button 
                  @click="openRelated(r.id)" 
                  class="text-blue-600 hover:underline"
                >
                  {{ r.title }} — {{ formatDate(r.created_at) }}
                </button>
              </li>
            </ul>
          </div>
        </div>
        <div class="flex justify-end items-center p-4 border-t space-x-2">
          <button 
            @click="downloadDoc" 
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
          >
            <i class="fas fa-download me-2"></i>Download
          </button>
          <button @click="close" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
            Close
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import { ref, watch } from 'vue';
import axios from 'axios';

export default {
  props: {
    documentId: { type: [Number, String], default: null },
    visible: { type: Boolean, default: false },
  },
  emits: ['close', 'open-related'],
  setup(props, { emit }) {
    const doc = ref({
      id: null, title: '', description: '', type: '', categorie: { nom: '' }, created_at: '', download_count: 0, user: { name: '' }
    });
    const related = ref([]);

    const fetchDetails = async (id) => {
      try {
        const res = await axios.get(`/documents/${id}`, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (res.data && res.data.document) {
          doc.value = res.data.document;
          related.value = res.data.related || [];
        }
      } catch (e) {
        console.error('Error fetching document details', e);
      }
    };

    watch(() => props.documentId, (newId) => {
      if (newId) {
        fetchDetails(newId);
      }
    });

    const close = () => {
      emit('close');
    };
    const openRelated = (id) => {
      // emit event so parent can set documentId to new id
      emit('open-related', id);
    };
    const downloadDoc = () => {
      // Open download in new tab/window to avoid refresh
      window.open(`/documents/${doc.value.id}/download`, '_blank');
    };
    const formatDate = (dt) => {
      return new Date(dt).toLocaleDateString();
    };

    return { doc, related, close, openRelated, downloadDoc, formatDate };
  }
};
</script>

<style scoped>
.modal-fade-enter-active, .modal-fade-leave-active {
  transition: opacity 0.2s ease;
}
.modal-fade-enter-from, .modal-fade-leave-to {
  opacity: 0;
}
</style>
