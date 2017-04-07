<template lang="pug">
.wrapper
  transition(appear, name='loading')
    .loading(v-if='loading')
      p#loadingMSG Loading settings...
      #loader Loading...
  transition(appear, name='page')
    .loaded(v-if='loaded')
      .settings(v-if="userLanguage === 'nl'")
        .upperBar
          p  Instellingen:
        .text
          p Huidige gebruikersnaam: {{userName}}
          a(href='#') Wijzig gebruikernaam
          p Huidig metrisch stelsel: {{userMetric}}
          a(href='#') Gebruik centimeters en kilo
          br
          a(href='#') Gebruik inches en pounds
          p Language: {{userLanguage}}
          p Waarschuwing! Herstart alsjeblieft de app na het zetten van een taal!
          a(href='#', @click='setUserLanguage("nl")') Zet taal naar Nederlands
          br
          a(href='#', @click='setUserLanguage("en")') Zet taal naar Engels / Switch language to English
      .settings(v-if="userLanguage === 'en'")
        .upperBar
          p  Settings:
        .text
          p Current username: {{userName}}
          a(href='#', @click='setUserName()') Change username
          p Current metric system: {{userMetric}}
          a(href='#', @click='setUserMetric("cm")') Use centimeters and kilo
          br
          a(href='#', @click='setUserMetric("inch")') Use inches and pounds
          p Language: {{userLanguage}}
          p Warning! Please restart the app after selecting a new language!
          a(href='#', @click='setUserLanguage("nl")') Switch language to Dutch / Zet taal naar Nederlands
          br
          a(href='#', @click='setUserLanguage("en")') Switch language to English
  .credits
    .text
      br
      br
      p Credits:
      p VirtuVis API: Imani Dap
      p VirtuVision: Budi Han
      p VirtuVijver: Emma van Klinken
      p VirtuVis APP: Sven Hoffmann
      br
      p Special thanks aan iedereen die ons lief is <3
</template>

<script>
import {getData} from '../../script/getData.js'
import {getVirtuVisAPIUrl} from '../../../secret/API-url.js'

import * as reqwest from 'Reqwest'

export default {
  data: function () {
    return {
      userLanguage: null,
      userMetric: null,
      userName: null,
      loaded: false,
      loading: false,
      error: null,
      errorMessage: 'Failed to get error message',
      caughtText: '...'
    }
  },
  /*
  / Deze hook wordt opgeroepen wanneer dit component wordt geschapen.
  / Als het component wordt geschapen, wordt de taal van de gebruiker opgezocht.
  */
  created () {
    this.getUserSettings()
    this.$emit('buttonColor', '#673AB7')
  },
  methods: {
    /*
    / Deze methode haalt de taal van de gebruiker op.
    / Dit wordt gedaan via een apart script met een functie met dezelfde naam.
    */
    getUserSettings () {
      var self = this
      this.loading = true
      getData('user').then(function (response) {
        console.log('[Settings] Succes! (Settings)', response)
        self.loading = false
        self.loaded = true
        self.userLanguage = response.language
        self.userMetric = response.metric
        self.userName = response.name
        console.log('[Settings] Language data attached')
        console.log('[Settings] Language: ', self.userLanguage)
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserSettings@getUserSettings@AddRod] (' + error + ')'
        console.log('Failed! (Settings)', error)
        self.loading = false
        self.error = true
      })
    },
    setUserLanguage (lang) {
      getData('fingerprint').then(function (response) {
        var r = response
        reqwest({
          url: getVirtuVisAPIUrl('user'),
          contentType: 'application/json',
          crossOrigin: true,
          data: [
              {name: 'action', value: 'UPDATE'},
              {name: 'user', value: r},
              {name: 'language', value: lang}
          ]
        })
      })
      this.$router.push('/')
    },
    setUserName () {
      var newName = window.prompt(this.getLocalString('namePrompt'))
      console.log(newName)
      if (newName != null) {
        if (newName.length > 15) {
          alert(this.getLocalString('namePromptLong'))
          this.editFishName(true)
        } else {
          getData('fingerprint').then(function (response) {
            reqwest({
              url: getVirtuVisAPIUrl('user'),
              contentType: 'application/json',
              crossOrigin: true,
              data: {
                action: 'UPDATE',
                fingerprint: response,
                username: newName
              }
            })
          })
          this.$router.push('/')
        }
      }
    },
    setUserMetric (metric) {
      getData('fingerpint').then(function (response) {
        reqwest({
          url: getVirtuVisAPIUrl('user'),
          contentType: 'application/json',
          crossOrigin: true,
          data: {
            action: 'UPDATE',
            fingerprint: response,
            metric: metric
          }
        })
      })
    },
    getLocalString (string) {
      // TODO elegantere oplossing
      switch (string) {
        case 'namePromptLong':
          if (this.userLanguage === 'nl') {
            return 'Geef jezelf alsjeblieft een naam korter dan 15 letters.'
          } else {
            return 'Please give yourself a name with less than 15 letters.'
          }
        case 'namePrompt':
          if (this.userLanguage === 'nl') {
            return 'Hoe wil je jezelf noemen?'
          } else {
            return 'What do you want to call yourself?'
          }
        default:
          return 'Error!'
      }
    }
  }
}
</script>

<style lang="sass" scoped>
@import '../../style/palette.sass'
@import url('https://fonts.googleapis.com/css?family=Roboto')

.text
  padding-left: 10px

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

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif
p
  color: black
  font-family: 'Roboto', sans-serif

.page-enter-active
  transition: opacity .2s

.page-enter
  opacity: 0

.loading-enter-active
  transition: opacity 1s

.loading-enter
  opacity: 0

.credits
  color: grey
  font-size: 80%
</style>
