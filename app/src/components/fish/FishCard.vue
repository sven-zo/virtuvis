<template>
  <div class="card" :style="{ backgroundImage: 'url(' + image + ')' }">
    {{ name }}
  </div>
</template>

<script>
export default {
  props: ['name', 'image']
}
</script>

<style lang="sass">
@import '../../style/_palette.sass'

.card
  background-color: $accent-color
  background-repeat: no-repeat
  background-size: cover
  width: 40vw
  // Later een media query voor meer cards per row in grote ipad ofzo
  height: 40vw
  margin: 10px
</style>
