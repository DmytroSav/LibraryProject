<template>
  <div class="home">
    <library/>
  </div>
</template>

<script>
import LibraryComponent from '@/components/LibraryComponent.vue'

export default {
  name: 'Home',
  components: {
    'library': LibraryComponent
  }
}
</script>
