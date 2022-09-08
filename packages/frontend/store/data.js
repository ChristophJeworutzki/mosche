export const state = () => ({
  index: [],
  about: '',
  contact: {},
  services: [],
  clients: [],
  magazines: [],
})

export const actions = {
  async fetchData({ commit, state }) {
    const response = await this.$axios.get('/api/v1/data/')
    const { data } = response
    if (data) {
      commit('setData', data)
    }
  },
}

export const mutations = {
  setData(state, data) {
    state.index = data.index
    state.about = data.about
    state.contact = data.contact
    state.services = data.services
    state.clients = data.clients
    state.magazines = data.magazines
  },
}
