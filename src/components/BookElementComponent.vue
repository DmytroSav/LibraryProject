<template>
  <li class="d-flex align-items-center list-group-item">
    <div
        class="btn border-0 flex-grow-1 text-left shadow-none"
        @click="$emit('on-toggle')"
        v-if="!isEditing"
    >
      <span>{{ book }}</span>
    </div>
    <form v-else class="flex-grow-1" @submit.prevent="finishEditing">
      <input
          type="text"
          class="form-control"
          v-model="newBookName"
          @blur="finishEditing"
          ref="editBook"
      />
    </form>
    <button
        v-if="!isEditing"
        @click="startEditing"
        class="btn btn-outline-primary border-0 ml-2">
      <span class="fa fa-edit"></span>
    </button>
    <button
        v-if="isEditing"
        @click="finishEditing"
        class="btn btn-outline-success border-0 ml-2">
      <span class="fa fa-check"></span>
    </button>
    <button @click="$emit('on-delete')" class="btn btn-outline-danger border-0">
      <span class="fa fa-trash"></span>
    </button>
  </li>
</template>

<script>
export default {
  data() {
    return {
      isEditing: false,
      newBookName: ""
    };
  },
  props: {
    book: String,
  },
  methods: {
    startEditing() {
      if (this.isEditing) {
        return this.finishEditing();
      } else {
        this.newBookName = this.book;
        this.isEditing = true;
        this.$nextTick(() => this.$refs.editBook.focus());
      }
    },
    finishEditing() {
      this.isEditing = false;
      this.$emit("on-edit", this.newBookName);
    }
  }
};
</script>
