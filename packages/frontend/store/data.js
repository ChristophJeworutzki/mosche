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
    console.log(this.$axios.defaults.baseURL)
    await this.$axios
      .get('/api/v1/data')
      .then((response) => {
        commit('setData', response.data)
      })
      .catch((err) => {
        console.warn(err)
      })
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
