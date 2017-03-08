<template lang="pug">
.center
  .wrapper
    .cardContainer
      - for (var x = 0; x < 15; x++)
        fish-card
</template>

<script>
import FishCard from '@/components/fish/FishCard.vue'

export default {
  components: {
    FishCard
  }
}
</script>

<style lang="sass">
@import '../../style/palette.sass'

.center
  text-align: center

.wrapper
  display: inline-block
  margin-top: 10px

.cardContainer
  display: flex
  flex-direction: row
  flex-wrap: wrap
  padding-left: 6.2vw
  // die padding kan echt niet hoor maar idk hoe ik dit even doe x,D
</style>
