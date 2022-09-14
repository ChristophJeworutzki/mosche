<template>
  <main class="page--info">
    <div class="page--info__container">
      <div class="page--info__container__start">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-sm-8">
              <div class="text-center">
                <div class="mosche-circle" />
                <h1 class="text-uppercase">
                  {{ about }}
                </h1>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page--info__container__end">
        <div class="container">
          <div class="row justify-content-center gy-sm-0 gy-2">
            <div class="col-sm-3 col-6">
              <h3 class="text-uppercase">Services</h3>
              <ul class="mt-0.75">
                <li
                  v-for="({ title, slug, collection }, index) in services"
                  :key="index"
                >
                  <nuxt-link v-if="collection" :to="`/services/${slug}`">
                    {{ title }}
                  </nuxt-link>
                  <span v-else> {{ title }}</span>
                </li>
              </ul>
            </div>
            <div class="col-sm-3 col-6">
              <h3 class="text-uppercase">Clients</h3>
              <ul class="mt-0.75">
                <li
                  v-for="({ title, slug, collection }, index) in clients"
                  :key="index"
                >
                  <nuxt-link v-if="collection" :to="`/clients/${slug}`">
                    {{ title }}
                  </nuxt-link>
                  <span v-else> {{ title }}</span>
                </li>
              </ul>
            </div>
            <div class="col-sm-3 col-6">
              <h3 class="text-uppercase">Projects</h3>
              <ul class="mt-0.75">
                <li
                  v-for="({ title, slug, collection }, index) in projects"
                  :key="index"
                >
                  <nuxt-link v-if="collection" :to="`/projects/${slug}`">
                    {{ title }}
                  </nuxt-link>
                  <span v-else> {{ title }}</span>
                </li>
              </ul>
            </div>
            <div v-if="contact" class="col-sm-3 col-6">
              <h3 class="text-uppercase">Contact</h3>
              <address class="mt-0.75 mb-0">
                <span class="d-block" v-html="contact.address" />
                <a
                  v-if="contact.phone"
                  :href="`tel:${contact.phone}`"
                  class="d-block"
                >
                  {{ contact.phone }}
                </a>
                <a
                  v-if="contact.email"
                  :href="`mailto:${contact.email}`"
                  class="d-block"
                >
                  {{ contact.email }}
                </a>
                <a
                  v-if="contact.instagram"
                  :href="contact.instagram"
                  target="_blank"
                  rel="noopener noreferrer"
                  class="d-block"
                >
                  Instagram
                </a>
              </address>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  computed: {
    about() {
      return this.$store.state?.data?.about
    },
    contact() {
      return this.$store.state?.data?.contact
    },
    services() {
      return this.$store.state?.data?.services
    },
    clients() {
      return this.$store.state?.data?.clients
    },
    projects() {
      return this.$store.state?.data?.projects
    },
  },
}
</script>

<style lang="scss">
.page--info {
  position: relative;
  width: 100%;
  height: calc(100vh - 9rem);

  @include media-breakpoint-down('sm') {
    height: auto;
  }

  &__container {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;

    &__start {
      flex-grow: 1;
      flex-shrink: 0;
      padding: 0 0 6rem 0;

      @include media-breakpoint-down('sm') {
        padding: 0 0 3rem 0;
      }
    }

    &__end {
      flex-shrink: 0;
      padding: 3rem 0;
    }
  }

  .mosche-circle {
    display: inline-block;
    width: 6rem;
    height: 6rem;
    background-color: #ff5c00;
    border-radius: 50rem;
    margin: 8vh 0;

    @include media-breakpoint-down('sm') {
      margin: 3rem 0;
    }
  }

  a {
    &:hover {
      opacity: 0.33;
    }
  }
}
</style>
