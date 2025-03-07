'use strict'

/** @type {import('@adonisjs/framework/src/Server')} */
const Server = use('Server')

const namedMiddleware = {
  auth: 'Adonis/Middleware/Auth',
  guest: 'Adonis/Middleware/AllowGuestOnly',
  csrf: 'Adonis/Middleware/Csrf',
}

const globalMiddleware = [
  'Adonis/Middleware/BodyParser',
  'Adonis/Middleware/Session', // This line ensures the session middleware is loaded
  'Adonis/Middleware/Shield',
  'App/Middleware/ConvertEmptyStringsToNull',
]


Route.group(() => {
  Route.get('/create', 'UserController.createForm')
  Route.post('/add', 'UserController.add')
  Route.delete('/delete/:id', 'UserController.delete')
}).middleware(['csrf'])  // Add CSRF here to specific routes that need it

// For API routes, disable CSRF:
Route.group(() => {
  Route.post('/some-api-route', 'ApiController.someMethod')
}).middleware([])  // No CSRF for API routes

const serverMiddleware = [
  'Adonis/Middleware/Static',
  'Adonis/Middleware/Cors',
]

Server
  .registerGlobal(globalMiddleware)
  .registerNamed(namedMiddleware)
  .use(serverMiddleware)
