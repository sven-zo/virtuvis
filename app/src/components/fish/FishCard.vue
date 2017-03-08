<template lang="pug">
transition(appear, name='card')
  .card(:id='cardId')
    .material(:style="{ backgroundImage: 'url(' + image + ')' }")
    p  {{ name }}
</template>

<script>
export default {
  props: ['id', 'name', 'image'],
  computed: {
    cardId () {
      return 'card_id_' + this.id + ' card'
    }
  }
}
</script>

<style lang="sass">
@import '../../style/_palette.sass'

.material
  background-color: $accent-color
  background-repeat: no-repeat
  background-size: cover
  width: 40vw
  height: 40vw

.card
  background-repeat: no-repeat
  background-size: cover
  background-image:
  // Later een media query voor meer cards per row in grote ipad ofzo
  margin: 10px

.card-enter-active
  transition: opacity .2s

.card-enter
  opacity: 0
</style>
