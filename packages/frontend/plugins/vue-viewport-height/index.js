import Vue from 'vue'

Vue.directive('vh', {
  bind(el, binding, vNode) {
    Vue.nextTick(() => {
      const vh = window.innerHeight * 0.01
      el.style.setProperty('--initial-vh', `${vh}px`)
      el.style.setProperty('--vh', `${vh}px`)
    })
    window.addEventListener('resize', () => {
      const vh = window.innerHeight * 0.01
      el.style.setProperty('--vh', `${vh}px`)
    })
  },
})
