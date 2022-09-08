import https from 'https'
import { cacheAdapterEnhancer, throttleAdapterEnhancer } from 'axios-extensions'

export default function ({ $axios }) {
  if (process.env.NODE_ENV === 'development') {
    $axios.defaults.httpsAgent = new https.Agent({ rejectUnauthorized: false })
  }
  $axios.defaults.adapter = throttleAdapterEnhancer(
    cacheAdapterEnhancer($axios.defaults.adapter, true)
  )
}
