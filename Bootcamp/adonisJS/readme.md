## installation & use 

```pash 
npm install -g @adonisjs/cli 
adonis new crud-app 
cd crud-app 
npm install 
adonis serve --dev 
npm install mysql2 --save 
nano .env   

# Run migrations
node ace migration:run  

# Start the server with file watching
adonis serve --dev

``` 

### **1. Migration Commands**
- **Run Migrations**:
  ```bash
  adonis migration:run
  ```
  This runs all pending migrations to update your database schema.

- **Rollback Migrations**:
  ```bash
  adonis migration:rollback
  ```
  This rolls back the last batch of migrations.

- **Create a New Migration**:
  ```bash
  adonis make:migration migration_name
  ```
  Creates a new migration file.

- **Reset Migrations**:
  ```bash
  adonis migration:reset
  ```
  Rolls back all migrations and resets the database schema.

### **2. Seeders**
- **Run Seeders**:
  ```bash
  adonis db:seed
  ```
  This runs all seeders to populate your database with initial data.

- **Create a Seeder**:
  ```bash
  adonis make:seeder SeederName
  ```
  Creates a new seeder file.

### **3. Models & Controllers**
- **Create a New Model**:
  ```bash
  adonis make:model ModelName
  ```
  This creates a new model. You can also add `-m` to create a migration with it:
  ```bash
  adonis make:model ModelName -m
  ```

- **Create a New Controller**:
  ```bash
  adonis make:controller ControllerName
  ```
  This creates a new controller. Use `--type=resource` for a resourceful controller (with `index`, `show`, `store`, `update`, and `destroy` methods):
  ```bash
  adonis make:controller ControllerName --type=resource
  ```

- **Create a New Middleware**:
  ```bash
  adonis make:middleware MiddlewareName
  ```
  This creates a new middleware file.

### **4. Running the Development Server**
- **Start the Development Server**:
  ```bash
  adonis serve --dev
  ```
  This starts the AdonisJS server with live-reloading in development mode.

### **5. Other Useful Commands**
- **Create a New Job**:
  ```bash
  adonis make:job JobName
  ```

- **Create a New Command**:
  ```bash
  adonis make:command CommandName
  ```

- **Create a New Event**:
  ```bash
  adonis make:event EventName
  ```

- **Create a New Listener**:
  ```bash
  adonis make:listener ListenerName
  ```

### **6. Environment and Cache Management**
- **Clear Cache**:
  ```bash
  adonis cache:clear
  ```
  Clears any application cache.

- **View Environment Variables**:
  ```bash
  adonis env
  ``` 
**AdonisJS** is a **Node.js** web framework that is designed to be simple, robust, and feature-rich. It provides an MVC (Model-View-Controller) architecture, making it ideal for building applications with full-stack capabilities, such as API development, web apps, and more.

### **Key Features of AdonisJS**:
- **MVC structure**: Helps you separate logic cleanly.
- **Built-in Authentication**: For creating secure applications.
- **Database ORM (Lucid)**: Simplifies working with databases.
- **Routing**: Handles routes efficiently.
- **Session management**: Manages sessions out of the box.

### **How to Install and Use AdonisJS**

#### **1. Prerequisites**
Make sure you have **Node.js** installed. You can verify it by running:
```bash
node -v
npm -v
```

If Node.js isn't installed, download and install it from:  
[https://nodejs.org](https://nodejs.org)

#### **2. Install AdonisJS CLI**
You can install the AdonisJS CLI globally using **npm**:
```bash
npm install -g @adonisjs/cli
```

#### **3. Create a New AdonisJS Project**
Once the CLI is installed, create a new project by running:
```bash
adonis new project-name
```
This command will prompt you to choose a project template (select the default one). It will create a directory with your project files.

#### **4. Navigate to Your Project Folder**
```bash
cd project-name
```

#### **5. Install Dependencies**
Run the following command to install the required dependencies:
```bash
npm install
```

#### **6. Run the Development Server**
To start the AdonisJS server, use:
```bash
adonis serve --dev
```
This will start the application and make it available at `http://127.0.0.1:3333`.

#### **7. Access the Project**
Open your browser and visit `http://127.0.0.1:3333` to see the default AdonisJS welcome page.

#### **8. Basic Routes and Controllers**
You can define routes in `start/routes.js`. Here’s an example of adding a new route:

```js
// start/routes.js
const Route = use('Route')

Route.get('/', () => {
  return 'Hello, world!'
})
```

Then, restart the server and go to `http://127.0.0.1:3333/` to see the updated output.

#### **9. Creating a Controller**
AdonisJS uses controllers to handle requests. You can create one using the CLI:
```bash
adonis make:controller UserController
```

This will create a file under `app/Controllers/Http/UserController.js`. You can add methods inside the controller and route them.

#### **10. Using the ORM (Lucid)**
AdonisJS comes with a powerful ORM (Lucid) for database interactions. Here's an example of creating a model:

```bash
adonis make:model User -m
```

This will create a `User` model and a migration file for the database. You can then define the model in `app/Models/User.js`.

### **Conclusion**
AdonisJS is a full-featured framework, similar to Laravel in the PHP ecosystem, that makes building web applications easier and more structured. You can start using it for developing modern web applications, REST APIs, and more.
 
 ## mini projectt crud  


## **1. Install AdonisJS**
First, install the AdonisJS CLI if you haven’t already:
```bash
npm install -g @adonisjs/cli
```

Now, create a new AdonisJS project:
```bash
adonis new crud-app
cd crud-app
npm install
```

---

## **2. Set Up the Database**
AdonisJS uses **Lucid ORM** for database operations. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_USER=root
DB_PASSWORD=your_password
DB_DATABASE=crud_db
```
Run migrations to create the default tables:
```bash
adonis migration:run
```

---

## **3. Create a Model, Migration, and Controller**
Run the following command to generate a `User` model, migration file, and controller:
```bash
adonis make:model User -m
adonis make:controller UserController --type=resource
```

Now, open `database/migrations/TIMESTAMP_users_schema.js` and modify it:
```js
this.create('users', (table) => {
  table.increments()
  table.string('name', 255).notNullable()
  table.string('email', 255).unique().notNullable()
  table.timestamps()
})
```
Run the migration:
```bash
adonis migration:run
```

---

## **4. Define Routes**
Edit `start/routes.js` to set up CRUD routes:
```js
const Route = use('Route')
const UserController = use('App/Controllers/Http/UserController')

Route.get('/users', 'UserController.index')  // List all users
Route.post('/users', 'UserController.store') // Create new user
Route.get('/users/:id', 'UserController.show') // Get single user
Route.put('/users/:id', 'UserController.update') // Update user
Route.delete('/users/:id', 'UserController.destroy') // Delete user
```

---

## **5. Implement Controller Logic**
Edit `app/Controllers/Http/UserController.js`:
```js
const User = use('App/Models/User')

class UserController {
  async index({ response }) {
    const users = await User.all()
    return response.json(users)
  }

  async store({ request, response }) {
    const data = request.only(['name', 'email'])
    const user = await User.create(data)
    return response.status(201).json(user)
  }

  async show({ params, response }) {
    const user = await User.find(params.id)
    if (!user) {
      return response.status(404).json({ message: 'User not found' })
    }
    return response.json(user)
  }

  async update({ params, request, response }) {
    const user = await User.find(params.id)
    if (!user) {
      return response.status(404).json({ message: 'User not found' })
    }

    const data = request.only(['name', 'email'])
    user.merge(data)
    await user.save()
    return response.json(user)
  }

  async destroy({ params, response }) {
    const user = await User.find(params.id)
    if (!user) {
      return response.status(404).json({ message: 'User not found' })
    }
    await user.delete()
    return response.status(204).json(null)
  }
}

module.exports = UserController
```

---

## **6. Start the Server**
Run the AdonisJS server:
```bash
adonis serve --dev
```
Your API will be available at `http://127.0.0.1:3333/users`.

---

## **7. Test API with Postman or cURL**
### **Create a User (POST)**
```bash
curl -X POST http://127.0.0.1:3333/users -H "Content-Type: application/json" -d '{"name": "John", "email": "john@example.com"}'
```

### **Get All Users (GET)**
```bash
curl http://127.0.0.1:3333/users
```

### **Get a Single User (GET)**
```bash
curl http://127.0.0.1:3333/users/1
```

### **Update a User (PUT)**
```bash
curl -X PUT http://127.0.0.1:3333/users/1 -H "Content-Type: application/json" -d '{"name": "John Updated", "email": "john_updated@example.com"}'
```

### **Delete a User (DELETE)**
```bash
curl -X DELETE http://127.0.0.1:3333/users/1
```

---
 