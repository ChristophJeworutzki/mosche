<template>
  <img
    class="base-image lazyload"
    :class="[
      { 'base-image--fill': fill },
      { 'base-image--cover': fit === 'cover' },
      { 'base-image--contain': fit === 'contain' },
    ]"
    :data-src="src"
    :data-srcset="srcset"
    data-sizes="auto"
    draggable="false"
    :style="computedStyle"
  />
</template>

<script>
export default {
  name: 'BaseImage',
  props: {
    src: {
      type: String,
      default: undefined,
    },
    srcset: {
      type: String,
      default: undefined,
    },
    params: {
      type: Object,
      default: () => {},
    },
    ratio: {
      type: [String],
      default: undefined,
    },
    fill: {
      type: Boolean,
      default: false,
    },
    fit: {
      type: String,
      default: 'cover',
    },
  },
  computed: {
    computedRatio() {
      if (this.ratio) {
        return this.ratio.split(':')
      } else {
        return undefined
      }
    },
    computedStyle() {
      return {
        'aspect-ratio':
          this.computedRatio && !this.fill
            ? `${this.computedRatio[0]}/${this.computedRatio[1]}`
            : undefined,
      }
    },
  },
}
</script>

<style lang="scss">
.base-image {
  width: 100%;

  &--fill {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  &--cover {
    object-fit: cover;
  }

  &--contain {
    object-fit: contain;
  }

  &.lazyload,
  &.lazyloading {
    opacity: 0;
  }

  &.lazyloaded {
    opacity: 1;
    transition: opacity 300ms;
  }
}
</style>
