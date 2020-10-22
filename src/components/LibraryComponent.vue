<template>
  <div class="container">
    <div class="row">
      <div class="col-12 py-5">
        <h1>Library</h1>
      </div>
    </div>
    <div class="row mb-3">
      <form class="col-12 col-sm-10 col-md-8 cl-lg-6 mx-auto" @submit="addBook">
        <input
            v-model="newBook"
            type="text"
            class="form-control"
            placeholder="Add new book here"
            ref="newBook"
        />
        <button type="submit" class="btn btn-primary btn-block mt-3">Add new book</button>
      </form>
    </div>
    <div class="row">
      <div class="col-12 col-sm-10 col-lg-6 mx-auto">
        <ul class="list-group">
          <library-item
              v-for="(book, index) in books"
              :key="index"
              :book="book"
              @on-delete="deleteBook(index)"
              @on-edit="editBook(index, $event)"
          />
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import LibraryItem from "@/components/ElementComponent.vue";

export default {
  data() {
    return {
      newBook: '',
      books: ['Stephen King, Under the Dome', 'Friedrich Nietzsche, Also sprach Zarathustra'],
    };
  },
  components: { 'library-item': LibraryItem },
  methods: {
    addBook() {
      this.books.push(this.newBook);
      this.newBook = '';
      this.$nextTick(() => this.$refs.newBook.focus());
    },
    deleteBook(index) {
      this.books.splice(index, 1);
    },
    editBook(index, newBookName) {
     this.books[index] = newBookName;
    },
  },
};
</script>