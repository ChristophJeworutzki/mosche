<template>
  <div class="collection-gallery">
    <div class="collection-gallery__slider">
      <div ref="slider" class="keen-slider">
        <div
          v-for="(item, index) in collection"
          :key="index"
          class="keen-slider__slide"
        >
          <template v-if="item.type === 'image'">
            <base-image
              :srcset="item.srcset"
              :ratio="item.aspectRatio"
              :class="item.orientation"
            />
          </template>
          <template v-if="item.type === 'video'">
            <base-video
              :playback-id="item.playbackID"
              :muted="$store.state.ui?.muted"
              :ratio="item.aspectRatio"
              :class="item.orientation"
              @mute="$store.dispatch('ui/mute')"
              @unmute="$store.dispatch('ui/unmute')"
            />
          </template>
        </div>
      </div>
      <div
        v-if="collection.length > 1"
        class="collection-gallery__slider__controls"
      >
        <div class="collection-gallery__slider__controls__next" @click="next" />
        <div class="collection-gallery__slider__controls__prev" @click="prev" />
      </div>
      <template v-if="collection.length > 1">
        <div class="collection-gallery__slider__pagination">
          <span
            v-for="(nth, index) in collection.length"
            :key="index"
            class="collection-gallery__slider__pagination__indicator"
            :class="{ active: currentIndex === index }"
          />
        </div>
      </template>
    </div>
    <div class="collection-gallery__details">
      <template v-if="collection[currentIndex]">
        <div class="collection-gallery__details__caption">
          <div class="text-uppercase">
            {{ collection[currentIndex].title }}
          </div>
          <div>{{ collection[currentIndex].description }}</div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
import 'keen-slider/keen-slider.min.css'
import KeenSlider from 'keen-slider'

export default {
  name: 'CollectionGallery',
  props: {
    collection: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      slider: null,
      currentIndex: 0,
    }
  },
  mounted() {
    this.slider = new KeenSlider(this.$refs.slider, {
      loop: true,
      defaultAnimation: {
        duration: 0,
      },
      slideChanged: (slider) => {
        this.currentIndex = slider.track.details.rel
      },
    })
  },
  destroyed() {
    if (this.slider) setTimeout(() => this.slider.destroy(), 200)
  },
  methods: {
    next() {
      if (this.slider && this.slider.track.details) this.slider.next()
    },
    prev() {
      if (this.slider && this.slider.track.details) this.slider.prev()
    },
  },
}
</script>

<style lang="scss">
.collection-gallery {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;

  &__slider {
    position: relative;
    width: 100%;
    flex-grow: 1;
    flex-shrink: 0;

    .keen-slider {
      position: relative;
      width: 100%;
      height: 100%;

      &__slide {
        position: relative;
        width: 100%;
        min-width: 100vw;
        height: calc((var(--vh, 1vh) * 100) - 15rem);
        display: flex;
        justify-content: center;
        align-items: center;

        .base-image,
        .base-video {
          @media (orientation: landscape) {
            &.landscape {
              width: auto;
              height: 100%;
            }
            &.portrait {
              width: auto;
              height: 100%;
            }
          }
          @media (orientation: portrait) {
            &.landscape {
              width: 100%;
              height: auto;
            }
            &.portrait {
              width: 100%;
              height: auto;
              max-height: 100%;
            }
          }
        }
      }
    }

    &__controls {
      @media (hover: none) and (pointer: coarse) {
        display: none;
      }

      &__prev,
      &__next {
        position: absolute;
        width: 33.3333%;
        height: 100%;
        top: 0;
      }

      &__prev {
        right: 1;
        cursor: w-resize;
      }

      &__next {
        right: 0;
        cursor: e-resize;
      }
    }

    &__pagination {
      position: absolute;
      width: auto;
      top: 1rem;
      left: 50%;
      transform: translateX(-50%);
      z-index: 100;
      display: flex;
      overflow: hidden;
      gap: 0.25rem;
      mix-blend-mode: difference;

      &__indicator {
        width: 4px;
        height: 4px;
        background-color: rgba($white, 0.25);
        border-radius: 100%;

        &.active {
          background-color: $white;
        }
      }
    }
  }

  &__details {
    width: 100%;
    height: 4rem;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 1rem;

    &__caption {
      display: inline-flex;
      gap: 1rem;

      @include media-breakpoint-down('sm') {
        flex-direction: column;
        text-align: center;
        gap: 0.25rem;
      }
    }
  }
}
</style>
