<template>
  <div class=" w-full skeleton-table ">
    <div class="skeleton-row" v-for="n in rowCount" :key="n">
      <div class="skeleton-cell" v-for="m in columnCount" :key="m"></div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    rowCount: {
      type: Number,
      default: 5,
    },
    columnCount: {
      type: Number,
      default: 5,
    },
  },
};
</script>
<style>
.skeleton-table {
  width: 100%;
  border-collapse: collapse;
}

.skeleton-row {
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #ccc;
}

.skeleton-cell {
  width: calc(100% / 5);
  height: 1.5rem;
  border: 1px solid #ccc;
  background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
  background-size: 200% 100%;
  animation: loading 1.5s infinite;
  padding: 20px 30px;
}

@keyframes loading {
  0% {
    background-position: 200% 0;
  }
  100% {
    background-position: -200% 0;
  }
}
</style>