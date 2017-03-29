<template>
<!-- GetSettings bound -->
</template>

<script>
import {getUserSettings} from '../../script/userSettings.js'

export default {
  created() {
    console.log('(GetSettings) Bound')
    console.log('(GetSettings) Getting user settings')
    var self = this
    getUserSettings().then(function (response) {
      console.log('(GetSettings) Succes!')
      console.log('(GetSettings) Emitting response to parent object')
    }, function (error) {
      console.log('(GetSettings) Error!')
      console.log('(GetSettings) Emitting failure :( to parent object')
  }
}
</script>
