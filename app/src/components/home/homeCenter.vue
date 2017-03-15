<template lang="pug">
.center
  .wrapper
    //- De gebruiker ziet loading als de userFish nog worden gedownload.
    transition(appear, name='loading')
      .loading(v-if='loading')
        #loader Loading...
    //- Er verschijnt een waarschuwing als er iets fout ging bij het ophalen van de vissen.
    .error(v-if='error')
      p Er ging iets fout :(
      p Probeer het later opnieuw!
      p Kijk ook even of je internet hebt
      p Foutmelding: {{ errorMessage }}
    //-
      Als de vissen geladen zijn verschijnen de FishCards.
      Er zijn twee soorten FishCards, een voor Nederlands en een voor Engels.
      Welke verschijnt is gebaseerd op de instellingen van de gebruiker.
      Deze instellingen worden meegegeven als prop vanuit het 'Home' component.
      Via 'v-for' laden we alle vissen vanuit een json bestand.
    .cardContainer(v-if='loaded')
      fish-card(@buttonState='buttonStateManager($event)', v-if="language == 'nl'", v-for='fish in cards', :key="fish.id", :id='fish.id', :name='fish.speciesNl', :image='fish.image')
      fish-card(@buttonState='buttonStateManager($event)', v-if="language == 'en'", v-for='fish in cards', :key="fish.id", :id='fish.id', :name='fish.species', :image='fish.image')
</template>

<script>
/*
/ Deze twee commando's importeren bestanden die nodig zijn voor dit script.
/ FishCard is een component dat de kaarten waar de vissen in staan symboliseert.
/ {getUserFish} is een script die de vissen van de gebruiker ophaalt.
*/
import FishCard from '@/components/fish/FishCard.vue'
import {getUserFish} from '../../script/userFish.js'
/*
/ Parent: 'Home.vue'
*/
export default {
  /*
  / De prop is language zodat het parent component de juiste taal kan meegeven.
  / In data staan alle variabeles die dit component gebruikt.
  / 'loading' is standaard false zodat er pas een laad indicator wordt getoond als er daadwerkelijk iets geladen wordt.
  / 'cards' is null zodat er geen cards gerenderd worden als er geen zijn binnengekomen.
  / 'loaded' is false zodat het component pas verschijnt als de benodigde data is binnengekomen.
  */
  props: ['language'],
  data: function () {
    return {
      loading: false,
      cards: null,
      error: null,
      loaded: false,
      errorMessage: 'Failed to get error message'
    }
  },
  /*
  / Deze hook wordt opgeroepen wanneer dit component wordt geschapen.
  / Als het component wordt geschapen, worden de vissen van de gebruiker opgezocht.
  */
  created () {
    this.fetchFish()
  },
  methods: {
    /*
    / Deze methode haalt de vissen van de gebruiker op.
    / Dit wordt gedaan via een apart script met de functie 'getUserFish'.
    */
    fetchFish () {
      var self = this
      this.loading = true
      getUserFish().then(function (response) {
        console.log('Succes! (Cards)', response.fish)
        self.cards = response.fish
        self.loading = false
        self.loaded = true
        console.log('Card data attached')
      }, function (error) {
        self.errorMessage = '[promise_failed_getUserFish@fetchFish@HomeCenter] (Error: ' + error + ')'
        console.log('Failed! (Cards)', error)
        self.loading = false
        self.error = true
      })
    },
    /*
    / Deze method wordt gebruikt om de buttonState door te sturen naar het component hierboven.
    */
    buttonStateManager (data) {
      console.log('(HomeCenter) Got data from userFish: buttonState')
      console.log('(HomeCenter) Emitting buttonState to: Home')
      this.$emit('buttonState', data)
    }
  },
  /*
  / Dit zijn de componenten die HomeCenter gebruikt.
  */
  components: {
    FishCard
  }
}
</script>

<style lang="sass" scoped>
//*
// Dit importeert de palette file en de loader animatie.
// De underscore duidt aan dat het bestand niet geëxporteert hoeft te worden.
@import '../../style/_palette.sass'
@import '../../style/loading.css'

.center
  text-align: center

.wrapper
  display: inline-block
  margin-top: 10px

//*
// Animaties voor wanneer de loading animatie wordt weergeven.
// Dit zorgt ervoor dat alleen mensen die lang moeten wachten de animatie zien.
// Gaat 'flashes' tegen
.loading-enter-active
  transition: opacity 1s

.loading-enter
  opacity: 0

//*
// Deze container zit om de FishCards HomeCenter
// Via flexbox worden de cards onder elkaar gezet.
.cardContainer
  display: flex
  flex-direction: row
  flex-wrap: wrap
  padding-left: 6.2vw
  // TODO: Better padding.
</style>
