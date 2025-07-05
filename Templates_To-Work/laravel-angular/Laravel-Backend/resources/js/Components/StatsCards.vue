<!-- resources/js/Components/StatsCards.vue -->
<template>
  <div class="stats-grid">
    <div 
      v-for="(c, idx) in cards" 
      :key="idx" 
      class="stat-card" 
      data-aos="fade-up" 
      :data-aos-delay="100*(idx+1)"
    >
      <div class="stat-icon">
        <i :class="['fas', c.icon]"></i>
      </div>
      <div class="stat-content">
        <h3 class="stat-number">{{ formatNumber(c.number) }}</h3>
        <p class="stat-label">{{ c.label }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    stats: { type: Object, required: true },
  },
  computed: {
    cards() {
      return [
        { icon: 'fa-file-alt', number: this.stats.total_documents, label: 'Total Documents' },
        { icon: 'fa-folder', number: this.stats.total_categories, label: 'Categories' },
        { icon: 'fa-upload', number: this.stats.user_uploads, label: 'Your Uploads' },
        { icon: 'fa-clock', number: this.stats.recent_uploads, label: 'This Week' },
      ];
    }
  },
  methods: {
    formatNumber(val) {
      return val.toLocaleString();
    }
  }
};
</script>

<style scoped>
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1.5rem;
  max-width: 1000px;
  margin: 0 auto;
}
.stat-card {
  background: var(--bg-card);
  border-radius: 16px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  border: 1px solid var(--border-color);
  box-shadow: var(--shadow-md);
  transition: all 0.3s ease;
}
.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}
.stat-icon {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--gradient-primary);
  color: white;
  font-size: 1.25rem;
}
.stat-number {
  font-size: 1.75rem;
  font-weight: 800;
  color: var(--text-primary);
  margin: 0;
}
.stat-label {
  color: var(--text-secondary);
  font-weight: 600;
  margin: 0;
}
</style>
