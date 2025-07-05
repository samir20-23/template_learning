<!-- resources/js/Components/HeroSection.vue -->
<template>
  <div class="hero-section" data-aos="fade-up">
    <div class="hero-content">
      <h1 class="hero-title">Welcome to Document Library</h1>
      <p class="hero-subtitle">Discover, download, and share educational resources and documents</p>
      <div class="hero-search">
        <form @submit.prevent="submitSearch" class="search-form">
          <div class="search-input-group">
            <i class="fas fa-search search-icon"></i>
            <input 
              v-model="searchTerm" 
              type="text" 
              :placeholder="placeholder" 
              class="search-input"
            >
            <button type="submit" class="search-btn">
              <i class="fas fa-arrow-right"></i>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
export default {
  props: {
    initialSearch: { type: String, default: '' },
    placeholder: { type: String, default: 'Search documents, categories, or file types...' }
  },
  setup(props, { emit }) {
    const searchTerm = ref(props.initialSearch);
    const submitSearch = () => {
      emit('search', searchTerm.value);
    };
    return { searchTerm, submitSearch };
  }
};
</script>

<style scoped>
.hero-section {
  background: var(--gradient-card);
  padding: 4rem 2rem;
  border-radius: 0 0 2rem 2rem;
  margin-bottom: 3rem;
  border: 1px solid var(--border-color);
}
.hero-content {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 3rem;
}
.hero-title {
  font-size: 3rem;
  font-weight: 800;
  color: var(--text-primary);
  margin-bottom: 1rem;
  background: var(--gradient-primary);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}
.hero-subtitle {
  font-size: 1.25rem;
  color: var(--text-secondary);
  margin-bottom: 2rem;
  font-weight: 500;
}
.hero-search {
  max-width: 600px;
  margin: 0 auto;
}
.search-form {
  position: relative;
}
.search-input-group {
  position: relative;
  display: flex;
  align-items: center;
  background: var(--bg-card);
  border: 2px solid var(--border-color);
  border-radius: 50px;
  padding: 0.75rem 1.5rem;
  box-shadow: var(--shadow-lg);
  transition: all 0.3s ease;
}
.search-input-group:focus-within {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}
.search-icon {
  color: var(--text-muted);
  margin-right: 1rem;
  font-size: 1.1rem;
}
.search-input {
  flex: 1;
  border: none;
  outline: none;
  background: transparent;
  font-size: 1.1rem;
  color: var(--text-primary);
  font-weight: 500;
}
.search-input::placeholder {
  color: var(--text-muted);
}
.search-btn {
  background: var(--gradient-primary);
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-left: 1rem;
}
.search-btn:hover {
  transform: scale(1.1);
  box-shadow: var(--shadow-md);
}
</style>
