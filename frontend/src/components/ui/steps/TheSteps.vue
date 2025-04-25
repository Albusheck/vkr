<template>
  <div class="steps w-full flex justify-center">
    <div
      v-for="(stepInfo, index) in stepsInfo"
      :key="index"
      class="step-wrapper"
    >
    <div
      class="circle gap-2"
      :class="{
        active: currentStep >= index + 1,
        current: currentStep === index + 1,
        completed: currentStep > index + 1 || allStepsCompleted,
        clickable: currentStep >= index + 1
      }"
      @click="handleStepClick(index + 1)"
    >
        <div class="step-title">{{ stepInfo.title }}</div>
        {{ index + 1 }}
        <div
          class="selected-option"
          v-html="stepInfo.selectedOption ? stepInfo.selectedOption : '<br/>'"
        ></div>
      </div>
      <div
        v-if="index < stepsInfo.length - 1"
        class="indicator"
        :class="{
          completed: currentStep > index + 2,
          current: currentStep === index + 2,
        }"
        :data-status="indicatorStatus(index)"
      ></div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TheSteps',
  props: {
    currentStep: {
      type: Number,
      required: true,
    },
    stepsInfo: {
      type: Array,
      required: true,
    },

    allStepsCompleted: {
      type: Boolean,
      required: true,
    },
  },

  methods: {
    handleStepClick(newStep) {
      if (newStep <= this.currentStep) {
        this.$emit('change-step', newStep);
      }
    },

    indicatorStatus(index) {
      if (this.allStepsCompleted) {
        return 'completed';
      }
      if (this.currentStep > index + 2) {
        return 'completed';
      } else if (this.currentStep === index + 2) {
        return 'current';
      } else {
        return 'inactive';
      }
    },
  },
};
</script>

<style scoped>
.steps {
  display: flex;
  align-items: center;
}

.step-wrapper {
  display: flex;
  align-items: center;
  width: 33.33%;
}
.step-wrapper:last-child {
  width: fit-content;
}

.circle {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  height: 50px;
  width: 50px;
  color: rgb(30 41 59 );
  font-size: 22px;
  font-weight: 500;
  border-radius: 50%;
  background: #f8fafc;
  border: 4px solid #e0e0e0;
  transition: all 200ms ease;
  transition-delay: 0s;
  z-index: 50;
  cursor: no-drop;
}

.step-title {
  font-size: 12px;
  margin-top: 5px;
}

.selected-option {
  font-size: 12px;
  margin-top: 5px;
}

.circle.active {
  transition-delay: 100ms;
  border-color: #1985d8;
  color: #1985d8;
}
.circle.current {
  border-color: #cdad39;
  color: #cdad39;
}

.circle.completed {
  border-color: #046449;
  color: #046449;
}
.indicator {
  height: 5px;
  flex-grow: 1;
  background: linear-gradient(
    to right,
    var(--indicator-color, #cdad39) 50%,
    rgba(107, 114, 128, 0.603) 10%
  );
  background-size: 200% 100%;
  background-position: right bottom;
  transition: background-position 300ms ease;
  z-index: 40;
  transform: scaleX(1.1);
  border-radius: 20px;
}

.indicator[data-status='completed'] {
  --indicator-color: #046449;
  background-position: left bottom;
}

.indicator[data-status='current'] {
  --indicator-color: #cdad39;
  background-position: left bottom;
}

.indicator[data-status='inactive'] {
  --indicator-color: rgb(107 114 128);
  background-position: right bottom;
}

.circle.clickable:hover {
  border-color: #1985d8;
  color: #1985d8;
  cursor: pointer;
  transition-delay: 0ms;
}
</style>
