<template>
  <transition appear name="page">
    <div class="home">
        <div class="upperBar">
          <p>
            Net gevangen:
          </p>
        </div>
        <div class="recent">

        </div>
        <div class="sortbar">

        </div>
    </div>
  </transition>
</template>

<script>
export default {
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="sass" scoped>
@import '../style/palette.sass'

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

.recent
  background-color: $primary-color
  //height: 26vw
  height: 200px
  width: 100%

.sortbar
  background-color: $divider-color
  height: 10vw
  width: 100%

h1
  color: $primary-color
  font-family: 'Roboto', sans-serif
p
  color: black
  font-family: 'Roboto', sans-serif

// Page animations
.page-enter-active
  transition: opacity .2s

.page-enter
  opacity: 0
</style>
