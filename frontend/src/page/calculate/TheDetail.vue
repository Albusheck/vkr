<template>
  <BadRequest v-if="!isLoading && badRequest"/>

  <section
    class="calculate mx-auto flex flex-col justify-center min-h-screen max-h-fit gap-5 items-center p-4"
    v-else-if="!isLoading && !badRequest"
  >
    <div class="calculate__container rounded-xl p-4">
      <h1
        class="calculate-title text-4xl text-center p-4 text-slate-800 font-bold flex flex-col justify-center gap-5"
      >
        Калькулятор расчета <br />
        доставки сырья
      </h1>

      <div
        :class="showSelect ? '' : 'animate-fade-out'"
        class="w-full flex relative justify-center p-3 my-6 animate-slide-up z-[9999]"
        v-if="showSelect"
      >
        <the-select
          v-for="stepConfig in filteredStepsConfig"
          :key="stepConfig.step"
          :options="stepConfig.options"
          :placeholder="stepConfig.placeholder"
          :title="stepConfig.title"
          @input="onSelection(stepConfig.step, $event)"
        />
      </div>

      <div
        class="flex justify-center my-6 w-full animate-slide-down"
        :class="allStepsCompleted ? 'animate-move-up' : ''"
      >
        <the-steps
          :current-step="step"
          :steps-info="stepsInfo"
          :all-steps-completed="allStepsCompleted"
          @change-step="handleStepChange"
        />
      </div>

      <div class="mx-auto" v-if="price">
        <div class="total list-group-item text-center my-4 text-slate-800">
          <h1 class="text-4xl">Выполнен расчет</h1>
          <div class="fs-3 my-2">
            <strong class="text-xl my-2 block"> Общая стоимость: </strong>
            <p class="text-4xl">{{ price }}</p>
          </div>
        </div>
        <price-table
          v-if="!isLoadingTable"
          :prices="prices"
          :selected-month="selected.month"
          :selected-tonnage="selected.tonnage"
          :selected-type="selected.type"
        />
      </div>

      <div
        class="flex justify-center my-8 mb-6"
        v-if="!showSelect && allStepsCompleted"
      >
        <button
          class="py-4 px-8 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600"
          @click="resetAndRecalculate"
        >
          Новый расчет
        </button>
      </div>

      <div class="w-6/12 mx-auto">
        <skeleton-table
          v-if="isLoadingTable"
          :row-count="7"
          :column-count="5"
        />
      </div>
    </div>
  </section>


</template>

<script>
import { mapState, mapActions } from 'vuex';

import TheSelect from '../../components/ui/input/TheSelect.vue';
import TheSteps from '../../components/ui/steps/TheSteps.vue';
import PriceTable from '../../components/table/TheTable.vue';
import SkeletonTable from '../../components/ui/skeleton/TheTable.vue';
import BadRequest from '../../components/BadRequest.vue'

export default {
  name: 'TheDetail',

  components: {
    TheSelect,
    TheSteps,
    PriceTable,
    SkeletonTable,
    BadRequest
  },

  data() {
    return {
      selected: { month: null, tonnage: null, type: null },
      badRequest: false,
      isLoading: false,
      isLoadingTable: false,
      step: 1,
      stepsConfig: null,
      allStepsCompleted: false,
      showSelect: true,
    };
  },

  computed: {
    ...mapState([
      'months',
      'tonnage',
      'type',
      'price',
    ]),

    filteredStepsConfig() {
      return this.stepsConfig.filter((config) => config.step === this.step);
    },

    stepsInfo() {
      return this.stepsConfig.map((config, index) => ({
        ...config,
        selectedOption: this.selected[config.key],
        done: this.step > index + 1,
      }));
    },
  },

  methods: {
    ...mapActions([
      'fetchMonthsOptions',
      'fetchTonnageOptions',
      'fetchTypeOptions',
      'calculateTotalCost',
      'clearPrice',
    ]),

    resetAndRecalculate() {
      this.clearPrice();
      this.selected = { month: null, tonnage: null, type: null };
      this.step = 1;
      this.allStepsCompleted = false;
      this.showSelect = true;
    },

    async loadData() {
      const isSuccess = await Promise.all([
        this.fetchMonthsOptions(),
        this.fetchTonnageOptions(),
        this.fetchTypeOptions(),
      ]);

      if(isSuccess.includes(false || undefined)) {
        this.badRequest = true;
      }
    },

    onSelection(step, value) {
      if (step === 1) this.selected.month = value;
      if (step === 2) this.selected.tonnage = value;
      if (step === 3) {
        setTimeout(() => {
          this.selected.type = value;
        }, 500);
        return;
      }
      this.step = step + 1;
    },

    async calculate() {
      const payload = {
        month: this.selected.month,
        tonnage: this.selected.tonnage,
        type: this.selected.type,
      };
      this.allStepsCompleted = true;
      this.showSelect = false;

      this.isLoadingTable = true;
      await this.calculateTotalCost(payload);
      this.isLoadingTable = false;
    },

    handleStepChange(newStep) {
      if (newStep <= this.step) {
        this.clearPrice();
        this.step = newStep;
        this.showSelect = true;

        for (let i = newStep; i <= this.stepsConfig.length; i++) {
          const key = this.stepsConfig[i - 1].key;
          this.selected[key] = null;
        }

        this.allStepsCompleted = false;
      }
    },
  },

  watch: {
    'selected.type'(newVal) {
      if (newVal && this.step === 3) {
        this.calculate();
      }
    },
  },

  async created() {
    this.isLoading = true;

    await this.loadData();

    this.stepsConfig = [
      {
        step: 1,
        key: 'month',
        options: this.months,
        placeholder: 'Выберите месяц',
        title: 'Месяц',
      },
      {
        step: 2,
        key: 'tonnage',
        options: this.tonnage,
        placeholder: 'Выберите тоннаж',
        title: 'Тоннаж',
      },
      {
        step: 3,
        key: 'type',
        options: this.type,
        placeholder: 'Выберите тип',
        title: 'Тип',
      },
    ];

    this.isLoading = false;
  },
};
</script>

<style lang="scss">
.calculate {
  position: relative;
  z-index: 9999;
  background: rgb(254, 243, 198);
  background: linear-gradient(
    48deg,
    rgba(254, 243, 198, 1) 0%,
    rgba(255, 221, 95, 1) 15%,
    rgba(0, 84, 184, 1) 100%
  );
}
.calculate__container {
  width: 750px;
  backdrop-filter: blur(50px);
  background: rgb(255, 255, 255);
  box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2);
}
.calculate-title {
  animation: fadeIn 0.5s linear;
  animation-delay: 0.5s;
  opacity: 0;
  animation-fill-mode: forwards;
}

.animate-fade-out {
  transition: all 0.5s ease;
  opacity: 0;
  visibility: hidden;
  max-height: 0;
  overflow: hidden;
}
</style>
