import { Outlet, Link } from "react-router-dom";
import '../App.css';
function Layout() {
  return (
    <>
      <header>
        <nav>
          <ul>
            <li>
              <Link to="/">Home</Link>
            </li>
            <li>
              <Link to="/about">About</Link>
            </li>
            <li>
              <Link to="/Skills">Skills</Link>
            </li>
            <li>
              <Link to="/Project">Project</Link>
            </li>
            <li>
              <Link to="/contact">Contact</Link>
            </li> 
          </ul>
        </nav>
      </header>

      <main>
        <Outlet />  
      </main>

      <footer>
        <p>&copy; 2023 My Website</p>
      </footer>
    </>
  );
}

export default Layout;
