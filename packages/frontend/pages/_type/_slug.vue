<template>
  <main class="page--collection">
    <collection-gallery :collection="collection" />
  </main>
</template>

<script>
import get from 'lodash/get'
export default {
  asyncData({ store, params, error }) {
    const records = get(store, `state.data.${params.type}`)
    const record = records?.find(({ slug }) => {
      return slug === params.slug
    })
    if (!record) return error({ statusCode: 404, message: 'Page not found' })
    return {
      collection: record?.collection,
    }
  },
}
</script>

<style lang="scss">
.page--collection {
  position: relative;
  width: 100%;
  height: calc((var(--vh, 1vh) * 100) - 9rem);
}
</style>
