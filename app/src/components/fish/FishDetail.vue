<!-- Dit is het component voor het scherm wat je ziet als je op een vis klikt. -->
<template lang="pug">
.wrapper
  transition(appear, name='loading')
    .loading(v-if='loading')
      p#loadingMSG Loading fish...
      #loader Loading...
  .error(v-if='error')
  .fishDetail(v-if='loaded')
    .fishPicture(:style="{ backgroundImage: 'url(' + fish.image + ')' }")
    .fishName(v-if='userLanguage == "nl"')
      .fishWrapper
        .fishText {{ fish.speciesNl }}
        .fishDate Gevangen op: {{ date }}
    .fishName(v-if='userLanguage == "en"')
      .fishText {{ fish.species }}
      .fishDate Caught at: {{ date }}
    .fishInfo(v-if='userLanguage == "nl"')
      p Length: {{ fish.length }} centimeter
      p Weight: {{ fish.weight }} kilo
      p {{ fish.description }}
    .fishIngo(v-if='userLanguage == "en"')
      p Length: {{ inches }} inches
      p Weight: {{ pounds }} pounds
      p {{ fish.description }}
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
      image: null
    }
  },
  created () {
    console.log('Fish opened, bound to id: ', this.$route.params.id)
    this.loading = true
    this.fetchDetailPage()
    // console.log('(FishDetail Emitting buttonState to: App')
    // this.$emit('buttonState', 'up')
  },
  methods: {
    fetchDetailPage () {
      var self = this
      this.loading = true
      getUserSettings().then(function (response) {
        console.log('Succes! (Settings)', response)
        self.userLanguage = response.language
        console.log('Language data attached')
        console.log('Language: ', self.userLanguage)
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserSettings@fetchDetailPage@FishDetail] (' + error + ')'
        console.log('Failed! (Settings)', error)
        self.loading = false
        self.error = true
      })
      getUserFish().then(function (response) {
        if (response === false) {
          self.errorMessage = '[self.fish_undefined@fetchDetailPage@fishDetail]'
          self.error = true
          self.loading = false
        }
        var fishResponse = response.fish[self.$route.params.id]
        console.log('Succes! (Detail)', fishResponse)
        self.fish = response.fish[self.$route.params.id]
        console.log('Detail data attached')
        self.loading = false
        self.loaded = true
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserFish@fetchDetailPage@FishDetail] (Error: ' + error + ')'
        console.log('Failed! (Detail)', error)
        self.loading = false
        self.error = true
      })
    }
  },
  computed: {
    date () {
      var date = new Date(this.fish.date * 1000)
      var hours = date.getHours()
      var minutes = '0' + date.getMinutes()
      var seconds = '0' + date.getSeconds()
      return hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2)
    },
    inches () {
      return (this.fish.length * 0.393700787).toFixed(2)
    },
    pounds () {
      return (this.fish.weight * 2.2046).toFixed(2)
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
