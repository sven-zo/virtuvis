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
      var request = new Request('http://localhost/dummy-server/dummy_userfish.php', {
        headers: new Headers({
          'Content-Type': 'application/json'
        })
      })

      // this.error = this.cards = null
      // this.loading = true
      fetch(request, {
        method: 'get'
      }).then(function (response) {
        var data = JSON.parse(response)
        // this.loading = false
        console.log('GOT A RESOnSe')
        console.log('response', data)
        console.log('naam eerste vis', data.fish)
      }).catch(function (err) {
        if (err) {
          // this.loading = false
          // this.error = true
        }
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
