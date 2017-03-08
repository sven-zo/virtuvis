<template lang="pug">
.center
  .wrapper
    .loading(v-if='loading')
      | Loading...
    .error(v-if='error')
      | {{ error }}
    .cardContainer(v-if='loaded', v-for='fish in cards')
      fish-card(:name='fish.species')
</template>

<script>
import FishCard from '@/components/fish/FishCard.vue'
import {getUserFish} from '../../script/userFish.js'

export default {
  data: function () {
    return {
      loading: false,
      cards: null,
      error: null,
      loaded: false
    }
  },
  created () {
    this.fetchFish()
  },
  methods: {
    fetchFish () {
      var self = this
      this.loading = true
      getUserFish().then(function (response) {
        console.log('Succes!', response)
        self.loading = false
        self.loaded = true
        self.cards = response.fish
        console.log('Card data attached')
      }, function (error) {
        console.log('Failed!', error)
        self.loading = false
        self.error = true
      })
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
