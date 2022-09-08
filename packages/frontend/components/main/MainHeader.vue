<template>
  <header class="main-header">
    <a
      href="/"
      @click.prevent="
        $route.name === 'index' ? $router.push('/info') : $router.push('/')
      "
    >
      <logo />
    </a>
  </header>
</template>

<script>
import Logo from '~/assets/svg/logo.svg?inline'
export default {
  name: 'MainHeader',
  components: {
    Logo,
  },
  methods: {
    onMouseEnter() {
      const root = document.documentElement
      root.style.setProperty('--ui-body-bg', '#000000')
      root.style.setProperty('--ui-body-color', '#ffffff')
    },
    onMouseLeave() {
      const root = document.documentElement
      root.style.removeProperty('--ui-body-bg')
      root.style.removeProperty('--ui-body-color')
    },
  },
}
</script>

<style lang="scss">
.main-header {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 9rem;
  padding: 0 1rem;

  svg {
    width: 100%;
    height: auto;
    max-width: 468px;
  }
}
</style>
