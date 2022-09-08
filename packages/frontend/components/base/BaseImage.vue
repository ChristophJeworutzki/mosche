<template>
  <img
    class="base-image lazyload"
    :class="[
      { 'base-image--fill': fill },
      { 'base-image--cover': fill && fit === 'cover' },
      { 'base-image--contain': fill && fit === 'contain' },
    ]"
    :data-src="src"
    :data-srcset="srcset"
    :data-parent-fit="fit"
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
      return this.ratio ? this.ratio.split(':') : undefined
    },
    computedStyle() {
      return {
        'aspect-ratio': this.computedRatio
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

  &.lazyload,
  &.lazyloading {
    opacity: 0;
  }

  &.lazyloaded {
    opacity: 1;
    transition: opacity 100ms;
  }

  &--fill {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
  }

  &--cover {
    object-fit: cover;
  }

  &--contain {
    object-fit: contain;
  }
}
</style>
