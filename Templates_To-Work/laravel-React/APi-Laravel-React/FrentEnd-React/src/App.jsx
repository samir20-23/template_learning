 
import './App.css';
import { RouterProvider } from 'react-router-dom';  // Import RouterProvider
import { router } from './router/index.jsx';  // Import the router object
import './index.css' 
function App() { 

  return (
    <>  
      <RouterProvider router={router} />
    </>
  );
}

export default App;