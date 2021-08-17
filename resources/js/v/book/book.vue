
<template>

  <div class="card md:w-2/5">
    <h1>
      {{ book.title }}
    </h1>

    <div class="property-list mt-4">
      <div class='property-label'>Název</div>
      <div class='property-content'>{{ book.title }}</div>
      <div class='property-label'>Autor</div>
      <div class='property-content'>{{ book.author }}</div>
      <div class='property-label' v-if="book.isbn">Isbn</div>
      <div class='property-content' v-if="book.isbn">{{ book.isbn }}</div>
      <div class='property-label'>Dostupnost</div>
      <div class='property-content'>{{ book.state }}</div>
      <div class='property-label' v-if="book.maturita">Četba k maturitě</div>
      <div class='property-content' v-if="book.maturita">Ano</div>
      <div class='property-label' v-if="book.section">Sekce</div>
      <div class='property-content' v-if="book.section"> {{ book.section?.name }}</div>

    </div>

    <div class="mt-4" v-if="book.googleBooksData">
    <h2>
      Údaje z Google Books
    </h2>
    <div class="property-list mt-4">
      <template v-for="(value, key) in googleBooksVolumeInfos" :key="key">
        <template v-if="value">
          <div class='property-label'> {{ key }}</div>
          <div class='property-content'>{{ value }}</div>
        </template>
      </template>
      <template v-if="link">
          <div class='property-label'> Více informací na Google Books</div>
          <div class='property-content'>
            <a :href="link" class="underline flex gap-1 items-center">
              <span>odkaz </span>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
              </svg>
            </a>
          </div>
        </template>
    </div>
    <template v-if="googleBooksVolumeDescription">
    <h3 class="mt-4">Popis</h3>
    <p>{{ googleBooksVolumeDescription }}</p>
    </template>
    </div>
  </div>
  <img v-if="imageLink" :src="imageLink" :alt="'Obrázek přebalu knihy ' + book.title" class="shadow-md sm:rounded-lg max-h-60"/>
</template>
<script>
export default {
  props: ['book'],

  computed: {
    googleBooksVolumeInfos() {
      let v = this.book?.googleBooksData?.volumeInfo
      return {
        'Podtitul' : v.subtitle,
        ...(v.authors?.length > 1 && { 'Autoři': v.authors.join(', ') }),
        'Vydavatel' : v.publisher,
        'Vydáno' : v.publishedDate,
        'Počet stran' : v.pageCount,
        'Kategorie' : v.categories?.join(", "),
      }
    },
    googleBooksVolumeDescription() {
      return this.book?.googleBooksData?.volumeInfo.description;
    },
    link() {
      console.log(this.book)
      let v = this.book?.googleBooksData?.volumeInfo
      return v.infoLink ?? v.previewLink ?? v.canonicalVolumeLink
    },
    imageLink() {
      let i = this.book?.googleBooksData?.volumeInfo?.imageLinks
      if(i) return i.thumbnail
        ?? i.smallThumbnail
        ?? i.thumbnail
        ?? i.small
        ?? i.medium
        ?? i.large
        ?? i.extraLarge
    },
  },

};
</script>
