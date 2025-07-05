### What is **Angular**?


**Angular** is a **front-end web development framework** developed by **Google**. It's used to build **single-page applications (SPAs)** with rich, dynamic user interfaces. Angular is built on **TypeScript**, which is a superset of JavaScript that adds static types.

### Key Features of Angular:
- **Component-based architecture**: Organize the UI into reusable components.
- **Two-way data binding**: Automatically synchronize data between the model and the view.
- **Dependency injection**: Make it easier to manage and inject dependencies into components and services.
- **Routing**: Built-in routing system to navigate between different views or pages in your app.
- **Directives**: Extend HTML with custom tags and attributes.
- **RxJS**: Reactive programming for handling asynchronous operations like HTTP requests.

Here is a basic **file structure** for an Angular project:

### Angular Project File Structure

```
my-angular-app/               # Root folder of your Angular project
│
├── e2e/                       # End-to-end tests
│   ├── src/                   # Source code for e2e tests
│   └── protractor.conf.js     # Configuration file for end-to-end testing
│
├── node_modules/              # Node.js modules and dependencies
│
├── src/                       # Source code of the Angular application
│   ├── app/                   # All the app components, services, and modules
│   │   ├── app.component.ts   # Main app component file (TypeScript)
│   │   ├── app.component.html # Main HTML file for the app component
│   │   ├── app.component.css  # Styles specific to the app component
│   │   ├── todo/              # A sub-folder for a feature or component (e.g., Todo)
│   │   │   ├── todo.component.ts
│   │   │   ├── todo.component.html
│   │   │   ├── todo.component.css
│   │   └── ...                # Other components, services, and modules
│   │
│   ├── assets/                # Static assets like images, fonts, etc.
│   ├── environments/          # Configuration for different environments (dev, prod)
│   │   ├── environment.ts     # Development environment settings
│   │   └── environment.prod.ts# Production environment settings
│   │
│   ├── index.html             # The main HTML file (entry point for the app)
│   ├── main.ts                # The main entry file for bootstrapping the app
│   ├── styles.css             # Global styles for the app
│   ├── polyfills.ts           # Polyfills for backward compatibility
│   └── test.ts                # Main testing entry point
│
├── angular.json               # Angular project configuration file
├── package.json               # Node.js package manager configuration (dependencies)
├── package-lock.json          # Lock file for package versions
├── tsconfig.json              # TypeScript configuration file
├── tsconfig.app.json          # TypeScript config for app-specific settings
└── .gitignore                 # Git ignore file (to exclude files/folders from Git)
```

### Key Files and Folders:

- **`e2e/`**: Contains end-to-end test configuration and code.
- **`node_modules/`**: Holds all the installed dependencies (managed by npm).
- **`src/`**: Main source code folder.
  - **`app/`**: Contains all the Angular components, services, modules, etc.
  - **`assets/`**: Static assets (images, fonts, etc.).
  - **`environments/`**: Contains environment-specific configuration.
  - **`index.html`**: The HTML file where Angular will render the app.
  - **`styles.css`**: Global styles that apply across the app.
  - **`main.ts`**: The TypeScript file where Angular bootstraps the app.
  - **`polyfills.ts`**: Used to ensure your app runs on older browsers.
- **`angular.json`**: Angular project configuration (e.g., build and serve settings).
- **`package.json`**: Contains the list of project dependencies and scripts.
- **`tsconfig.json`**: TypeScript configuration file.

### Summary:
This is the default structure of an Angular project. It contains the source code, configuration files, and assets needed to build and run the Angular app. As your project grows, this structure may evolve to include more modules, services, or other features specific to your application.

### Installation of **Angular**:

1. **Prerequisites**:
   - Install **Node.js** (which includes **npm** - Node Package Manager).
     - Download from [Node.js official website](https://nodejs.org/).
     - After installing, check the version using the command:
       ```bash
       node -v
       ```
     - You should also have **npm** installed (which comes with Node.js):
       ```bash
       npm -v
       ```

2. **Install Angular CLI**:
   The **Angular CLI** (Command Line Interface) is a tool that helps you create and manage Angular projects.
   - Open the terminal or command prompt.
   - Run the following command to install Angular CLI globally:
     ```bash
     npm install -g @angular/cli
     ```

3. **Create a New Angular Project**:
   - After the installation, you can create a new Angular project by running:
     ```bash
     ng new my-angular-app
     ```
     - You will be prompted to choose whether to include Angular routing and which style sheet format (CSS, SCSS, etc.) you prefer.

4. **Navigate to Your Project Folder**:
   After creating the project, move to your project directory:
   ```bash
   cd my-angular-app
   ```

5. **Run the Development Server**:
   To see the application in action, run the following command:
   ```bash
   ng serve
   ```
   - By default, it will run on `http://localhost:4200`. You can open this in your browser.

### A Simple **Angular Mini Project**:

Let’s create a simple **To-Do List** application.

1. **Create a New Component** for the To-Do List:
   Run this command to generate a new component called `todo`:
   ```bash
   ng generate component todo
   ```

2. **Update the `todo.component.ts`**:
   Open the file `src/app/todo/todo.component.ts` and update it to manage the to-do list:
   ```typescript
   import { Component } from '@angular/core';

   @Component({
     selector: 'app-todo',
     templateUrl: './todo.component.html',
     styleUrls: ['./todo.component.css']
   })
   export class TodoComponent {
     todoList: string[] = [];
     newTodo: string = '';

     addTodo() {
       if (this.newTodo) {
         this.todoList.push(this.newTodo);
         this.newTodo = ''; // Clear the input field
       }
     }

     removeTodo(index: number) {
       this.todoList.splice(index, 1); // Remove the item from the list
     }
   }
   ```

3. **Update the `todo.component.html`**:
   Open the file `src/app/todo/todo.component.html` and create the UI for the To-Do List:
   ```html
   <div class="todo-container">
     <h2>My To-Do List</h2>
     <input [(ngModel)]="newTodo" placeholder="Add a new task" />
     <button (click)="addTodo()">Add</button>

     <ul>
       <li *ngFor="let todo of todoList; let i = index">
         {{ todo }} 
         <button (click)="removeTodo(i)">Delete</button>
       </li>
     </ul>
   </div>
   ```

4. **Update the `app.component.html`**:
   Now, open `src/app/app.component.html` and add the `<app-todo></app-todo>` tag to display the To-Do component:
   ```html
   <app-todo></app-todo>
   ```

5. **Add FormsModule for Two-Way Binding**:
   Since we are using two-way data binding (`[(ngModel)]`), we need to import `FormsModule` in `app.module.ts`. Open `src/app/app.module.ts` and update it:
   ```typescript
   import { NgModule } from '@angular/core';
   import { BrowserModule } from '@angular/platform-browser';
   import { FormsModule } from '@angular/forms'; // Add this line
   import { AppComponent } from './app.component';
   import { TodoComponent } from './todo/todo.component';

   @NgModule({
     declarations: [
       AppComponent,
       TodoComponent
     ],
     imports: [
       BrowserModule,
       FormsModule // Add this line
     ],
     providers: [],
     bootstrap: [AppComponent]
   })
   export class AppModule { }
   ```

6. **Run Your Application**:
   Once everything is set up, run the app with:
   ```bash
   ng serve
   ```
   - Visit `http://localhost:4200` in your browser, and you'll see the To-Do List application.

### Summary:

- **Angular** is a powerful front-end framework for building dynamic web applications.
- To get started, install **Node.js**, **Angular CLI**, and create a project using `ng new`.
- We built a simple **To-Do List** app using Angular, where users can add and remove tasks.
