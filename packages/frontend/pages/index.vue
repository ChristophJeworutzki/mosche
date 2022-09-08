<template>
  <main class="page--index">
    <index-gallery :items="gallery" />
  </main>
</template>

<script>
export default {
  computed: {
    gallery() {
      return this.$store.state?.data?.index?.gallery || []
    },
  },
}
</script>

<style lang="scss">
.page--index {
  position: relative;
  width: 100%;
  height: calc((var(--vh, 1vh) * 100) - 9rem);
}
</style>
