<!-- resources/js/Components/Sidebar.vue -->
<template>
  <aside class="sidebar" data-aos="fade-right">
    <!-- Popular Categories -->
    <div class="sidebar-section">
      <h3 class="sidebar-title">
        <i class="fas fa-folder me-2"></i>Popular Categories
      </h3>
      <div class="category-list">
        <button 
          v-for="cat in popularCategories" 
          :key="cat.id" 
          class="category-item" 
          @click="selectCategory(cat.id)"
        >
          <span class="category-name">{{ cat.nom }}</span>
          <span class="category-count">{{ cat.documents_count }}</span>
        </button>
      </div>
    </div>
    <!-- Recent Documents -->
    <div class="sidebar-section">
      <h3 class="sidebar-title">
        <i class="fas fa-clock me-2"></i>Recent Documents
      </h3>
      <div class="recent-list">
        <button 
          v-for="doc in recentDocuments" 
          :key="doc.id" 
          class="recent-item"
          @click="viewDoc(doc.id)"
        >
          <div class="recent-icon">
            <i :class="['fas', doc.type==='pdf' ? 'fa-file-pdf' : 'fa-file-alt']"></i>
          </div>
          <div class="recent-content">
            <p class="recent-title">{{ doc.title.length>30? doc.title.slice(0,27)+'...':doc.title }}</p>
            <small class="recent-date">{{ formatDate(doc.created_at) }}</small>
          </div>
        </button>
      </div>
    </div>
    <!-- Quick Upload -->
    <div class="sidebar-section">
      <div class="quick-upload-card">
        <h4 class="quick-upload-title">Share a Document</h4>
        <p class="quick-upload-text">Upload and share your educational resources</p>
        <button class="quick-upload-btn" @click="goUpload">
          <i class="fas fa-plus me-2"></i>Upload Document
        </button>
      </div>
    </div>
  </aside>
</template>

<script>
export default {
  props: {
    popularCategories: { type: Array, required: true },
    recentDocuments: { type: Array, required: true },
  },
  emits: ['filter-change'],
  setup(props, { emit }) {
    const selectCategory = (catId) => {
      emit('filter-change', { category: catId });
    };
    const viewDoc = (id) => {
      window.location.href = `/documents/${id}`;
    };
    const goUpload = () => {
      window.location.href = `/documents/create`;
    };
    const formatDate = (dt) => {
      return new Date(dt).toLocaleDateString();
    };
    return { selectCategory, viewDoc, goUpload, formatDate };
  }
};
</script>

<style scoped>
.sidebar {
  background: var(--bg-card);
  border-radius: 16px;
  padding: 2rem;
  border: 1px solid var(--border-color);
  box-shadow: var(--shadow-md);
  position: sticky;
  top: 2rem;
}
.sidebar-section {
  margin-bottom: 2rem;
}
.sidebar-title {
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--text-primary);
  margin-bottom: 1rem;
  display: flex;
  align-items: center;
}
.category-list {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.category-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem;
  border-radius: 8px;
  background: transparent;
  border: 1px solid transparent;
  color: var(--text-secondary);
  transition: all 0.3s ease;
}
.category-item:hover {
  background: var(--bg-secondary);
  color: var(--primary-color);
  border-color: var(--border-color);
}
.category-name {
  font-weight: 500;
}
.category-count {
  background: var(--bg-secondary);
  color: var(--text-muted);
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-size: 0.875rem;
  font-weight: 600;
}
.recent-list {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}
.recent-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem;
  border-radius: 8px;
  border: 1px solid transparent;
  transition: all 0.3s ease;
}
.recent-item:hover {
  background: var(--bg-secondary);
  border-color: var(--border-color);
}
.recent-icon {
  width: 35px;
  height: 35px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-secondary);
  color: var(--primary-color);
  flex-shrink: 0;
}
.recent-title {
  font-weight: 600;
  color: var(--text-primary);
  margin: 0 0 0.25rem;
  font-size: 0.875rem;
}
.recent-date {
  color: var(--text-muted);
  font-size: 0.75rem;
}
.quick-upload-card {
  background: var(--gradient-primary);
  border-radius: 12px;
  padding: 1.5rem;
  text-align: center;
  color: white;
}
.quick-upload-title {
  font-size: 1.1rem;
  font-weight: 700;
  margin-bottom: 0.5rem;
}
.quick-upload-text {
  font-size: 0.875rem;
  opacity: 0.9;
  margin-bottom: 1rem;
}
.quick-upload-btn {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  transition: all 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.quick-upload-btn:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: translateY(-2px);
}
</style>
