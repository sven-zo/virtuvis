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
  .recent(v-if='loaded')
    fish-card-recent(@buttonState='buttonStateManager($event)', v-if="language == 'nl'", v-for='fish in cards', :key="fish.id", :id='fish.id', :name='fish.name', :image='fish.image')
    fish-card-recent(@buttonState='buttonStateManager($event)', v-if="language == 'en'", v-for='fish in cards', :key="fish.id", :id='fish.id', :name='fish.name', :image='fish.image')
</template>

<script>
import {getData} from '../../script/getData.js'

import FishCardRecent from '@/components/fish/FishCardRecent.vue'

export default {
  data: function () {
    return {
      loading: true,
      error: null,
      loaded: false
    }
  },
  props: [
    'language'
  ],
  components: {
    FishCardRecent
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
    },
    buttonStateManager (data) {
      console.log('[HomeRecent] Got data from {userFish}: buttonState')
      console.log('[HomeRecent] Emitting buttonState to [Home]')
      this.$emit('buttonState', data)
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
  display: flex
  overflow-x: scroll
  overflow-y: hidden
  white-space: nowrap

.error
  background-color: $primary-color
  height: 200px
  width: 100%

p
  font-family: 'Roboto', sans-serif
  color: white
</style>
