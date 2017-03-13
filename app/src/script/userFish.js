var request = new XMLHttpRequest()
var response

function isUndefined (value) {
  return typeof value === 'undefined'
}

export function getUserFish () {
  return new Promise(function (resolve, reject) {
    request.open('GET', 'http://localhost/dummy-server/dummy_userfish.php')

    request.onload = function () {
      if (request.status === 200) {
        response = request.responseText
        // console.log('Raw response:', request.responseText)
        response = JSON.parse(response)
        if (isUndefined(response)) {
          resolve(false)
        }
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
