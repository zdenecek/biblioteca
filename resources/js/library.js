require('./bootstrap');

require('alpinejs');
require('./skippablePrompt');
import {VueCsvImportPlugin} from "vue-csv-import";



window.showDate = function (dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString()
}

window.book = require('./makeBook').makeBook;
window.user = require('./makeUser').makeUser;
window.reservation = require('./makeReservation').makeReservation;

if (document.getElementById('biblioteca')) {
  window.Vue = require('vue');
  const vue = Vue.createApp({})
    .use(VueCsvImportPlugin)
    .component('borrow-return-form', require('./v/borrowReturnForm').default)
    .component('book-card', require('./v/book/book').default)
    .component('book-catalog', require('./v/book/catalog').default)
    .component('paginator', require('./v/paginator').default)
    .component('catalog-filter', require('./v/book/catalogFilter').default)
    .component('search-bar', require('./v/searchBar').default)
    .component('import-form', require('./v/importForm.vue').default)
    .mount("#biblioteca")
}

