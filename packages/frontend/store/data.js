export const state = () => ({
  index: [],
  about: '',
  contact: {},
  services: [],
  clients: [],
  magazines: [],
})

export const actions = {
  fetchData({ commit, state }) {
    this.$axios
      .get('/api/v1/data/')
      .then((response) => {
        const { data } = response
        if (data) {
          commit('setData', data)
        }
      })
      .catch((err) => {
        console.log(err)
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
