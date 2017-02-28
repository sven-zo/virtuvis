<template>
  <div class="menu">
      <div class="button" id="rod">
        <div>
          <img src="../assets/rod.png"/>
        </div>
        <div>Voeg hengel toe</div>
      </div>
      <div class="middleButton">
        <p class="homeText">
          Home
        </p>
      </div>
      <div @click="cogClick" @hover="cogClass='cogHover'" class="button" id="cog">
        <div>
          <img :class="cogClass" src="../assets/settings.png"/>
        </div>
        <div>Instellingen en meer</div>
      </div>
  </div>
</template>

<script>

export default {
  data () {
    return {
      cogClass: 'cogHover'
    }
  },
  methods: {
    cogClick (event) {
      if (event) {
        this.cogClass = 'cogTurn'
        setTimeout(this.cogHover, 1000)
      }
    },
    cogHover () {
      this.cogClass = 'cogHover'
    }
  }
}
</script>

<style lang="sass" scoped>
@import '../style/palette.sass'

.menu
  font-family: 'Roboto', sans-serif
  color: $primary-text-color
  height: 110px
  background-color: $divider-color
  display: flex
  flex-direction: row
  justify-content: space-around
  position: fixed
  width: 100%
  bottom: 0

// .button img
//   padding-left: 20px
//   padding-top: 10px
//   max-height: 70px

.button
  display: flex
  flex-direction: column
  justify-content: center

.button div
  display: flex
  flex-direction: row
  justify-content: center

.button img
  //padding-left: 20px
  max-height: 70px
  max-width: 70px
  padding-bottom: 0px

.middleButton
  height: 110px
  width: 110px
  border-radius: 50%
  background-color: $primary-color-dark

.homeText
  padding-top: 67px
  padding-left: 31px
  display: none

@keyframes turn
  from
    transform: rotate(0deg)
  to
    transform: rotate(45deg)

@keyframes turnclick
  0%
    transform: rotate(0deg)
  25%
    transform: rotate(-50deg)
  100%
    transform: rotate(180deg)

// #cog img:hover
//   animation-name: turn
//   animation-duration: 1s
//   animation-iteration-count: 1

.cogHover
  animation-name: turn
  animation-duration: 0.2s
  animation-iteration-count: 1

.cogTurn
  animation-name: turnclick
  animation-duration: 1s
  animation-iteration-count: 1

</style>
