var request = new XMLHttpRequest()

export function getUserFish () {
  request.addEventListener('load', loadFish)
  request.open('GET', 'http://localhost/dummy-server/dummy_userfish.php')
  request.send()
}

function loadFish () {
  var response = request.responseText
  response = JSON.parse(response)
  console.log(response)
  return response
}

export function getUserFish () {
  return new Promise(function(resolve, reject) {
    request.open('GET', 'http://localhost/dummy-server/dummy_userfish.php')
  })
}
