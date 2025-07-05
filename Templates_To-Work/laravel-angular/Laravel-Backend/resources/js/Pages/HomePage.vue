<!-- resources/js/Pages/HomePage.vue -->
<template>
  <div class="home-container">
    <!-- Hero Section -->
    <HeroSection 
      :initial-search="filters.search" 
      @search="onSearch" 
    />

    <!-- Stats Cards -->
    <StatsCards :stats="stats" />

    <!-- Main Content -->
    <div class="main-content">
      <div class="content-grid">
        <!-- Sidebar -->
        <Sidebar 
          :popular-categories="popularCategories" 
          :recent-documents="recentDocuments"
          @filter-change="onFilterChange"
        />

        <!-- Documents Area -->
        <main class="documents-area">
          <!-- Filters -->
          <div class="filters-section" data-aos="fade-up">
            <div class="filters-header">
              <h2 class="filters-title">Browse Documents</h2>
              <div class="filters-actions">
                <div class="view-toggle">
                  <button 
                    :class="['view-btn', viewMode==='grid' ? 'active' : '']" 
                    @click="viewMode='grid'" 
                    data-view="grid"
                  >
                    <i class="fas fa-th"></i>
                  </button>
                  <button 
                    :class="['view-btn', viewMode==='list' ? 'active' : '']" 
                    @click="viewMode='list'" 
                    data-view="list"
                  >
                    <i class="fas fa-list"></i>
                  </button>
                </div>
              </div>
            </div>
            <form @submit.prevent="onFilterSubmit" class="filters-form">
              <input type="hidden" name="search" :value="filters.search">
              <div class="filter-group">
                <select v-model="filters.category" class="filter-select">
                  <option value="">All Categories</option>
                  <option 
                    v-for="cat in categories" 
                    :key="cat.id" 
                    :value="cat.id"
                  >
                    {{ cat.nom }}
                  </option>
                </select>
              </div>
              <div class="filter-group">
                <select v-model="filters.type" class="filter-select">
                  <option value="">All Types</option>
                  <option 
                    v-for="t in documentTypes" 
                    :key="t" 
                    :value="t"
                  >
                    {{ t.charAt(0).toUpperCase() + t.slice(1) }}
                  </option>
                </select>
              </div>
              <div class="filter-group">
                <select v-model="filters.sort_by" class="filter-select">
                  <option value="created_at">Date</option>
                  <option value="title">Title</option>
                  <option value="type">Type</option>
                </select>
              </div>
              <div class="filter-group">
                <select v-model="filters.sort_order" class="filter-select">
                  <option value="desc">Newest First</option>
                  <option value="asc">Oldest First</option>
                </select>
              </div>
              <button type="submit" class="filter-apply-btn">
                <i class="fas fa-filter me-2"></i>Apply Filters
              </button>
              <button 
                v-if="filters.search || filters.category || filters.type" 
                @click.prevent="resetFilters" 
                class="filter-clear-btn"
              >
                <i class="fas fa-times me-2"></i>Clear
              </button>
            </form>
          </div>

          <!-- Documents Grid/List -->
          <DocumentsGrid 
            :documents="documents" 
            :view-mode="viewMode"
            @view-details="openModal"
          />
          
          <!-- Load More / Pagination -->
          <div class="pagination-wrapper" data-aos="fade-up" v-if="meta.current_page < meta.last_page">
            <button @click="loadMore" class="filter-apply-btn">Load More</button>
          </div>
        </main>
      </div>
    </div>

    <!-- Document Modal -->
    <DocumentModal 
      :document-id="currentDocId" 
      :visible="modalVisible" 
      @close="modalVisible = false" 
      @open-related="openModal"
    />
  </div>
</template>

<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
import HeroSection from '../Components/HeroSection.vue';
import StatsCards from '../Components/StatsCards.vue';
import Sidebar from '../Components/Sidebar.vue';
import DocumentsGrid from '../Components/DocumentsGrid.vue';
import DocumentModal from '../Components/DocumentModal.vue';

export default {
  components: { HeroSection, StatsCards, Sidebar, DocumentsGrid, DocumentModal },
  props: {
    initialDocuments: { type: Object, required: true },
    categories: { type: Array, required: true },
    documentTypes: { type: Array, required: true },
    recentDocuments: { type: Array, required: true },
    popularCategories: { type: Array, required: true },
    stats: { type: Object, required: true },
    search: { type: String, default: '' },
    categoryId: { type: [String, Number], default: '' },
    type: { type: String, default: '' },
    sortBy: { type: String, default: 'created_at' },
    sortOrder: { type: String, default: 'desc' },
  },
  setup(props) {
    const documents = ref(Array.isArray(props.initialDocuments.data) ? props.initialDocuments.data : []);
    const meta = ref(props.initialDocuments.meta || {});
    const filters = reactive({
      search: props.search || '',
      category: props.categoryId || '',
      type: props.type || '',
      sort_by: props.sortBy || 'created_at',
      sort_order: props.sortOrder || 'desc'
    });
    const viewMode = ref('grid');

    // Modal state
    const currentDocId = ref(null);
    const modalVisible = ref(false);

    const openModal = (id) => {
      currentDocId.value = id;
      modalVisible.value = true;
    };

    const loadMore = async () => {
      if (!meta.value.current_page || meta.value.current_page >= meta.value.last_page) {
        return;
      }
      const nextPage = meta.value.current_page + 1;
      const params = {
        search: filters.search,
        category: filters.category,
        type: filters.type,
        sort_by: filters.sort_by,
        sort_order: filters.sort_order,
        page: nextPage
      };
      try {
        const res = await axios.get(window.location.pathname, {
          params,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (res.data && res.data.documents) {
          const data = res.data.documents;
          if (Array.isArray(data.data)) {
            documents.value.push(...data.data);
            meta.value = data.meta;
          }
        }
      } catch (e) {
        console.error('loadMore error', e);
      }
    };

    const onSearch = (newSearch) => {
      filters.search = newSearch;
      applyFilters();
    };
    const onFilterChange = (newFilters) => {
      Object.assign(filters, newFilters);
      applyFilters();
    };
    const onFilterSubmit = () => {
      applyFilters();
    };
    const applyFilters = async () => {
      const params = {
        search: filters.search,
        category: filters.category,
        type: filters.type,
        sort_by: filters.sort_by,
        sort_order: filters.sort_order,
        page: 1
      };
      try {
        const res = await axios.get(window.location.pathname, {
          params,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (res.data && res.data.documents) {
          const data = res.data.documents;
          documents.value = Array.isArray(data.data) ? data.data : [];
          meta.value = data.meta;
        }
      } catch (e) {
        console.error('applyFilters error', e);
      }
    };
    const resetFilters = () => {
      filters.search = '';
      filters.category = '';
      filters.type = '';
      filters.sort_by = 'created_at';
      filters.sort_order = 'desc';
      applyFilters();
    };

    onMounted(() => {
      if (window.AOS) {
        window.AOS.init({ duration: 800, easing: 'ease-in-out', once: true });
      }
    });

    return {
      documents,
      meta,
      filters,
      viewMode,
      categories: props.categories,
      documentTypes: props.documentTypes,
      popularCategories: props.popularCategories,
      recentDocuments: props.recentDocuments,
      stats: props.stats,
      loadMore,
      onSearch,
      onFilterChange,
      onFilterSubmit,
      resetFilters,
      // Modal
      currentDocId,
      modalVisible,
      openModal
    };
  }
};
</script>

<style scoped>
.home-container {
  min-height: 100vh;
  background: var(--gradient-bg);
}
.content-grid {
  display: grid;
  grid-template-columns: 300px 1fr;
  gap: 3rem;
  max-width: 1400px;
  margin: 0 auto;
}
.documents-area {
  background: var(--bg-card);
  border-radius: 16px;
  padding: 2rem;
  border: 1px solid var(--border-color);
  box-shadow: var(--shadow-md);
}
.filters-form {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
  align-items: center;
  margin-top: 1rem;
}
.filter-select {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid var(--border-color);
  border-radius: 8px;
  background: var(--bg-secondary);
  color: var(--text-primary);
  font-weight: 500;
}
.filter-apply-btn, .filter-clear-btn {
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  border: none;
}
.filter-apply-btn {
  background: var(--gradient-primary);
  color: white;
}
.filter-clear-btn {
  background: var(--bg-secondary);
  color: var(--text-secondary);
  border: 1px solid var(--border-color);
}
.view-btn {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  border: 1px solid var(--border-color);
  background: var(--bg-secondary);
  color: var(--text-secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}
.view-btn.active {
  background: var(--primary-color);
  color: white;
  border-color: var(--primary-color);
}
.pagination-wrapper {
  display: flex;
  justify-content: center;
  margin-top: 2rem;
}
/* Additional scoped styles as needed */
</style>
