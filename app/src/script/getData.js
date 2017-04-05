import * as reqwest from 'Reqwest'
import Fingerprint2 from 'fingerprintjs2'

import {getVirtuVisAPIUrl} from '../../secret/API-url.js'

var fingerprint
var debugMode = false

export function getData (source) {
  switch (source) {
    case 'recentA': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
          if (debugMode) {
            fingerprint = getVirtuVisAPIUrl('debugFingerprint')
          }
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint, sortby: 'recentA'}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'recent': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
          if (debugMode) {
            fingerprint = getVirtuVisAPIUrl('debugFingerprint')
          }
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint, sortby: 'recent'}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'species': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
          if (debugMode) {
            fingerprint = getVirtuVisAPIUrl('debugFingerprint')
          }
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint, sortby: 'species'}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'name': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
          if (debugMode) {
            fingerprint = getVirtuVisAPIUrl('debugFingerprint')
          }
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint, sortby: 'name'}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'nameA': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
          if (debugMode) {
            fingerprint = getVirtuVisAPIUrl('debugFingerprint')
          }
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint, sortby: 'nameA'}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'favorite': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
          if (debugMode) {
            fingerprint = getVirtuVisAPIUrl('debugFingerprint')
          }
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint, sortby: 'favorite'}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'speciesA': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
          if (debugMode) {
            fingerprint = getVirtuVisAPIUrl('debugFingerprint')
          }
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('fish'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint, sortby: 'speciesA'}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'user': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl('user'),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'GET', user: fingerprint}
          })
            .then(function (resp) {
              // Do something with the reponse
              resolve(resp)
            })
            .fail(function (err, msg) {
              // Do something with the error message
              reject(Error(err + ' Message: ' + msg))
            })
            .always(function (resp) {
              // Always do this.
              // I'm not sure what this is for yet.
              // Time for research!
            })
        })
      })
    }
    case 'rod': {
      return new Promise(function (resolve, reject) {
        reqwest({
          url: getVirtuVisAPIUrl('rod'),
          contentType: 'application/json',
          crossOrigin: true,
          data: {action: 'LIST'}
        })
          .then(function (resp) {
            // Do something with the reponse
            resolve(resp)
          })
          .fail(function (err, msg) {
            // Do something with the error message
            reject(Error(err + ' Message: ' + msg))
          })
          .always(function (resp) {
            // Always do this.
            // I'm not sure what this is for yet.
            // Time for research!
          })
      })
    }
    case 'fingerprint': {
      return new Promise(function (resolve, reject) {
        var fingerprint = new Fingerprint2()
        fingerprint.get(function (result, components) {
          resolve(result)
        })
      })
    }
    default: {
      console.log('[getData] Please specify a source!')
      break
    }
  }
}

// export function getData(source) {
//   if( source ) {
//     if( source === 'recent' ) {
//       return new Promise(function (resolve, reject) {
//         reqwest({
//           url: getVirtuVisAPIUrl(),
//           contentType: 'application/json',
//           crossOrigin: true
//         })
//           .then(function (resp) {
//             // Do something with the reponse
//             resolve(resp)
//           })
//           .fail(function (err, msg) {
//             // Do something with the error message
//             reject(Error(err + ' Message: ' + msg))
//           })
//           .always(function (resp) {
//             // Always do this.
//             // I'm not sure what this is for yet.
//             // Time for research!
//           })
//         }
//     } else if ( source === 'fingerprint' ) {
//
//     }
//   } else {
//     console.log('[getData] Please specify a source!')
//   }
// }
