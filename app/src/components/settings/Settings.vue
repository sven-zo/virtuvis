<template>
  <transition appear name="page">
    <div class="settings">
        <div class="upperBar">
          <p>
            Instellingen:
          </p>
        </div>
    </div>
  </transition>
</template>

<style lang="sass" scoped>
@import '../../style/palette.sass'
@import url('https://fonts.googleapis.com/css?family=Roboto')

.upperBar
  background-color: $primary-color-dark
  //height: 5vw
  height: 30px
  width: 100%

.upperBar p
  color: white
  margin-left: 15px
  margin-top: 0px
  padding-top: 4px
  font-family: 'Roboto', sans-serif
  //font-size: 3vw
  font-size: 18px

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif
p
  color: black
  font-family: 'Roboto', sans-serif
</style>
