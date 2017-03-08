<template lang="pug">
.center
  .wrapper
    .loading(v-if='loading')
      | Loading...
    .error(v-if='error')
      | {{ error }}
    .cardContainer(v-if='loaded', v-for='card in cards')
      p LOADED
      fish-card(:name='card.text')
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
      this.loading = true
      this.cards = getUserFish()
      this.loading = false
      this.loaded = true
      console.log('loaded userfish')
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
