<template>
<div class="card">
    <h1> Nastavení importu </h1>

    <div>
      <label class="label" for="import_name"> Popis importu </label>
      <input type="text" id="import_name" class="input" ref="importName" required>
    </div>

    <vue-csv-import
      v-model="csv"
      :fields="{
        title: { required: true, label: 'Název' },
        author_first_name: { required: true, label: 'První jméno autora' },
        author_middle_name: { required: false, label: 'Prostřední jméno autora**' },
        author_last_name: { required: true, label: 'Příjmení autora' },
        isbn: { required: false, label: 'Isbn**' },
        code: { required: true, label: 'Identifikační kód/signatura' },
        collection: { required: true, label: 'Id sbírky' },
        maturita: { required: false, label: 'Maturitní četba**' },
        book_section_id: { required: false, label: 'Id sekce**' },
      }"
      :text='text'
    >
      <div class="space-y-4 mt-4">
        <vue-csv-toggle-headers  v-slot="{hasHeaders, toggle}">
          <div role="checkbox" id="hasHeaders" class = "flex gap-2">
          <label for="hasHeaders" class="label"> Soubor má řádek záhlaví </label>
          <div @click="toggle()" class="relative rounded-full w-12 h-6 transition duration-200 ease-linear"
            :class="{'bg-primary' : ! hasHeaders,  'bg-gray-400':  hasHeaders}">
            <label for="hasHeaders" class="absolute left-0 bg-white border-2 my-0.5 mx-1 w-5 h-5 rounded-full transition transform duration-100 ease-linear cursor-pointer"
                :class="{'translate-x-full border-green-400' : ! hasHeaders,  'translate-x-0 border-gray-400':  hasHeaders}"/>
              </div>
            </div>
        </vue-csv-toggle-headers>
        <vue-csv-errors></vue-csv-errors> <br>
        <vue-csv-input></vue-csv-input>
        <vue-csv-map></vue-csv-map>
        </div>
    </vue-csv-import>
  </div>

<div class="flex flex-col gap-4">

  <div v-if="csv.length > 1" class="card">
  <h1> Náhled výsledků </h1>
  <table class="mt-2 tbl overflow-x-auto">
      <thead>
          <tr>
            <th> Název </th>
            <th> Autor </th>
            <th> Kód </th>
            <th> Sbírka </th>
          </tr>
      </thead>
      <tbody>
          <tr v-for="book in csv.slice(0,5)">
            <td> {{ book.title }}</td>
            <td> {{ [book.author_first_name, book.author_middle_name, book.author_last_name].join(" ")}}</td>
            <td> {{ book.code }}</td>
            <td> {{ book.collection}}</td>
          </tr>
      </tbody>
  </table>
  <button @click="sendData" class="btn btn-black mt-8 w-full"> Odeslat </button>
  </div>
  <div v-if="hasErrors" class="card">
  <h1> Chyby při importu </h1>
  <p> Celkem chybných polí: {{ Object.keys(errors).length }} </p>
  <ul class="mt-4 text-red-600">
      <li v-for="(errs, field) in errors">
        <ul>
          <li v-for="error in errs"> {{ error }} </li>
        </ul>
      </li>
  </ul>
  </div>
  </div>

</template>

<script>
export default {
  props: ['importRoute'],
  data: function () {
    return {
      csv: [],
      errors: [],
      text: {
        errors: {
          fileRequired: "Nejprve nahrejte soubor",
          invalidMimeType: "Neplatný formát souboru",
        },
        toggleHeaders: "Soubor má řádek záhlaví",
        submitBtn: "Poslat",
        fieldColumn: "Pole",
        csvColumn: "Sloupec",
      },
    };
  },
  computed: {
    hasErrors() {
      return Object.keys(this.errors).length > 0
    }
  },
  methods: {
    sendData: _.throttle(function() {
      axios.post(this.importRoute, {
          books: this.csv,
          import_name: this.$refs.importName.value})
        .then(response => {
          alertify.success(response.data.message)
      }).catch((error) => {
        alertify.error('Import se nezdařil: ' + error)
      })
    }, 2000),
  }
};
</script>
