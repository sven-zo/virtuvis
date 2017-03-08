<template lang="pug">
.center
  .wrapper
    .loading(v-if='loading')
      | Loading...
    .error(v-if='error')
      | {{ error }}
    .cardContainer(v-if='loaded', v-for='card in cards')
        fish-card(:name='card.text')
</template>

<script>
import FishCard from '@/components/fish/FishCard.vue'

export default {
  data: function () {
    return {
      loading: false,
      cards: null,
      error: null
    }
  },
  created () {
    this.fetchFish()
  },
  methods: {
    fetchFish () {
      this.loading = true
      this.cards = this.error = null

      var request = new XMLHttpRequest()
      request.addEventListener('load', loadFish)
      request.open('GET', 'http://localhost/dummy-server/dummy_userfish.php')
      request.send()

      function loadFish () {
        var response = request.responseText
        response = JSON.parse(response)
        console.log(response)
      }
    },
    setFish () {
      this.loading = false
    }
  },
  components: {
    FishCard
  }
}
</script>

<style lang="sass">
@import '../../style/palette.sass'

.center
  text-align: center

.wrapper
  display: inline-block
  margin-top: 10px

.cardContainer
  display: flex
  flex-direction: row
  flex-wrap: wrap
  padding-left: 6.2vw
  // die padding kan echt niet hoor maar idk hoe ik dit even doe x,D
</style>
