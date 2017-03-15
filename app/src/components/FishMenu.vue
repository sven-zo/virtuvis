<!-- Dit is het menu wat je ziet aan de onderkant van het scherm. -->
<template lang="pug">
.menu
  //-
    'transition' zorgt ervoor dat de het compontent kan worden geanimeerd.
    'appear' wordt gebruikt om deze animatie uit te voeren bij het ontstaan van het element.
    'name' duidt op de naam van de animatie, die onder is beschreven in de SASS
  transition(appear, name='fade')
    //- Als er wordt geklikt op deze button, wordt de methode rodClick() opgeroepen
    #rod.button(@click='rodClick')
      div
        //- De class van de images worden dynamisch aangepast zodat deze kunnen worden geanimeerd.
        img(:class='rodClass', src='../assets/rod.png')
      div {{ rodText }}
  transition(appear, name='fade')
    //- De class van #middleButton wordt dynamisch bepaald zodat de hoogte kan worden aangepast.
    #middleButton(@click='middleButtonClick', :class='middleButtonClass')
      p.homeText  {{ homeText }}
  transition(appear, name='fade')
    #cog.button(@click='cogClick')
      div
        img(:class='cogClass', src='../assets/settings.png')
      div {{ settingsText }}
</template>

<script>
//  import {getUserSettings} from '../script/userSettings.js'

/*
/ Parent: 'App.vue'
*/
export default {
  /*
  / In data bevinden zich de variabeles die dit component gebruikt.
  / cogClass en rodClass worden gedefault zodat er geen visuele glitches onstaan bij het laden.
  / De middleButtonClass is standaard 'middleButtonDown' zodat de homeknop naar beneden staat.
  */
  data () {
    return {
      cogClass: 'cog',
      rodClass: 'rod',
      middleButtonClass: 'middleButtonDown',
      loading: true,
      error: null,
      loaded: false,
      userLanguage: null
    }
  },
  props: [
    'state',
    'lang'
  ],
  created () {
    // this.getUserSettings()
  },
  methods: {
    /*
    / cogClick en cogReset worden gebruikt om te animeren.
    / Ook stuurt cogClick de gebruiker naar de juiste pagina.
    / Als de gebruiker op een button klikt die niet naar home gaat, wordt de middleButton omhoog geanimeerd.
    */
    cogClick (event) {
      if (event) {
        this.cogClass = 'cogTurn'
        this.$router.push('/settings')
        setTimeout(this.cogReset, 1000)
        this.middleButtonClass = 'middleButtonUp'
      }
    },
    cogReset () {
      this.cogClass = 'cog'
    },
    /*
    / Hetzelfde geldt voor rodClick
    */
    rodClick (event) {
      if (event) {
        this.rodClass = 'rodAnimation'
        this.$router.push('/addrod')
        setTimeout(this.rodReset, 1000)
        this.middleButtonClass = 'middleButtonUp'
      }
    },
    rodReset () {
      this.rodClass = 'rod'
    },
    /*
    / Als er op de homeknop wordt gedrukt navigeert de app naar home.
    / Ook wordt de homebutton naar beneden geanimeerd.
    */
    middleButtonClick (event) {
      if (event) {
        this.$router.push('/')
        this.middleButtonClass = 'middleButtonDown'
      }
    }// ,
    // getUserSettings () {
    //   var self = this
    //   this.loading = true
    //   getUserSettings().then(function (response) {
    //     console.log('Succes! (FishMenu)', response.language)
    //     self.loading = false
    //     self.loaded = true
    //     self.userLanguage = response.language
    //     console.log('Language data attached')
    //     console.log('Language: ', self.userLanguage)
    //   }, function (error) {
    //     self.errorMessage = '[promise_failed_getUserSettings@getUserSettings@FishMenu] (' + error + ')'
    //     console.log('Failed! (FishMenu)', error)
    //     self.loading = false
    //     self.error = true
    //   })
    // }
  },
  watch: {
    'state': function (val, oldVal) {
      // console.log(oldVal + 'has been changed to ' + val + ' from outside.')
      if (val === 'up') {
        this.middleButtonClass = 'middleButtonUp'
        console.log('[FishMenu] Emitting back to App, to reset the watcher.')
        this.$emit('buttonReset', 'true')
      }
    },
    'lang': function (val, oldVal) {
      if (!val) {
        console.log('[FishMenu] Got language error from [App]')
        this.error = true
        this.loaded = true
      } else {
        console.log('[FishMenu] Setting userLanguage')
        this.userLanguage = val
        this.loading = false
        this.loaded = true
      }
    }
  },
  computed: {
    rodText () {
      if (this.loading) {
        return '...'
      } else if (this.error) {
        return 'Hengel / Fishing rod'
      } else if (this.loaded) {
        if (this.userLanguage === 'nl') {
          return 'Vishengel toevoegen'
        } else if (this.userLanguage === 'en') {
          return 'Add rod'
        }
      }
    },
    homeText () {
      if (this.loading) {
        return '...'
      } else if (this.error) {
        return 'Home'
      } else if (this.loaded) {
        if (this.userLanguage === 'nl') {
          return 'Terug'
        } else if (this.userLanguage === 'en') {
          return 'Home'
        }
      }
    },
    settingsText () {
      if (this.loading) {
        return '...'
      } else if (this.error) {
        return 'Settings / Instellingen'
      } else if (this.loaded) {
        if (this.userLanguage === 'nl') {
          return 'Instellingen'
        } else if (this.userLanguage === 'en') {
          return 'Settings'
        }
      }
    }
  }
}
</script>

<style lang="sass" scoped>
//*
// Dit importeert de palette file.
// De underscore duidt aan dat het bestand niet geëxporteert hoeft te worden.
// Ook wordt de Roboto font ingeladen.
@import '../style/palette.sass'
@import url('https://fonts.googleapis.com/css?family=Roboto')

// Settings:
// menu-height: height of the menu bar [default: 70]
// middle-button-offset: [default: 10 / old default: 20] (the lower the more extreme)
$menu-height: 70px
$middle-button-offset: 10px

//*
// Menu:
.menu
  font-family: 'Roboto', sans-serif
  font-size: 12px
  color: $primary-text-color
  height: $menu-height
  background-color: $divider-color
  display: flex
  flex-direction: row
  justify-content: space-around
  position: fixed
  width: 100%
  bottom: 0

//*
// Buttons:
.button
  width: 33%
  display: flex
  flex-direction: column
  justify-content: center

.button div
  display: flex
  flex-direction: row
  justify-content: center

.button img
  max-height: $menu-height - 20px
  max-width: $menu-height - 20px
  padding-bottom: 0px

//*
// Home button:
@keyframes up
  from
    transform: translate(0px, 0px)
  to
    transform: translate(0px, $menu-height - 100px + $middle-button-offset)

@keyframes down
  from
    transform: translate(0px, $menu-height - 100px + $middle-button-offset)
  to
    transform: translate(0px, 0px)

.middleButtonDown
  animation-name: down
  animation-duration: 0.5s

.middleButtonDownRipple
  animation-name: pressMiddle
  animation-duration: 0.5s

.middleButtonUp
  animation-name: up
  animation-duration: 0.5s
  transform: translate(0px, $menu-height - 100px + $middle-button-offset)

#middleButton
  background-image: url('../assets/book.png')
  background-size: $menu-height - 20px, $menu-height - 20px
  background-repeat: no-repeat
  background-position: 50% 40%
  height: $menu-height
  width: $menu-height
  border-radius: 50%
  background-color: $primary-color-dark
  color: $primary-color-dark

.homeText
  padding-top: 58%
  padding-left: 25%
  color: $primary-text-color
  transform: translate(0px, 20px)

//*
// Animations for the cog and rod:
@keyframes turnclick
  0%
    transform: rotate(0deg)
  25%
    transform: rotate(-50deg)
  100%
    transform: rotate(180deg)

@keyframes rodAnimation
  0%
    transform: rotate(0deg)
  25%
    transform: rotate(45deg)
  50%
    transform: rotate(-45deg)
  100%
    transform: rotate(0deg)

@keyframes press
  0%
    background-color: $divider-color
  10%
    background-color: $primary-color-light
  100%
    background-color: $divider-color

@keyframes pressMiddle
  0%
    background-color: $primary-color-dark
  10%
    background-color: $primary-color
  100%
    background-color: $primary-color-dark

#cog:hover
  animation-name: press
  animation-duration: 0.5s

.cogTurn
  animation-name: turnclick
  animation-duration: 1s
  animation-iteration-count: 1

#rod:hover
  animation-name: press
  animation-duration: 0.5s

.rodAnimation
  animation-name: rodAnimation
  animation-duration: 1s
  animation-timing-function: ease-in-out

//*
// Animaties voor wanneer het component wordt gecreërd.
.fade-enter-active
  transition: opacity .5s

.fade-enter
  opacity: 0

</style>
