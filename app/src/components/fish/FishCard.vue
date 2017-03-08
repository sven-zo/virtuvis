<template>
  <div class="card">
    {{ name }}
  </div>
</template>

<script>
export default {
  props: ['name']
}
</script>

<style lang="sass">
@import '../../style/_palette.sass'

.card
  background-color: $accent-color
  width: 40vw
  // Later een media query voor meer cards per row in grote ipad ofzo
  height: 40vw
  margin: 10px
</style>
