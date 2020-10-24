<template>
  <div class="container">
    <div class="row">
      <div class="col-12 py-3">
        <h1>Library</h1>
        <h4>Hi, {{ userName }}! Here you can store some books.<br/>
          Go ahead and type, add, edit or delete a book from your list</h4>
      </div>
      <button class="btn btn-secondary fixed-top ml-10" @click="logout">Log out</button>
    </div>
    <div class="row mb-3">
      <form class="col-12 col-sm-10 col-md-8 cl-lg-6 mx-auto" @submit="addBook">
        <textarea
            @input="emptySubmit = false"
            v-model="newBook"
            class="form-control"
            :class="{'is-invalid' : emptySubmit}"
            placeholder="Add new book here"
            ref="newBook"
        />
        <div class="invalid-feedback">
          Please add book info before submit
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-3">Add new book</button>
      </form>
    </div>
    <div class="row">
        <div class="col-12 py-3">
          <h3>Added books:</h3>
        </div>
      <div class="col-12 col-sm-10 col-lg-10 mx-auto">
        <ul class="list-group">
          <li class="d-flex align-items-center list-group-item" v-if="books.length == 0">
            <div
                class="btn border-0 flex-grow-1 text-left shadow-none">
              <p class="text-center m-0">You do not have any books yet. Go ahead and add some</p>
            </div>
          </li>
          <library-item
              v-else
              v-for="(book, index) in books"
              :key="index"
              :book="book.content"
              @on-delete="deleteBook(index)"
              @on-edit="editBook(index, $event)"
          />
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import LibraryItem from "@/components/BookElementComponent.vue";

export default {
  data() {
    return {
      userId: '',
      userName: '',
      newBook: '',
      emptySubmit: false,
      books: []
    };
  },
  components: { 'library-item': LibraryItem },
  created(){
    this.getUser();
  },
  methods: {
    getUser(){
      let token = localStorage.getItem('user_token');
      if(token){
        this.axios.post(process.env.VUE_APP_API_URL +  'user', {'token' : token})
        .then(res => {
          this.userId = res.data[0].id;
          this.userName = res.data[0].name;

          this.getBooksByUserId();
        });
      }

    },

    getBooksByUserId(){
      this.axios.get(process.env.VUE_APP_API_URL + 'books/' + this.userId)
          .then((res) => {
            if(+res.data.status === 404)
              this.books = [];
            else if(res.data.length > 0)
              this.books = res.data;
          });

    },

    logout(){
      localStorage.removeItem('user_token');
      this.$router.push(({ name: "Registration"}));
    },

    addBook() {
      if(this.newBook==='')
        return this.emptySubmit = true;

      let data = {
        'id': this.userId,
        'content': this.newBook
      }
      let book_id = null;
      this.axios.post(process.env.VUE_APP_API_URL + 'books/', data)
      .then(res => {
        book_id = res.data[0].id;
        this.books.push({id: book_id, content: this.newBook});
        this.newBook = '';
      })

      this.$nextTick(() => this.$refs.newBook.focus());
    },

    editBook(index, newBookName) {
      if(newBookName === '') return alert("Book info's empty. Please add some text before submit");


      let data = {
        'id': this.books[index].id,
        'content': newBookName
      }

      this.axios.put(process.env.VUE_APP_API_URL + 'books/' + data['id'], data)
          .then(() => {
            this.books[index].content = newBookName;
          })
    },

    deleteBook(index) {
      let id = this.books[index].id;

      this.axios.delete(process.env.VUE_APP_API_URL + 'books/' + id)
          .then(() =>  this.books.splice(index, 1));
    },
  },
};
</script>