'use strict'

const User = use('App/Models/User')
const Session = use('Session') // Injecting Session

class UserController {
  // Show the create form and pass CSRF token
  async createForm({ view }) {
    const csrfToken = Session.get('csrf_token') // Retrieve the CSRF token from the session
    return view.render('create', { csrfToken })
  }

  // Show Users in the Table
  async index({ view }) {
    const users = await User.all()
    return view.render('users', { users: users.toJSON() })
  }

  // Add a New User
  async add({ request, response }) {
    const { name, email } = request.only(['name', 'email'])
    await User.create({ name, email })
    return response.redirect('/users')
  }

  // Delete a User
  async delete({ params, response }) {
    const user = await User.find(params.id)
    if (user) {
      await user.delete()
    }
    return response.redirect('/users')
  }

  // Store action, where we check CSRF token manually
  async store({ request, response }) {
    const csrfToken = request.input('_csrf')

    // Manually check CSRF token validity
    if (!csrfToken || csrfToken !== Session.get('csrf_token')) {
      return response.status(403).send('Invalid CSRF Token')
    }

    // Handle the form submission logic here
    // Example: const { name, email } = request.only(['name', 'email'])
    // await User.create({ name, email })
    return response.redirect('/users')
  }
}

module.exports = UserController
