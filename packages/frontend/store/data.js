export const state = () => ({
  index: [],
  about: '',
  contact: {},
  services: [],
  clients: [],
  projects: [],
})

export const actions = {
  async fetchData({ commit, state }) {
    await this.$axios.get('/api/v1/options').then((response) => {
      commit('setData', response.data)
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
    state.projects = data.projects
  },
}
