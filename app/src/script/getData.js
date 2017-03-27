import * as reqwest from 'Reqwest'
import Fingerprint2 from 'fingerprintjs2'

import {getVirtuVisAPIUrl} from '../../secret/API-url.js'

var fingerprint

export function getData (source) {
  switch (source) {
    case 'recent': {
      return new Promise(function (resolve, reject) {
        getData('fingerprint').then(function (response) {
          fingerprint = response
        }).then(function () {
          reqwest({
            url: getVirtuVisAPIUrl(),
            contentType: 'application/json',
            crossOrigin: true,
            data: {action: 'LIST', user: fingerprint}
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
