 
### ✅ `electron.js` (place in project root):

```js
const { app, BrowserWindow } = require("electron");
const path = require("path");

function createWindow() {
  const win = new BrowserWindow({
    width: 1200,
    height: 800,
    webPreferences: {
      nodeIntegration: true,
    },
  });

  if (process.env.NODE_ENV === "development") {
    win.loadURL("http://localhost:5173");
  } else {
    win.loadFile(path.join(__dirname, "dist", "index.html"));
  }
}

app.whenReady().then(createWindow);

app.on("window-all-closed", () => {
  if (process.platform !== "darwin") app.quit();
});

app.on("activate", () => {
  if (BrowserWindow.getAllWindows().length === 0) createWindow();
});
```

---

### ✅ `package.json` (replace your existing one):

```json
{
  "name": "dynamicheroui",
  "private": true,
  "version": "0.0.0",
  "type": "module",
  "main": "electron.js",
  "scripts": {
    "dev": "cross-env NODE_ENV=development concurrently \"vite\" \"wait-on http://localhost:5173 && electron .\"",
    "build": "vite build",
    "desktop": "cross-env NODE_ENV=production npm run build && electron .",
    "electron-build": "electron-builder"
  },
  "build": {
    "appId": "com.yourapp.id",
    "productName": "MyDesktopApp",
    "files": [
      "dist/**/*",
      "electron.js"
    ],
    "directories": {
      "buildResources": "assets"
    }
  },
  "dependencies": {
    "lucide-react": "^0.525.0",
    "react": "^19.1.0",
    "react-dom": "^19.1.0",
    "react-router-dom": "^7.7.0"
  },
  "devDependencies": {
    "@eslint/js": "^9.30.1",
    "@types/react": "^19.1.8",
    "@types/react-dom": "^19.1.6",
    "@vitejs/plugin-react": "^4.6.0",
    "concurrently": "^8.2.2",
    "cross-env": "^7.0.3",
    "electron": "^37.2.4",
    "electron-builder": "^24.14.1",
    "eslint": "^9.30.1",
    "eslint-plugin-react-hooks": "^5.2.0",
    "eslint-plugin-react-refresh": "^0.4.20",
    "globals": "^16.3.0",
    "sass": "^1.89.2",
    "typescript": "~5.8.3",
    "typescript-eslint": "^8.35.1",
    "vite": "^7.0.4",
    "wait-on": "^7.0.1"
  }
}
```

---

### ✅ Terminal Commands (run in order):

```bash
npm install
npm run dev
```

To build desktop app:

```bash
npm run electron-build
```
 