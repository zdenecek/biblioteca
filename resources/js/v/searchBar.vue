<template>
  <div class="relative">

      <input type="search" class="pr-10 input w-full" @input="this.$emit('update:query', this.query)"
          v-model="query" placeholder="Vyhledávání">

      <button @click="this.$emit('searchClicked')" type="button" class="active:outline-none focus:outline-none absolute top-0 right-0 h-full">
          <svg class="h-full w-10  p-2" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="gray">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
      </button>
  </div>
</template>

<script>
export default {
  emits: ['searchClicked', 'update:query'],
  props: ['query'],
}
</script>
