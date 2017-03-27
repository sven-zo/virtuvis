import * as reqwest from 'Reqwest'
import {getVirtuVisAPIUrl} from '../../secret/API-url.js'

export function getData (source) {
  switch (source) {
    case 'recent': {
      return new Promise(function (resolve, reject) {
        reqwest({
          url: getVirtuVisAPIUrl(),
          contentType: 'application/json',
          crossOrigin: true
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
    default: {
      console.log('[getData] Please specify a source!')
      break
    }
  }
}
