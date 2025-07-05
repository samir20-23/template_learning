AiScript is a scripting language primarily used for creating extensions or custom functionality within platforms like **Misskey** and **Calckey**. It is designed to be lightweight and easy to integrate, allowing developers to automate tasks, create dynamic features, and extend the functionality of these platforms.

### Key Features of AiScript:
1. **Custom Extensions**: Primarily used for building extensions on Misskey/Calckey, which are decentralized social media platforms.
2. **Simple Syntax**: Provides a syntax that is easy to understand, making it accessible for both beginners and advanced developers.
3. **Automation and Custom Logic**: Used to implement automated tasks, dynamic interactions, and other custom logic within Misskey or Calckey environments.
4. **File Extensions**: AiScript files typically use the `.aiscript` or `.is` extensions.
 .

### use 
To start using AiScript and run code, follow this simple tutorial:

### Prerequisites
- **Visual Studio Code** (VSCode) installed.
- **AiScript Extension** installed in VSCode (which you have already done).
- **Misskey** or **Calckey** (or any platform that supports AiScript) installed and set up to test AiScript scripts.

### 1. Create Your AiScript File
- Open VSCode.
- In your project folder, create a new file with the `.aiscript` or `.is` extension (you already have `script.is`).
- Paste your AiScript code inside the file.

### Example AiScript Code:
```aiscript
// AiScript example

// Function to greet a user
function greet(name) {
    return "Hello, " + name + "!";
}

// Call the function and store the result
let result = greet("World");

// Log the result to console
console.log(result);
```

### 2. Run AiScript Code
To **run AiScript**, you will need an environment that supports it. Here's what you can do:

#### If you're using **Misskey** or **Calckey**:
1. **Integrate AiScript with your Misskey/Calckey instance**:
   - These platforms allow you to create extensions or custom scripts using AiScript.
   - You need to check their documentation for how to load and test scripts in their environment. Usually, this involves placing your `.aiscript` files in the extension folders or API calls.

#### If you're just testing locally:
- **Currently, there isn't a standalone AiScript runtime**, so you need to test it within the context of a platform like Misskey/Calckey. You might need to run these scripts via the platform's internal system or API.

### 3. Debug and Test:
- **Log Output**: In VSCode, you can view the syntax and potential errors via the AiScript extension (for syntax highlighting).
- **Integration**: Once integrated into the platform, run or reload the platform, and check the output (for example, in Misskey's admin interface or through API calls).

### 4. Next Steps
- Explore more advanced features of AiScript, such as interacting with platform APIs or implementing complex logic.
- Check platform-specific tutorials for integrating and running AiScript in Misskey or Calckey.
 