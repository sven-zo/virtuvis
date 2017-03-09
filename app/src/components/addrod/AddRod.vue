<!-- Dit is het component voor de pagina waar je je vishengel kan toevoegen. -->
<template lang="pug">
//-
  'transition' zorgt ervoor dat de het compontent kan worden geanimeerd.
  'appear' wordt gebruikt om deze animatie uit te voeren bij het ontstaan van het element.
  'name' duidt op de naam van de animatie, die onder is beschreven in de SASS
transition(appear, name='page')
  .settings
    .upperBar
      p  Vishengel toevoegen:
    .bottomBar
      p  Leg je dobber op het scherm.
</template>

<script>
/*
/ Parent: 'App.vue'
*/
</script>

<style lang="sass" scoped>
//*
// Dit importeert de palette file.
// De underscore duidt aan dat het bestand niet geëxporteert hoeft te worden.
@import '../../style/palette.sass'

.bottomBar
  background-color: red
  width: 100%
  height: 90vh

.bottomBar p
  color: white
  font-size: 24px
  font-family: 'Roboto', sans-serif
  text-align: center
  padding-top: 10px
  margin-top: 0px

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

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif
p
  color: black
  font-family: 'Roboto', sans-serif
</style>
