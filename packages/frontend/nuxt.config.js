import path from 'path'
require('dotenv').config({ path: path.join(__dirname, '/../../.env') })

export default {
  ssr: true,
  server: {
    host: '0.0.0.0',
  },
  head: {
    title: 'MOSCHE',
    htmlAttrs: {
      lang: 'en',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { name: 'format-detection', content: 'telephone=no' },
    ],
    link: [{ rel: 'icon', type: 'image/svg+xml', href: '/favicon.svg' }],
  },
  components: [{ path: '~/components', pathPrefix: false }],
  css: ['~/assets/icons/feather/stylesheet.css', '~/assets/styles/index.scss'],
  styleResources: {
    scss: [
      'bootstrap/scss/_functions.scss',
      'bootstrap/scss/_mixins.scss',
      '~/assets/styles/_functions.scss',
      '~/assets/styles/_mixins.scss',
      '~/assets/styles/_variables.scss',
      'bootstrap/scss/_variables.scss',
    ],
  },
  plugins: [
    '~/plugins/axios',
    { src: '~/plugins/vue-observe-visibility', ssr: false },
    { src: '~/plugins/vue-viewport-height', ssr: false },
    { src: '~/plugins/vue-lazysizes', ssr: false },
  ],
  buildModules: [
    '@nuxtjs/eslint-module',
    '@nuxtjs/style-resources',
    '@nuxtjs/svg',
    'nuxt-font-loader',
  ],
  modules: ['@nuxtjs/axios'],
  axios: {
    baseURL: process.env.APP_URL,
  },
  fontLoader: {
    url: 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600',
    prefetch: true,
    preconnect: true,
  },
  publicRuntimeConfig: {
    dev: process.env.NODE_ENV !== 'production',
  },
  build: {
    extend(config, { isDev, isClient, loaders: { vue } }) {
      if (isClient) {
        vue.transformAssetUrls.img = ['data-src', 'src']
        vue.transformAssetUrls.source = ['data-srcset', 'srcset']
      }
    },
  },
}
