<template>
<ul class="flex gap-2 m-2" v-if="availablePages.length > 1">
  <li v-if="previousPage" @click="onPageChanged(previousPage)" class="px-1 py-1.5  flex items-center cursor-pointer" role="button">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
  </svg>
  </li>
  <li v-for="(page, index) in availablePages" :key="index" >
    <div @click="onPageChanged(page)" role="button" v-if="page !== 'separator'"
      class="w-7 h-7  cursor-pointer rounded flex items-center justify-center"
      :class="{'border-transparent border-2 hover:border-primary ease-in duration-200': ! active(page),
              'bg-primary text-white': active(page)}">
      {{ page }}
    </div>
    <div v-else class="w-7 h-7 cursor-default rounded flex items-center justify-center">...</div>
  </li>
  <li v-if="nextPage" @click="onPageChanged(nextPage)" class="px-1 py-1.5 flex items-center cursor-pointer" role="button">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
</svg>
  </li>
</ul>
</template>

<script>
export default {
  data() {
    return {
      onEachSide: 2,
    }
  },
  computed: {
      availablePages() {
        let pages = [1]
        let i = - this.onEachSide
        if(this.currentPage + i > 2) pages.push('separator')
        for(; i <= this.onEachSide; i++) {
          pages.push(this.currentPage + i)
        }
        if(pages[pages.length - 1] < this.lastPage - 1 ) pages.push('separator')
        pages.push(this.lastPage)
        return  pages.filter((val, index, self) => {
          return (self.indexOf(val) === index && val > 0 && val <= this.lastPage) || val === "separator";
        })

      },
      lastPage() {
        return Math.ceil(this.total / this.perPage)
      },
      previousPage() {
        return this.currentPage === 1 ? null : this.currentPage - 1
      },
      nextPage() {
        return this.currentPage === this.lastPage ? null : this.currentPage + 1
      },

  },
  methods: {
    active(page) {
      return page === this.currentPage
    }
  },
  props: ['current-page', 'total', 'per-page', 'on-page-changed'],
}
</script>


