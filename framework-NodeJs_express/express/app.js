const express = require('express');
const bodyParser = require('body-parser');
const app = express();

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.set('view engine', 'ejs'); // Use ejs for templating

// Sample posts data (in a real app, you'd pull this from a database)
let posts = [
  { title: "First Post", content: "This is the first post." },
  { title: "Second Post", content: "This is the second post." }
];

// Routes
app.get('/', (req, res) => {
  res.render('index', { posts });  // Render index.ejs with posts data
});

app.get('/post/:id', (req, res) => {
  const post = posts[req.params.id];
  res.render('post', { post });  // Render individual post page
});

// Start the server
app.listen(3000, () => {
  console.log('Blog server running on http://localhost:3000');
});
