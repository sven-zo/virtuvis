<template>
  <div class="menu">
    <transition appear name="fade">
      <div @click="rodClick" class="button" id="rod">
        <div>
          <img :class="rodClass" src="../assets/rod.png"/>
        </div>
        <div>Voeg hengel toe</div>
      </div>
    </transition>
    <transition appear name="fade">
        <div @click="middleButtonClick" :class="middleButtonClass" id="middleButton">
          <p class="homeText">
            Home
          </p>
        </div>
    </transition>
    <transition appear name="fade">
        <div @click="cogClick" class="button" id="cog">
          <div>
            <img :class="cogClass" src="../assets/settings.png"/>
          </div>
          <div>Instellingen</div>
        </div>
    </transition>
  </div>
</template>

<script>

export default {
  data () {
    return {
      cogClass: 'cog',
      rodClass: 'rod',
      middleButtonClass: 'middleButtonDown'
    }
  },
  methods: {
    cogClick (event) {
      if (event) {
        this.cogClass = 'cogTurn'
        this.$router.push('/settings')
        setTimeout(this.cogReset, 1000)
        this.middleButtonClass = 'middleButtonUp'
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
        this.middleButtonClass = 'middleButtonUp'
      }
    },
    rodReset () {
      this.rodClass = 'rod'
    },
    middleButtonClick (event) {
      if (event) {
        this.$router.push('/')
        this.middleButtonClass = 'middleButtonDown'
      }
    }
  }
}
</script>

<style lang="sass" scoped>
@import '../style/palette.sass'

.menu
  font-family: 'Roboto', sans-serif
  font-size: 12px
  color: $primary-text-color
  height: 70px
  background-color: $divider-color
  display: flex
  flex-direction: row
  justify-content: space-around
  position: fixed
  width: 100%
  bottom: 0

.button
  width: 33%
  display: flex
  flex-direction: column
  justify-content: center

.button div
  display: flex
  flex-direction: row
  justify-content: center

.button img
  //padding-left: 20px
  max-height: 50px
  max-width: 50px
  padding-bottom: 0px

// Middle button

@keyframes up
  from
    transform: translate(0px, 0px)
  to
    transform: translate(0px, -20px)

@keyframes down
  from
    transform: translate(0px, -20px)
  to
    transform: translate(0px, 0px)

.middleButtonDown
  animation-name: down
  animation-duration: 0.5s

.middleButtonUp
  animation-name: up
  animation-duration: 0.5s
  transform: translate(0px, -20px)

#middleButton
  background-image: url('../assets/book.png')
  background-size: 50px, 50px
  background-repeat: no-repeat
  background-position: 50% 40%
  height: 70px
  width: 70px
  border-radius: 50%
  background-color: $primary-color-dark
  color: $primary-color-dark

.homeText
  padding-top: 58%
  padding-left: 25%
  color: $primary-text-color
  transform: translate(0px, 20px)

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
  animation-timing-function: ease-in-out

// Fade animations for app loadingMSG
.fade-enter-active
  transition: opacity .5s

.fade-enter
  opacity: 0

</style>
