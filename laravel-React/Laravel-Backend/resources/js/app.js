import './bootstrap';
import './components/Example';
import React from 'react';
import ReactDOM from 'react-dom/client';
import HelloReact from './components/HelloReact';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(<HelloReact />);
