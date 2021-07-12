<template>
  <div class="px-2 py-1 rounded-md border-2 cursor-pointer" @click="turn"
    :class="{'border-primary' : active, 'border-gray-200': ! active}">
    {{ title }}
  </div>
</template>

<script>
export default {
  emits: ['update:active'],
  props: {
    initial: {
      default: false,
      type: Boolean,
    },
    active: {
      default: false,
      type: Boolean,
    },
    title: {
      type: String,
      required: true,
    },
    onChange: {
      type: Function
    }
  },
  methods: {
    turn() {
      this.$emit('update:active', ! this.active)
    }
  },
  mounted() {
    if(this.initial === true) this.$emit('update:active', true)
  }

}
</script>
