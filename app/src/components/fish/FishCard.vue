<!-- Dit is het component voor de kaarten met vissen die je ziet op het homescreen. -->
<template lang="pug">
//-
  'transition' zorgt ervoor dat de het compontent kan worden geanimeerd.
  'appear' wordt gebruikt om deze animatie uit te voeren bij het ontstaan van het element.
  'name' duidt op de naam van de animatie, die onder is beschreven in de SASS
transition(appear, name='card')
  .card(:id='cardId')
    .material(@click='navigate', :style="{ backgroundImage: 'url(' + image + ')' }")
    p  {{ processedName }}
</template>

<script>
/*
/ Parent: 'HomeCenter.vue'
*/
export default {
  props: ['id', 'name', 'image'],
  computed: {
    /*
    / Dit zet het ID van de card op een unieke waarde bij het creëren.
    / Een card met id 1 zou als DOM-id card_id_1 krijgen.
    / Dit is handig om de cards later te kunnen selecteren via de DOM API vanuit andere componenten.
    */
    cardId () {
      return 'card_id_' + this.id + ' card'
    },
    processedName () {
      if (this.name.length > 15) {
        return this.name.substr(0, 15) + '...'
      } else {
        return this.name
      }
    }
  },
  created () {
    // this.cropImage()
  },
  methods: {
    /*
    / Deze method wordt gecalled als iemand in op een fishCard klikt.
    / Het stuurt de gebruiker door naar de juiste pagina,
    / en emit een bericht naar het component hierboven
    / (om te zorgen dat het fishMenu knopje omhoog beweegt)
    / De data neemt deze weg:
    / FishCard -> HomeCenter -> Home -> App -> FishMenu
    */
    navigate () {
      if (event) {
        console.log('[FishCard] Emitting buttonState to [HomeCenter]')
        this.$emit('buttonState', 'up')
        console.log('[FishCard] Routing to ', this.id)
        this.$router.push('/fish/' + (this.id))
      }
    } // },
    /**
     *
     */
    // cropImage () {
    //   var imageObj = new Image()
    //   imageObj.src = this.image + '?' + new Date().getTime()
    //   imageObj.setAttribute('crossOrigin', '')
    //   imageObj.addEventListener('load', function () {
    //     console.log('Image ' + this.id + ' loaded.')
    //     var card = document.getElementById('card_id_' + this.id)
    //     // var material = card.children[0]
    //     card.style.backgroundImage = imageObj
    //   })
    // }
  }
}
</script>

<style lang="sass">
//*
// Dit importeert de palette file.
// De underscore duidt aan dat het bestand niet geëxporteert hoeft te worden.
@import '../../style/_palette.sass'

//*
// Dit is het uiterlijk van de kaart met de foto
.material
  background-color: $accent-color
  background-repeat: no-repeat
  background-size: cover
  width: 40vw
  height: 40vw
  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24)
  transition: all 0.3s cubic-bezier(.25,.8,.25,1)

//*
// Wrapper voor de kaart met de tekst er onder
.card
  // TODO: Add more media queries for smaller/bigger screen sizes
  margin: 10px
  font-family: 'Roboto', sans-serif

//*
// Animaties voor wanneer het component wordt gecreërd.
.card-enter-active
  transition: opacity .2s

.card-enter
  opacity: 0
</style>
