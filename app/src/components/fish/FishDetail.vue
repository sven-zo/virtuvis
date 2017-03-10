<!-- Dit is het component voor het scherm wat je ziet als je op een vis klikt. -->
<template lang="pug">
.wrapper
  transition(appear, name='loading')
    .loading(v-if='loading')
      p#loadingMSG Loading fish...
      #loader Loading...
  .error(v-if='error')
  .fishDetail(v-if='loaded')
    .fishPicture(:style="{ backgroundImage: 'url(' + image + ')' }")
    .fishName(v-if='userLanguage == "nl"')
      .fishText {{ fish.speciesNl }}
    .fishName(v-if='userLanguage == "en"')
      .fishText {{ fish.species }}
</template>

<script>
import {getUserFish} from '../../script/userFish.js'
import {getUserSettings} from '../../script/userSettings.js'

export default {
  data: function () {
    return {
      loaded: false,
      loading: false,
      error: null,
      userLanguage: null,
      image: null,
      fish: [
        'speciesNl', 'error'
      ]
    }
  },
  created () {
    console.log('Fish opened, bound to id: ', this.$route.params.id)
    this.loading = true
    this.getUserSettings()
    this.fetchFish()
  },
  methods: {
    fetchFish () {
      var self = this
      getUserFish().then(function (response) {
        console.log('Succes! (Detail)', response.fish[self.$route.params.id])
        var fishResponse = response.fish[self.$route.params.id]
        if (fishResponse === undefined) {
          self.errorMessage = '[self.fish_undefined@fetchFish@fishDetail]'
          self.error = true
          self.loading = false
        }
        self.fish = response.fish[self.$route.params.id]
        console.log('Detail data attached')
        self.loading = false
        self.loaded = true
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserFish@fetchFish@FishDetail] (Error: ' + error + ')'
        console.log('Failed! (Detail)', error)
        self.loading = false
        self.error = true
      })
    },
    getUserSettings () {
      var self = this
      this.loading = true
      getUserSettings().then(function (response) {
        console.log('Succes! (Settings)', response)
        self.userLanguage = response.language
        console.log('Language data attached')
        console.log('Language: ', self.userLanguage)
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserSettings@getUserSettings@FishDetail] (' + error + ')'
        console.log('Failed! (Settings)', error)
        self.loading = false
        self.error = true
      })
    }
  }
}
</script>

<style lang="sass" scoped>
//*
// Dit importeert de palette file.
// De underscore duidt aan dat het bestand niet geëxporteert hoeft te worden.
@import '../../style/_palette.sass'
@import '../../style/loading.css'
@import url('https://fonts.googleapis.com/css?family=Roboto')

.fishPicture
  width: 100%
  height: 300px
  background-color: $accent-color
  background-color: $accent-color
  background-repeat: no-repeat
  background-size: cover
  background-position: center

.fishName
  width: 100%
  height: 60px
  background-color: #F2F2F2
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
  transition: all 0.3s cubic-bezier(.25,.8,.25,1)
  display: flex
  justify-content: center

.fishText
  font-family: 'Roboto', sans-serif
  font-size: 24px
  padding-top: 15px


.loading-enter-active
  transition: opacity 1s

.loading-enter
  opacity: 0
</style>
