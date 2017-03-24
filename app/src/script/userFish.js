import {getVirtuVisAPIUrl} from '../../secret/API-url.js'

var request = new XMLHttpRequest()
var response

/**
 * Controleert of een variabele undefined is.
 * @param  {variabel}  value Variabele om te controleren.
 * @return {Boolean}       Waar als de variabele undefined is.
 */
// function isUndefined (value) {
//   return typeof value === 'undefined'
// }

/**
 * Haalt de vissen van de ingevulde gebruiker op.
 * @return {Promise} Bevat de vissen van de gebruiker bij succes.
 */
export function getUserFish () {
  return new Promise(function (resolve, reject) {
    // request.open('GET', 'http://localhost/dummy-server/dummy_userfish.php')
    request.open('GET', getVirtuVisAPIUrl())

    request.onload = function () {
      if (request.status === 200) {
        response = request.responseText
        // console.log('Raw response:', request.responseText)
        response = JSON.parse(response)
        console.log(response)
        // if (isUndefined(response)) {
        //   resolve(false)
        // }
        resolve(response)
      } else {
        reject(Error(request.statusText))
      }
    }

    request.onerror = function () {
      reject(Error('Network Error'))
    }

    request.send()
  })
}
