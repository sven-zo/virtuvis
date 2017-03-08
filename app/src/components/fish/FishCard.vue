<template>
  <div :class="cardClass">
    {{ name }}
  </div>
</template>

<script>
export default {
  props: ['id', 'name', 'image'],
  computed: {
    cardClass () {
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
      img.src = this.image

      var checkImage = setInterval(function () {
        if (img.complete) {
          clearInterval(checkImage)
          console.log('card_id_' + self.id)
          document.getElementsByTagName('card_id_' + self.id)[0].style.backgroundColor = 'red'
          document.getElementsByTagName('card_id_' + self.id)[0].style.backgroundImage = 'url(' + img.src + ')'
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
