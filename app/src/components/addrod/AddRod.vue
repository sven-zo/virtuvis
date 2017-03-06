<template>
  <transition appear name="page">
    <div class="settings">
      <div class="upperBar">
        <p>
          Vishengel toevoegen:
        </p>
      </div>
      <div class="bottomBar">
        <p>
          Leg je dobber op het scherm.
        </p>
      </div>
    </div>
  </transition>
</template>

<style lang="sass" scoped>
@import '../../style/palette.sass'

.bottomBar
  background-color: red
  width: 100%
  height: 90vh

.bottomBar p
  color: white
  font-size: 24px
  font-family: 'Roboto', sans-serif
  text-align: center
  padding-top: 10px
  margin-top: 0px

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
