<script >
import { defineComponent } from "vue"

import NotificationComponent from './components/ui/TheNotification.vue'
import TheCalculate from './page/calculate/TheDetail.vue'

export  default defineComponent({
  name: 'App',

  components: {
    TheCalculate,
    NotificationComponent,
  },

  mounted() {
    document.title = " Калькулятор расчета доставки сырья";
  }
})
</script>

<template>
  <main  class=" mx-auto h-screen bg-slate-50 main-section">
    <the-calculate/>
    <notification-component />
  </main>
</template>

<style>
    main {
      padding: 0;
    }
</style>
