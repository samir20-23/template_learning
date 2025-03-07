'use strict'

/** @type {typeof import('@adonisjs/lucid/src/Lucid/Model')} */
 
const Model = use('Model')

class User extends Model {
  static get fillable () {
    return ['name', 'email']
  }
}
 
module.exports = User
