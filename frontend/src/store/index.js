import { createStore } from 'vuex';
import api from '../utils/axiosConfig';

export default createStore({
  state: {
    months: null,
    tonnage: null,
    type: null,
    price_list: null,
    price: null,
    errorMessage: null,
  },
  
  mutations: {
    setMonths(state, months) {
      state.months = months;
    },
    setTonnage(state, tonnage) {
      state.tonnage = tonnage;
    },
    setType(state, type) {
      state.type = type;
    },
    setTotalCost(state, totalCost) {
      state.price_list = totalCost.price_list;
      state.price = totalCost.price;
    },
    clearResult(state) {
      state.price_list = null;
      state.price = null;
    },
    setErrorMessage(state, message) {
      state.errorMessage = message;
    },
    clearErrorMessage(state) {
      state.errorMessage = null;
    }
  },
  actions: {
    async fetchMonthsOptions({ commit }) {
      try {
        const response = await api.get('/months');
        commit('setMonths', response.data);
        return response.data;
      } catch (error) {
        commit('setErrorMessage', "Ошибка при получении месяцев");
        console.error("Ошибка при получении месяцев:", error);
      }
    },

    async fetchTonnageOptions({ commit }) {
      try {
        const response = await api.get('/tonnages');
        commit('setTonnage', response.data);
        return response.data;
      } catch (error) {
        commit('setErrorMessage', "Ошибка при получении месяцев");
        console.error("Ошибка при получении тоннажа:", error);
      }
    },

    async fetchTypeOptions({ commit }) {
      try {
        const response = await api.get('/types');
        commit('setType', response.data);
        return response.data;
      } catch (error) {
        commit('setErrorMessage', "Ошибка при получении месяцев");
        console.error("Ошибка при получении типов:", error);
      }
    },

    async calculateTotalCost({ commit }, payload) {
      try {
        const params = new URLSearchParams(payload).toString();
        const response = await api.get(`/prices?${params}`);
        commit('setTotalCost', response.data);
        return response.data;
      } catch (error) {
        commit('setErrorMessage', error.response.data.message);
        console.error("Ошибка при расчете стоимости:", error.response.data.message);
      }
    },
    clearPrice({ commit }) {
      commit('clearResult');
    },
  }
});
