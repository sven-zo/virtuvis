<template lang="pug">
.center
  .wrapper
    .cardContainer(v-for='card in cards')
        fish-card(:name='card.text')
</template>

<script>
import FishCard from '@/components/fish/FishCard.vue'

export default {
  data: function () {
    return {
      cards: [
        { text: 'Dolfijn' },
        { text: 'Zalm' },
        { text: 'Appel' }
      ]
    }
  },
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
