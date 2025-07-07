so my projec t like his :
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React> dir

    Directory: C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React

Mode LastWriteTime Length Name

---

d----- 2025-07-07 12:50 AM node_modules
d----- 2025-07-07 1:04 AM public
d----- 2025-07-07 1:04 AM src
-a---- 2025-07-07 1:04 AM 277 .gitignore
-a---- 2025-07-07 1:04 AM 458 components.json
-a---- 2025-07-07 1:04 AM 877 eslint.config.js
-a---- 2025-07-07 1:04 AM 233 index.html
-a---- 2025-07-07 4:14 PM 93288 package-lock.json
-a---- 2025-07-07 1:04 AM 868 README.md
-a---- 2025-07-07 1:04 AM 188 tailwind.config.js
-a---- 2025-07-07 1:04 AM 248 tsconfig.json
-a---- 2025-07-07 1:04 AM 252 vite.config.js

PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React> cd .\src\
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src> dir

    Directory: C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src

Mode LastWriteTime Length Name

---

d----- 2025-07-07 1:04 AM components
d----- 2025-07-07 1:04 AM layouts
d----- 2025-07-07 1:04 AM lib
-a---- 2025-07-07 1:04 AM 303 App.jsx
-a---- 2025-07-07 4:20 PM 115 index.css
-a---- 2025-07-07 1:04 AM 203 main.jsx

PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src> cd .\components\
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\components> cd .\ui\
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\components\ui> dir

    Directory: C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\components\ui

-a---- 2025-07-07 1:04 AM 3910 form.tsx
-a---- 2025-07-07 1:04 AM 635 label.tsx

PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\components\ui> cd ..
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\components> cd ..
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src> cd .\lib\  
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\lib> dir

Mode LastWriteTime Length Name

---

-a---- 2025-07-07 1:04 AM 79 utils.js

PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\lib> cd ..
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src> cd .\pages\  
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\pages> dir

    Directory: C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\pages

Mode LastWriteTime Length Name

---

-a---- 2025-07-07 1:04 AM 331 Notfound.jsx
-a---- 2025-07-07 1:04 AM 104 Project.jsx
-a---- 2025-07-07 1:04 AM 119 Skills.jsx

PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\pages> cd ..
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src> cd .\router\  
PS C:\C-PROJECT\template_learning\Templates_To-Work\laravel-React\APi-Laravel-React\FrentEnd-React\src\router> dir

Mode LastWriteTime Length Name

---

-a---- 2025-07-07 1:04 AM 890 index.jsx

and the package.json have : [
{
"name": "frentend-react",
"version": "1.0.0",
"description": "This template provides a minimal setup to get React working in Vite with HMR and some ESLint rules.",
"main": "eslint.config.js",
"scripts": {
"test": "echo \"Error: no test specified\" && exit 1",
"dev": "vite",
"build": "vite build",
"preview": "vite preview"
},
"keywords": [],
"author": "",
"license": "ISC",
"type": "commonjs",
"dependencies": {
"@hookform/resolvers": "^5.1.1",
"@radix-ui/react-label": "^2.1.7",
"@radix-ui/react-slot": "^1.2.3",
"class-variance-authority": "^0.7.1",
"clsx": "^2.1.1",
"lucide-react": "^0.525.0",
"react": "^19.1.0",
"react-dom": "^19.1.0",
"react-hook-form": "^7.60.0",
"react-router-dom": "^7.6.3",
"tailwind-merge": "^3.3.1",
"zod": "^3.25.74"
},
"devDependencies": {
"@tailwindcss/postcss": "^4.1.11",
"@types/react": "^19.1.8",
"@types/react-dom": "^19.1.6",
"@vitejs/plugin-react": "^4.6.0",
"autoprefixer": "^10.4.21",
"postcss": "^8.5.6",
"tailwindcss": "^4.1.11",
"tw-animate-css": "^1.3.5",
"typescript": "^5.8.3",
"vite": "^6.3.5"
}
}

]
and the tailwind.config.js : [
/** @type {import('tailwindcss').Config} \*/
module.exports = {
content: [
"./index.html",
"./src/**/\*.{js,jsx}",
],
theme: {
extend: {},
},
plugins: [],
}

]
and ihave the tscongig.json : [
{
"files": [],
"references": [
{
"path": "./tsconfig.app.json"
},
{
"path": "./tsconfig.node.json"
}
],
"compilerOptions": {
"baseUrl": ".",
"paths": {
"@/_": ["./src/_"]
}
}
}
]
and the vite.config.js : [
import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react'
import path from 'path'

export default defineConfig({
plugins: [react()],
resolve: {
alias: {
'@': path.resolve(\_\_dirname, './src'),
},
},
})

]
