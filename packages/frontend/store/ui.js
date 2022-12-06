export const state = () => ({
  muted: true,
})

export const actions = {
  mute({ commit }) {
    commit('setMuted', true)
  },
  unmute({ commit }) {
    commit('setMuted', false)
  },
  toggleMute({ commit, state }) {
    commit('setMuted', !state.muted)
  },
}

export const mutations = {
  setMuted(state, value) {
    state.muted = value
  },
}
