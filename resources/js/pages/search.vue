<template>
    <div class="body-layout">
        <search-bar></search-bar>
        <results></results>
    </div>
</template>
<script>
import SearchBar from '~/components/BookSearch/SearchBar'    
export default {
    components:
    {
        SearchBar
    }
}
</script>

<style lang="scss" scoped>
  .body-layout
  {
      overflow-x: hidden;
  }
</style>