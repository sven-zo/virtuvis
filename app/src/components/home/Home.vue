<template lang="pug">
transition(appear, name='page')
  .loading(v-if='loading')
    | Loading...
  .error(v-if='error')
    p Er ging iets fout :(
    p Probeer het later opnieuw!
    p Kijk ook even of je internet hebt
    p Foutmelding: promise_failed_getUserSettings
  .home(v-if='loaded')
    .upperBar
      p
        | Net gevangen:
    .recent
    .sortbar
    home-center(:language="userLanguage")
</template>

<script>
import HomeCenter from '@/components/home/HomeCenter.vue'
import {getUserSettings} from '../../script/userSettings.js'

export default {
  data: function () {
    return {
      userLanguage: null,
      loaded: false,
      loading: false,
      error: null
    }
  },
  created () {
    this.getUserSettings()
  },
  methods: {
    getUserSettings () {
      var self = this
      this.loading = true
      getUserSettings().then(function (response) {
        console.log('Succes! (Settings)', response)
        self.loading = false
        self.loaded = true
        self.userLanguage = response.language
        console.log('Language data attached')
        console.log('Language: ', self.userLanguage)
      }, function (error) {
        console.log('Failed! (Settings)', error)
        self.loading = false
        self.error = true
      })
    }
  },
  components: {
    HomeCenter
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="sass" scoped>
@import '../../style/palette.sass'

.upperBar
  background-color: $primary-color-dark
  //height: 5vw
  height: 30px
  width: 100%

.upperBar p
  color: white
  margin-left: 15px
  margin-top: 0px
  padding-top: 4px
  font-family: 'Roboto', sans-serif
  //font-size: 3vw
  font-size: 18px

.recent
  background-color: $primary-color
  //height: 26vw
  height: 200px
  width: 100%

.sortbar
  background-color: $divider-color
  //height: 10vw
  height: 50px
  width: 100%

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif
p
  color: black
  font-family: 'Roboto', sans-serif

// Page animations
.page-enter-active
  transition: opacity .2s

.page-enter
  opacity: 0

.center
  padding-bottom: 70px
</style>
