<!-- Dit is de homepagina die je te zien krijgt als je de app opent nadat het is geladen. -->
<template lang="pug">
.homeWrapper
  //- Loading wordt getoond als de instellingen van de gebruiker worden opgehaald.
  transition(appear, name='loading')
    .loading(v-if='loading')
      p#loadingMSG Loading home...
      #loader Loading...
  //- Error wordt getoond als er iets misging bij het ophalen van de instellingen van de gebruiker.
  .error(v-if='error')
    p Er ging iets fout :(
    p Probeer het later opnieuw!
    p Kijk ook even of je internet hebt
    p Foutmelding: {{ errorMessage }}
  //-
    'transition' zorgt ervoor dat de het compontent kan worden geanimeerd.
    'appear' wordt gebruikt om deze animatie uit te voeren bij het ontstaan van het element.
    'name' duidt op de naam van de animatie, die onder is beschreven in de SASS
  transition(appear, name='page')
    //- Dit wordt getoond als alles goed ging, en alles geladen is.
    .home(v-if='loaded')
      .upperBar
        p
          | {{ caughtText }}
      home-recent(@buttonState='buttonStateManager($event)', :language="userLanguage")
      home-sortbar
      //- De opgehaalde taal wordt in :language gezet zodat het component HomeCenter weet welke taal de gebruiker gebruikt.
      home-center(@buttonState='buttonStateManager($event)', :language="userLanguage")
</template>

<script>
/*
/ Deze twee commando's importeren bestanden die nodig zijn voor dit script.
/ HomeCenter is een component dat onder de sorteerbalk leeft.
/ {getUserSettings} is een script die de instellingen van de gebruiker ophaalt, dit is nodig om de taal van de gebruiker te bepalen.
*/
import HomeCenter from '@/components/home/HomeCenter.vue'
import HomeRecent from '@/components/home/HomeRecent.vue'
import HomeSortbar from '@/components/home/HomeSortbar.vue'
// import {getUserSettings} from '../../script/userSettings.js'
import {getData} from '../../script/getData.js'
/*
/ Parent: 'App.vue'
*/
export default {
  /*
  / In data staan alle variabeles die dit component gebruikt.
  / Standaard wordt de 'userLanguage' op null gezet omdat de taal later wordt opgehaald.
  / 'loading' is false om te zorgen dat de app alleen gaat laden als getUserSettings () wordt opgeroepen.
  / Loaded is false om te zorgen dat de app alleen maar heel de pagina laadt als de benodigde bestanden aanwezig zijn.
  */
  data: function () {
    return {
      userLanguage: null,
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
        console.log('[Home] Succes! (Settings)', response.language)
        self.loading = false
        self.loaded = true
        self.userLanguage = response.language
        console.log('[Home] Language data attached')
        console.log('[Home] Language: ', self.userLanguage)
        console.log('[Home] Emitting language to: App')
        self.$emit('userLanguage', self.userLanguage)
        if (self.userLanguage === 'nl') {
          self.caughtText = 'Recent gevangen:'
        } else if (self.userLanguage === 'en') {
          self.caughtText = 'Recently caught:'
        } else {
          self.caughtText = ''
        }
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserSettings@getUserSettings@Home] (' + error + ')'
        console.log('Failed! (Settings)', error)
        self.loading = false
        self.error = true
        console.log('[Home] Emitting language ERROR to: App')
        self.$emit('userLanguage', false)
      })
    },
    /*
    / Deze method wordt gebruikt om de buttonState door te sturen naar het component hierboven.
    */
    buttonStateManager (data) {
      console.log('(Home) Got data from homeCenter: buttonState')
      console.log('(Home) Emitting buttonState to: App')
      this.$emit('buttonState', data)
    }
  },
  /*
  / Dit zijn de componenten die home gebruikt.
  */
  components: {
    HomeCenter,
    HomeRecent,
    HomeSortbar
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="sass" scoped>
//*
// Dit importeert de palette file en het loading animatietje.
// De underscore duidt aan dat het bestand niet geëxporteert hoeft te worden.
@import '../../style/_palette.sass'
@import '../../style/loading.css'

.upperBar
  background-color: $primary-color-dark
  height: 30px
  width: 100%

.upperBar p
  color: white
  margin-left: 15px
  margin-top: 0px
  padding-top: 4px
  font-family: 'Roboto', sans-serif
  font-size: 18px

.recent
  background-color: $primary-color
  height: 200px
  width: 100%

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif
p
  color: black
  font-family: 'Roboto', sans-serif

//*
// Animaties voor wanneer het component wordt gecreërd.
.page-enter-active
  transition: opacity .2s

.page-enter
  opacity: 0

//*
// Animaties voor wanneer de loading animatie wordt weergeven.
// Dit zorgt ervoor dat alleen mensen die lang moeten wachten de animatie zien.
.loading-enter-active
  transition: opacity 1s

.loading-enter
  opacity: 0

//*
// Dit zorgt ervoor dat de FishMenu niet in de weg zit als je dingen probeert te lezen aan de onderkant.
.center
  padding-bottom: 70px
</style>
