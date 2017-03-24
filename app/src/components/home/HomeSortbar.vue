<template lang="pug">
.sortbarwrapper
  transition(appear, name='page')
    .sortbar
</template>

<style lang="sass" scoped>
@import '../../style/_palette.sass'
@import '../../style/pageanimations.sass'

.sortbar
  background-color: $divider-color
  height: 50px
  width: 100%
</style>
