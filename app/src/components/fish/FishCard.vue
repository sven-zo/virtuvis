<template>
  <div class="card" :id="cardId">
    {{ name }}
  </div>
</template>

<script>
var cards = document.getElementsByClassName('card')

export default {
  props: ['id', 'name', 'image'],
  computed: {
    cardId () {
      return 'card_id_' + this.id + ' card'
    }
  },
  created () {
    this.setImage()
  },
  methods: {
    setImage () {
      var self = this
      var img = new Image()
      var card = cards[this.id]
      img.src = this.image

      var checkImage = setInterval(function () {
        if (img.complete) {
          clearInterval(checkImage)
          console.log('card_id_' + self.id)
          card.style.backgroundColor = 'red'
          // document.getElementById('card_id_' + self.id).style.backgroundImage = 'url(' + img.src + ')'
        }
      }, 50)
    }
  }
}
</script>

<style lang="sass">
@import '../../style/_palette.sass'

.card
  background-color: $accent-color
  background-repeat: no-repeat
  background-size: cover
  background-image:
  width: 40vw
  // Later een media query voor meer cards per row in grote ipad ofzo
  height: 40vw
  margin: 10px
</style>
