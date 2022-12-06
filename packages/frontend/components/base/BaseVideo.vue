<template>
  <div
    v-observe-visibility="{
      callback: onVisibilityChange,
      intersection: {
        threshold: 1,
      },
    }"
    class="base-video"
    :class="[
      { 'base-video--fill': fill },
      { 'base-video--cover': fill && fit === 'cover' },
      { 'base-video--contain': fill && fit === 'contain' },
    ]"
    :style="computedStyle"
  >
    <video
      ref="video"
      :loop="loop"
      :muted="muted"
      :playsinline="playsinline"
      @play="onPlay"
      @pause="onPause"
    />
    <transition name="fade">
      <img
        v-show="!temp.loaded || !temp.playing"
        ref="thumbnail"
        :src="thumbnailSrc"
      />
    </transition>
    <button
      v-if="temp.showPlayButton"
      class="base-video__play-btn"
      @click="play"
    >
      <icon-play />
    </button>
    <button class="base-video__mute-btn" @click="toggleMute">
      <template v-if="temp.muted">Unmute</template>
      <template v-else>Mute</template>
    </button>
  </div>
</template>

<script>
import Hls from 'hls.js/dist/hls.light.js'
import { withQuery } from 'ufo'
import IconPlay from '~/assets/svg/play.svg?inline'

export default {
  name: 'BaseVideo',
  components: {
    IconPlay,
  },
  props: {
    loop: {
      type: Boolean,
      default: true,
    },
    muted: {
      type: Boolean,
      default: true,
    },
    playsinline: {
      type: Boolean,
      default: true,
    },
    playbackId: {
      type: String,
      default: '',
    },
    thumbnailTime: {
      type: Number,
      default: 0,
    },
    ratio: {
      type: String,
      default: '16:9',
    },
    fit: {
      type: String,
      default: 'cover',
    },
    fill: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      video: undefined,
      thumbnail: undefined,
      hls: undefined,
      hlsOptions: {
        liveBackBufferLength: 10,
        autoStartLoad: false,
        capLevelToPlayerSize: true,
        maxBufferSize: 30,
      },
      temp: {
        loaded: false,
        playing: false,
        inview: false,
        showPlayButton: false,
        muted: this.muted,
      },
    }
  },
  computed: {
    src() {
      return `https://stream.mux.com/${this.playbackId}.m3u8`
    },
    thumbnailSrc() {
      const src = `https://image.mux.com/${this.playbackId}/thumbnail.jpg`
      if (this.thumbnailTime) {
        return withQuery(src, { time: this.thumbnailTime })
      } else {
        return withQuery(src, { time: 0 })
      }
    },
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
  watch: {
    muted(value) {
      this.temp.muted = value
    },
  },
  mounted() {
    this.video = this.$refs.video
    this.thumbnail = this.$refs.thumbnail
    this.load()
  },
  destroyed() {
    this.destroy()
  },
  methods: {
    onVisibilityChange(inview) {
      this.temp.inview = inview
      if (this.temp.inview) {
        this.play()
      } else {
        this.video.currentTime = 0
        this.pause()
      }
    },
    load() {
      if (Hls.isSupported()) {
        this.hls = new Hls(this.hlsOptions)
        this.hls.loadSource(this.src)
        this.hls.attachMedia(this.video)
        this.hls.on(Hls.Events.FRAG_LOADED, this.onLoad)
      } else {
        this.video.src = this.src
        this.video.load()
        this.temp.loaded = true
      }
    },
    play() {
      if (!this.temp.loaded) {
        if (Hls.isSupported()) {
          this.hls.startLoad()
        }
      }
      this.video.play()?.catch(() => {
        this.mute()
        this.video.play()?.catch(() => {
          this.temp.showPlayButton = true
        })
      })
    },
    pause() {
      this.video.pause()
    },
    toggleMute() {
      if (this.temp.muted) {
        this.unmute()
      } else {
        this.mute()
      }
    },
    mute() {
      this.video.muted = true
      this.temp.muted = true
      this.$emit('mute')
    },
    unmute() {
      this.video.muted = false
      this.temp.muted = false
      this.$emit('unmute')
    },
    destroy() {
      if (this.hls) {
        this.hls.detachMedia()
        this.hls.destroy()
        delete this.hls
      }
    },
    onLoad() {
      this.temp.loaded = true
    },
    onPlay() {
      this.temp.playing = true
      this.temp.showPlayButton = false
    },
    onPause() {
      this.temp.playing = false
    },
  },
}
</script>

<style lang="scss">
.base-video {
  position: relative;
  width: 100%;
  overflow: hidden;
  background-color: rgba(0, 0, 0, 0.1);
  transform: translate3d(0, 0, 0);

  video,
  img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  video {
    z-index: 0;
  }

  img {
    z-index: 1;
  }

  &--fill {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }

  &--cover {
    img,
    video {
      object-fit: cover;
    }
  }

  &--contain {
    img,
    video {
      object-fit: contain;
    }
  }

  &__play-btn {
    @include reset-button;
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 1;
    width: 64px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: $white;
    font-size: 0.625rem;
    font-weight: 600;
    letter-spacing: 0.025em;
    text-transform: uppercase;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, 0.125);
    backdrop-filter: blur(32px);
    padding: 0 0.5rem;
    border-radius: 100%;
    padding: 0 0 0 0.25em;

    &:hover {
      color: $white;
    }
  }

  &__mute-btn {
    @include reset-button;
    position: absolute;
    bottom: 0.5rem;
    left: 50%;
    z-index: 1;
    width: auto;
    height: 24px;
    color: $white;
    font-size: 0.625rem;
    font-weight: 600;
    letter-spacing: 0.025em;
    text-transform: uppercase;
    transform: translateX(-50%);
    background-color: rgba(0, 0, 0, 0.125);
    backdrop-filter: blur(32px);
    padding: 0 0.5rem;
    border-radius: 50rem;

    &:hover {
      color: $white;
    }
  }
}
</style>
