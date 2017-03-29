
<!-- Dit is het component voor het scherm wat je ziet als je op een vis klikt. -->
<template lang="pug">
.wrapper
  //-
    'transition' zorgt ervoor dat de het compontent kan worden geanimeerd.
    'appear' wordt gebruikt om deze animatie uit te voeren bij het ontstaan van het element.
    'name' duidt op de naam van de animatie, die onder is beschreven in de SASS
  transition(appear, name='loading')
    //- Dit wordt getoond als deze pagina laadt
    .loading(v-if='loading')
      p#loadingMSG Loading fish...
      #loader Loading...
  //- Dit wordt getoond als er errors zijn
  .error(v-if='error')
  //- Dit wordt getoond als de pagina geladen is
  .fishDetail(v-if='loaded')
    .fishPicture(:style="{ backgroundImage: 'url(' + fish.image + ')' }")
    .fishName(v-if='userLanguage == "nl"')
      .fishWrapper
        .fishText
          .name {{processedName}}
          fish-button(type='edit', @click='editFishName')
          //-a.edit(href='#', @click='editFishName') BWRK
          .species ({{ fish.species_nl }})
        .fishDate Gevangen op: {{ date }}
    .fishName(v-if='userLanguage == "en"')
      .fishWrapper
        .name {{processedName}}
        //- fish-button(type='edit')
        //-a.edit(href='#', @click='editFishName') EDIT
        .species ({{ fish.species_en }})
        .fishDate Caught on: {{ date }}
    .fishInfo(v-if='userLanguage == "nl"')
      .fishLine
        .fishInfoLeft
          p Lengte: {{ fish.length }} centimeter
          p Gewicht: {{ fish.weight }} kilo
        .fishInfoRight
          indicator(number='1')
          indicator(number='4')
      p.fishDescription {{ fish.description }}
    .fishInfo(v-if='userLanguage == "en"')
      .fishLine
        .fishInfoLeft
          p Length: {{ fish.length }} inches
          p Weight: {{ fish.weight }} pounds
        .fishInfoRight
          indicator(number='3')
          indicator(number='5')
      p.fishDescription (Er zijn nog geen descriptions in het Engels) {{ fish.description }}
</template>

<script>
import FishButton from '@/components/FishButton'
import Indicator from '@/components/fish/Indicator'

// import {getUserFish} from '../../script/userFish.js'
// import {getUserSettings} from '../../script/userSettings.js'
import {getData} from '../../script/getData.js'
import {getVirtuVisAPIUrl} from '../../../secret/API-url.js'

import * as reqwest from 'Reqwest'
import * as Vibrant from 'node-vibrant'

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
  components: {
    Indicator,
    FishButton
  },
  created () {
    console.log('[FishDetail] Fish opened, bound to id: ', this.$route.params.id)
    this.loading = true
    this.fetchDetailPage()
  },
  methods: {
    /*
    / Deze functie haalt alle benodigde gegevens voor de detailpagina op.
    */
    fetchDetailPage () {
      var self = this
      this.loading = true
      getData('user').then(function (response) {
        console.log(' [FishDetail]Succes! (Settings)', response)
        self.userLanguage = response.language
        console.log('[FishDetail] Language data attached')
        console.log('[FishDetail] Language: ', self.userLanguage)
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserSettings@fetchDetailPage@FishDetail] (' + error + ')'
        console.log('Failed! (Settings)', error)
        self.loading = false
        self.error = true
      })
      getData('recent').then(function (response) {
        if (response === false) {
          self.errorMessage = '[self.fish_undefined@fetchDetailPage@fishDetail]'
          self.error = true
          self.loading = false
        }
        var fishResponse = response.fish[self.$route.params.id]
        console.log('[FishDetail] Succes! (Detail)', fishResponse)
        self.fish = response.fish[self.$route.params.id]
        console.log('[FishDetail] Detail data attached')
        self.loading = false
        self.loaded = true

        console.log('[FishDetail] Getting palette for image:', self.fish.image)
        let v = new Vibrant(self.fish.image)
        // v.getPalette().then((palette) => console.log(palette.Vibrant.getHex()))
        // v.getPalette().then((palette) => document.getElementsByClassName('fishPicture')[0].style.backgroundColor = palette.Vibrant.getHex())
        v.getPalette().then(function (palette) {
          console.log('[FishDetail] Palette kleuren worden gezet.')
          document.getElementsByClassName('fishPicture')[0].style.backgroundColor = palette.Muted.getHex()
          document.getElementsByClassName('fishName')[0].style.backgroundColor = palette.Vibrant.getHex()
          document.getElementsByClassName('fishText')[0].style.color = palette.Vibrant.getTitleTextColor()
          document.getElementsByClassName('fishDate')[0].style.color = palette.Vibrant.getBodyTextColor()
          console.log('[FishDetail] Emitting buttonColor to [App]')
          self.$emit('buttonColor', palette.DarkVibrant.getHex())
        })
        // -
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserFish@fetchDetailPage@FishDetail] (Error: ' + error + ')'
        console.log('Failed! (Detail)', error)
        self.loading = false
        self.error = true
      })
    },
    editFishName () {
      var newName = window.prompt(this.getLocalString('namePrompt'), this.fish.name)
      console.log(newName)
      if (newName != null) {
        if (newName.length > 15) {
          alert(this.getLocalString('namePromptLong'))
          this.editFishName(true)
        } else {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {
              action: 'UPDATE',
              fish: this.fish.id,
              name: newName
            }
          })
          this.fish.name = newName
        }
      }
    },
    getLocalString (string) {
      // TODO elegantere oplossing
      switch (string) {
        case 'namePromptLong':
          if (this.lang === 'nl') {
            return 'Geef je vis alsjeblieft een kortere naam dan 15 letters.'
          } else {
            return 'Please give your fish a name with less than 15 letters.'
          }
        case 'namePrompt':
          if (this.lang === 'nl') {
            return 'Hoe wil je je vis noemen?'
          } else {
            return 'What do you want to call your fish?'
          }
        default:
          return 'Error!'
      }
    }
  },
  computed: {
   /**
    * Deze computed zorgt er voor dat de meegestuurde timestamp wordt
    * omgezet naar leesbare tijd.
    * @return {String} Tijd als string
    */
    date () {
      var date = new Date(this.fish.date * 1000)
      var hours = date.getHours()
      var minutes = '0' + date.getMinutes()
      var seconds = '0' + date.getSeconds()
      return hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2)
    },
   /**
    * Deze computed zet centimeter om naar inches
    * als de gebruiker inches als lengte-unit gebruikt
    * @return {number} Lengte in inches
    */
    inches () {
      return (this.fish.length * 0.393700787).toFixed(2)
    },
   /**
    * Deze computed zet kilogram om naar pounds
    * als de gebruiker pounds als gewicht-unit gebruikt
    * @return {number} Gewicht in pounds
    */
    pounds () {
      return (this.fish.weight * 2.2046).toFixed(2)
    },
    processedName () {
      console.log(this.fish.name.length)
      if (this.fish.name.length > 10) {
        return this.fish.name.substr(0, 10) + '...'
      } else {
        return this.fish.name
      }
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
  background-repeat: no-repeat
  // background-size: contain
  background-size: cover
  background-position: center

.fishName
  width: 100%
  height: 60px
  background-color: #F2F2F2
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)
  transition: all 0.3s cubic-bezier(.25,.8,.25,1)
  display: flex
  justify-content: center

.fishText
  font-family: 'Roboto', sans-serif
  font-size: 24px
  padding-top: 15px
  display: flex

.fishText .species
  margin-left: 10px

.fishText .edit
  margin-left: 10px

.fishDate
  font-family: 'Roboto', sans-serif
  color: gray
  padding-left: 22vw

.fishInfo
  font-family: 'Roboto', sans-serif
  color: black
  padding-left: 10px
  padding-right: 10px

.fishLine
  display: flex

.fishText
  padding-top: 10px
  text-align: center

.fishInfoRight
  padding-top: 1em

.fishDescription
  padding-bottom: 100px

.fishInfoLeft
  padding-right: 1em

.fishInfoLeft p:last-child
  padding-top: 1em

.loading-enter-active
  transition: opacity 1s

.loading-enter
  opacity: 0
</style>
