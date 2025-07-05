 

````markdown
# Flutter Starter Guide 🚀

This README explains how to set up Flutter, run a basic app, and understand the folder structure.

---

## ✅ Requirements

- Windows, macOS, or Linux
- Android Studio or VS Code
- Git

---

## 🛠 Installation

1. **Download Flutter SDK**
   - https://docs.flutter.dev/get-started/install

2. **Extract and Add to Path**
   - Add the Flutter `bin` folder to your system PATH.

3. **Check Flutter Setup**
   ```bash
   flutter doctor
````

4. **Install Android Studio / Emulator**

   * Install Android Studio and the **Flutter** and **Dart** plugins.
   * Set up an emulator or connect a physical device.

---

## 🎯 Create a Flutter App

```bash
flutter create hello_app
cd hello_app
flutter run
```

---

## 🧪 Sample Code

Edit `lib/main.dart` to this simple app:

```dart
import 'package:flutter/material.dart';

void main() {
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Hello Flutter',
      home: Scaffold(
        appBar: AppBar(title: Text('Hello')),
        body: Center(child: Text('👋 Hello World!', style: TextStyle(fontSize: 24))),
      ),
    );
  }
}
```

---

## 📁 Folder Structure

* `lib/`: Main Dart code.
* `android/` & `ios/`: Platform-specific code.
* `test/`: Unit and widget tests.
* `pubspec.yaml`: Project config and dependencies.

---

## 📦 Useful Commands

```bash
flutter doctor        # Check environment
flutter run           # Run app on device
flutter build apk     # Build release APK
flutter pub get       # Install packages
```

---

## 🧠 Tips

* Use **hot reload** to update UI instantly (`r` in terminal or the lightning button in IDE).
* Use `pubspec.yaml` to add packages from [https://pub.dev](https://pub.dev).
* Use `StatefulWidget` for interactive widgets.

---

Happy Fluttering! 💙

```

 