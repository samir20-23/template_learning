'use strict'

class UserController {
  constructor ({ socket, request }) {
    this.socket = socket
    this.request = request
  }
}

module.exports = UserController
