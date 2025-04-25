<template>
  <div @click="toggleDropdown" class="dropdownClass relative text-slate-800 h-16 my-5">
    <div class="selectedOptionClass flex justify-between" :style="paddingStyle">
      <div v-if="!selected" class=" px-2 text-slate-800 text-3xl font-semibold transition-all"
      :class="{' -translate-y-14 transition-all': isOpen || selected}">
        {{ title }}
      </div>
      <div v-if="!isOpen"
      class="placeholder text-2xl font-semibold absolute -top-14 transition-all"
      >Выберите опцию</div>
     <span v-if="selected" class="text-3xl"> {{ selected }}</span>
      <unicon
        name="angle-up"
        fill="rgb(75 85 99)"
        class=" transition-transform duration-300"
        :class="isOpen ? 'transform rotate-180' : ''"
      />
     
    </div>
    <ul v-if="isOpen" class="optionsClass">
      <li
        v-for="option in options"
        :key="option"
        @click="selectOption(option)"
        class="optionClass"
      >
        {{ option }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    options: {
      type: Array,
      default: () => [],
    },
    title: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      isOpen: false,
      selected: null,
    };
  },

  computed: {
    paddingStyle() {
    let length = this.title.length;
    let padding = 5 + length * 0.5;  // Эта формула может требовать корректировки в зависимости от размера и стиля шрифта.
    return `padding-left: ${padding}rem; padding-right: ${padding}rem;`;
  },

  },
  methods: {
    toggleDropdown() {
      this.isOpen = !this.isOpen;
    },

    selectOption(option) {
      this.selected = option;
      this.isOpen = false;
      this.$emit('input', option);
    },

    handleClickOutside(event) {
      if (!this.$el.contains(event.target)) {
        this.isOpen = false;
      }
    },

    handleEscKey(event) {
      if (event.keyCode === 27) {
        this.isOpen = false;
      }
    },
  },

  mounted() {
    document.addEventListener('click', this.handleClickOutside);
    document.addEventListener('keydown', this.handleEscKey);
  },

  beforeDestroy() {
    document.removeEventListener('click', this.handleClickOutside);
    document.removeEventListener('keydown', this.handleEscKey);
  },
};
</script>

<style lang="scss" scoped>
@mixin dropdown {
  @apply relative py-2 px-16 border border-gray-700 cursor-pointer rounded-lg;
}

@mixin selectedOption {
  @apply p-2 relative justify-center;
}

@mixin options {
  @apply absolute top-16 translate-y-1 rounded-lg overflow-hidden left-0 w-full border  border-gray-500 list-none p-0 m-0 z-[999];
}

@mixin option {
  @apply p-2 bg-slate-50 transition-colors duration-200 hover:bg-gray-200;
}

.dropdownClass {
  @include dropdown;
}

.selectedOptionClass {
  @include selectedOption;
}

.optionsClass {
  @include options;
}

.optionClass {
  @include option;
}

.unicon {
  position: absolute;
  right: -40px;
  text-align: center;
  bottom: auto;
  top: auto;
  transform:  translateY(4px);
}
.placeholder{
  animation: slideLeft 0.5s ease-in-out; 
}

</style>
