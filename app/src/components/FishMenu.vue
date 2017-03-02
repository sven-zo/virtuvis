<template>
  <div class="menu">
      <div @click="rodClick" class="button" id="rod">
        <div>
          <img :class="rodClass" src="../assets/rod.png"/>
        </div>
        <div>Voeg hengel toe</div>
      </div>
      <div :class="middleButtonState">
        <p class="homeText">
          Home
        </p>
      </div>
      <div @click="cogClick" class="button" id="cog">
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
      cogClass: 'cog',
      rodClass: 'rod',
      middleButtonUp: false,
      middleButtonState: 'middleButtonDown'
    }
  },
  methods: {
    cogClick (event) {
      if (event) {
        this.cogClass = 'cogTurn'
        this.$router.push('/settings')
        setTimeout(this.cogReset, 1000)
        this.middleButtonUp = true
        this.checkMiddleButton()
      }
    },
    cogReset () {
      this.cogClass = 'cog'
    },
    rodClick (event) {
      if (event) {
        this.rodClass = 'rodAnimation'
        this.$router.push('/addrod')
        setTimeout(this.rodReset, 1000)
        this.middleButtonUp = true
        this.checkMiddleButton()
      }
    },
    rodReset () {
      this.rodClass = 'rod'
    },
    checkMiddleButton () {
      if (this.middleButtonUp) {
        this.middleButtonState = 'middleButtonUp'
      } else {
        this.middleButtonState = 'middleButtonDown'
      }
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

// Middle button

@keyframes up
  from
    transform: translate(0px, 0px)
  to
    transform: translate(0px, -25px)

.middleButtonDown
  height: 110px
  width: 110px
  border-radius: 50%
  background-color: $primary-color-dark
  animation-name: up
  animation-direction: reverse
  animation-duration: 1s
  color: $primary-color-dark

.middleButtonUp
  height: 110px
  width: 110px
  border-radius: 50%
  background-color: $primary-color-dark
  animation-name: up
  animation-duration: 1s
  transform: translate(0px, -25px)

.homeText
  padding-top: 67px
  padding-left: 31px
  color: $primary-text-color
  transform: translate(0px, 25px)

// Cog and fishing rod

@keyframes turnclick
  0%
    transform: rotate(0deg)
  25%
    transform: rotate(-50deg)
  100%
    transform: rotate(180deg)

@keyframes rodAnimation
  0%
    transform: rotate(0deg)
  25%
    transform: rotate(45deg)
  50%
    transform: rotate(-45deg)
  100%
    transform: rotate(0deg)

@keyframes press
  0%
    background-color: $divider-color
  10%
    background-color: $primary-color-light
  100%
    background-color: $divider-color

#cog:hover
  animation-name: press
  animation-duration: 0.5s

.cogTurn
  animation-name: turnclick
  animation-duration: 1s
  animation-iteration-count: 1

#rod:hover
  animation-name: press
  animation-duration: 0.5s

.rodAnimation
  animation-name: rodAnimation
  animation-duration: 1s

</style>
