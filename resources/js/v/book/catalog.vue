<script>
export default {
  template: '<slot v-bind="vm"></slot>',
  mounted() {
    this.fetchBooks();
  },
  data: function () {
    return {
      bookData: null,
      filterMaturita: false,
      filterChildren: false,
      filterAvailable: false,
      searchQuery: "",
      currentPage: 1,
    };
  },

  watch: {
    filterMaturita() {
      this.updateBooks();
    },
    filterAvailable() {
      this.updateBooks();
    },
    filterChildren() {
      this.updateBooks();
    },
    currentPage() {
      this.fetchBooks();
    },
    searchQuery() {
      this.updateBooks();
    },
  },
  computed: {
    vm: function () {
      return this;
    },
    booksTotal: function () {
      return this.bookData?.total;
    },
    perPage: function () {
      return this.bookData?.per_page;
    },
    books: function () {
      return this.bookData?.data.map((bookObject) => {
        return book(bookObject);
      });
    },
  },
  methods: {
    reserve(book) {
  
      book.reserve().then(this.$forceUpdate)            
    },

    pageChanged(page) {
      this.currentPage = page;
    },
    fetchBooks() {
      this.bookData = null;
      let params = {
        ...(this.filterMaturita && { maturita: "" }),
        ...(this.filterChildren && { children: "" }),
        ...(this.filterAvailable && { available: "" }),
        ...(this.searchQuery !== '' && { q: this.searchQuery }),
        page: this.currentPage,
      };
      return axios
        .get(`/books`, {
          params,
        })
        .then((response) => {
          window.history.pushState(
            {},
            `${this.currentPage} | Katalog školní knihovny`,
            window.location.pathname + "?" + new URLSearchParams(params).toString()
          );
          this.bookData = response.data;
        })
        .catch((error) => {
          alertify.error("Chyba při načítání knih");
        });
    },
    fetchBooksDebounced: _.debounce(function () {
      this.fetchBooks();
    }, 1500),
    updateBooks() {
      this.bookData = null;
      this.fetchBooksDebounced();
    },
  },
};
</script>
