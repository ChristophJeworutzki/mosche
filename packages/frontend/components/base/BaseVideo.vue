<template>
  <video
    v-observe-visibility="{
      callback: onVisibilityChange,
      intersection: {
        threshold: 1,
      },
    }"
    class="base-video"
    :loop="loop"
    :muted="muted"
    :playsinline="playsinline"
    @play="onPlay"
    @pause="onPause"
  />
</template>

<script>
import Hls from 'hls.js/dist/hls.light.js'
export default {
  name: 'BaseVideo',
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
      },
    }
  },
  computed: {
    src() {
      return `https://stream.mux.com/${this.playbackId}.m3u8`
    },
  },
  mounted() {
    this.video = this.$el
    this.video.volume = 0.5
  },
  destroyed() {
    this.destroy()
  },
  methods: {
    onVisibilityChange(inview) {
      this.temp.inview = inview
      if (this.temp.inview) {
        this.load()
      } else {
        this.destroy()
        this.temp.loaded = false
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
      this.video.muted = this.muted
      this.play()
    },
    play() {
      if (!this.temp.loaded) {
        if (Hls.isSupported()) {
          this.hls.startLoad()
        }
      }
      const playPromise = this.video.play()
      if (playPromise !== null) {
        playPromise.catch(() => {
          if (this.muted === false) {
            this.video.muted = true
            this.video.play()
          }
        })
      }
    },
    pause() {
      this.video.pause()
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
    },
    onPause() {
      this.temp.playing = false
    },
  },
}
</script>

<style lang="scss">
.base-video {
  width: 100%;
}
</style>
