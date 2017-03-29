var request = new XMLHttpRequest()
var response

/**
 * Haalt de instellingen van de gebruiker op.
 * @return {Promise} Bevat de instellingen van de gebruiker bij succes.
 */
export function getUserSettings () {
  return new Promise(function (resolve, reject) {
    request.open('GET', 'http://localhost/dummy-server/dummy_user.php')

    request.onload = function () {
      if (request.status === 200) {
        response = request.responseText
        response = JSON.parse(response)
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
