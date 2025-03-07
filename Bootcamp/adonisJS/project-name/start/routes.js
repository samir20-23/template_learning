'use strict'

 

/** @type {typeof import('@adonisjs/framework/src/Route/Manager')} */
const Route = use('Route')
const UserController = use('App/Controllers/Http/UserController') 
Route.on('/').render('welcome') 
 
 

// Show all users
Route.get('/users', 'UserController.index')

// Add a new user
Route.post('/users', 'UserController.add')

// Delete a user
Route.delete('/users/:id', 'UserController.delete')
