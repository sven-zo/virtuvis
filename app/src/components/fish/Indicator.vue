<template lang="pug">
.indicator
  img(:src="'../../static/bar/' + out[0] + '.png'")
  img(:src="'../../static/bar/' + out[1] + '.png'")
  img(:src="'../../static/bar/' + out[2] + '.png'")
  img(:src="'../../static/bar/' + out[3] + '.png'")
  img(:src="'../../static/bar/' + out[4] + '.png'")
</template>

<script>
  export default {
    props: ['number'],
    data: function () {
      return {
        out: []
      }
    },
    created () {
      var list = [
        'bar',
        'bar',
        'bar',
        'bar',
        'bar'
      ]
      for (var i = 0; i < this.number; i++) {
        list[i] = 'fillbar'
      }
      // console.log(list)
      for (var j = 0; j < 5; j++) {
        this.out[j] = list[j]
      }
    }
  }
</script>

<style lang="sass">
@import '../../style/_palette.sass'

.indicator
  display: flex
  height: 53px

.indicator img
  height: 17.666667px
  width: 50px
  padding-right: 5px

</style>
