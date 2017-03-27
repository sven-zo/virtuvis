<template lang="pug">
.recentwrapper
  transition(appear, name='loading')
    .loading(v-if='loading')
      br
      #loader Loading...
  transition(appear, name='page')
    .error(v-if='error')
      br
      p Er ging iets fout :( Probeer het later opnieuw! Kijk ook even of je internet hebt
      p Foutmelding: {{ errorMessage }}
  transition(appear, name='page')
    .recent(v-if='loaded')
      p HIER KOMEN KAARTJES YAY
</template>

<script>
import {getData} from '../../script/getData.js'

export default {
  data: function () {
    return {
      loading: true,
      error: null,
      loaded: false
    }
  },
  created () {
    this.getRecentFish()
  },
  methods: {
    getRecentFish () {
      var self = this
      this.loading = true
      getData('recent').then(function (response) {
        console.log('Succes! (Recent cards)', response.fish)
        self.cards = response.fish
        self.loading = false
        self.loaded = true
        console.log('Recent cards data attached')
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserFish@getRecentFish@HomeRecent] (' + error + ')'
        console.log('Failed! (Recent cards)', error)
        self.loading = false
        self.error = true
      })
    }
  }
}

</script>

<style lang="sass" scoped>
@import '../../style/_palette.sass'
@import '../../style/loading.css'
@import '../../style/pageanimations.sass'

#loader
  color: $primary-color-light
  transform: translate(0px, -50px)

.loading
  background-color: $primary-color
  height: 200px
  width: 100%

.recent
  background-color: $primary-color
  height: 200px
  width: 100%

.error
  background-color: $primary-color
  height: 200px
  width: 100%

.error p
  font-family: 'Roboto', sans-serif
  color: white
</style>
