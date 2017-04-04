<template lang="pug">
.sortbarwrapper
  transition(appear, name='page')
    .sortbar
      .text {{sortText}}
      .button
        a(href='#', @click='setSort("nameA")')
          img(src='../../assets/abc.svg', onerror="this.src='./assets/edit.png'")
      .button
        a(href='#', @click='setSort("name")')
          img(src='../../assets/abc-reverse.svg', onerror="this.src='./assets/edit.png'")
            //-TODO: Pijltje omhoog en omlaag klok UI
      .button
        a(href='#', @click='setSort("recentA")')
          img(src='../../assets/clock.png')
      .button
        a(href='#', @click='setSort("recent")')
          img(src='../../assets/clock-old.png')
      .button
        a(href='#', @click='setSort("speciesA")')
          p S:AZ
      .button
        a(href='#', @click='setSort("species")')
          p S:ZA
      .button
        a(href='#', @click='setSort("favorite")')
          img(src='../../assets/star.png')
</template>

<script>
export default {
  props: ['language'],
  methods: {
    setSort (sort) {
      console.log('[HomeSortbar] Setting sort: ', sort)
      this.$emit('setSort', sort)
    }
  },
  computed: {
    sortText () {
      if (this.language === 'nl') {
        return 'Sorteer:'
      } else {
        return 'Sort:'
      }
    }
  }
}
</script>

<style lang="sass" scoped>
@import '../../style/_palette.sass'
@import '../../style/pageanimations.sass'

.sortbar
  background-color: $divider-color
  height: 50px
  width: 100%
  display: flex

.button
  padding-left: 10px
  padding-top: 10px

.button img
  max-height: 30px

.text
  font-family: 'Roboto', sans-serif
  padding-left: 10px
  padding-top: 15px
</style>
