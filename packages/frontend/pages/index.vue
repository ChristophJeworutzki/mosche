<template>
  <main class="page">
    <collection-gallery :collection="collection" />
  </main>
</template>

<script>
export default {
  computed: {
    collection() {
      return this.$store.state?.data?.index?.collection || []
    },
  },
}
</script>

<style lang="scss">
.page {
  position: relative;
  width: 100%;
  height: calc((var(--vh, 1vh) * 100) - 9rem);
}
</style>
