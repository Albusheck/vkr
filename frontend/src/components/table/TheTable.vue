<template>
  <table class=" w-full divide-y  border-collapse">
    <thead class="bg-gray-100 rounded-t-lg">
      <tr>
        <th class="px-6 py-3 text-center text-sm font-bold text-slate-700 uppercase tracking-wider  border-gray-300">
          Т/M
        </th>
        <th 
          v-for="tonnage in getTonnages" 
          :key="tonnage" 
          class="px-6 py-3 text-center text-sm font-bold text-slate-700 uppercase tracking-wider  border-gray-300"
        >
          {{ tonnage }}
        </th>
      </tr>
    </thead>
    <tbody class="text-center">
      <tr 
        v-for="(month, index) in getMonths" 
        :key="month" 
        :class="index % 2 === 0 ? '' : 'bg-gray-100'"
      >
        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700  text-center ">
          {{ month }}
        </td>
        <td 
          v-for="tonnage in getPricesByMonth(month)"
          :key="tonnage.tonnage"
          class="px-6 py-4 whitespace-nowrap "
          :class="getStyles(month, tonnage.tonnage)"
        >
          {{ tonnage.price }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>

import { mapState } from 'vuex';

export default {
  props: {
    prices: Object,
    selectedMonth: String,
    selectedTonnage: Number,
    selectedType: String
  },
  computed: {
    ...mapState(['price_list']),

    getTonnages() {
      return Object.keys(this.price_list[this.selectedType]?.[this.selectedMonth] || {}); //
    },
    
    getMonths() {
      return Object.keys(this.price_list[this.selectedType] || {});
    },
  },
  methods: {
    getPricesByMonth(month) {
      const monthData = this.price_list[this.selectedType]?.[month] || {};
      return Object.keys(monthData).map(tonnage => ({ tonnage, price: monthData[tonnage] }));
    },

    getStyles(month, tonnage) {
      if (this.selectedMonth === month && this.selectedTonnage === parseInt(tonnage, 10)) {
        return 'selected-cell'; 
      }
      return '';
    }
  }
};
</script>

<style scoped>

.selected-cell {
  background: orange;
  color: white;
  font-weight: bold;
  border-radius: 5px;
}
  table tr td:last-child {border-radius: 0 5px 5px 0}
  table tr td:first-child {border-radius: 5px 0 0 5px}

  table tr th:last-child {border-radius: 0 5px 5px 0}
  table tr th:first-child {border-radius: 5px 0 0 5px}
</style>