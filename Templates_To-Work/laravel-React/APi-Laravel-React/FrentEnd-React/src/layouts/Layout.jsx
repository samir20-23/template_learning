import { Outlet, Link } from "react-router-dom";
import "../App.css";
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
              <Link to="/login">Login</Link>
            </li>
            <li>
              <Link to="/register">register</Link>
            </li>
            <li>
              <Link to="/users">users</Link>
            </li>
          </ul>
        </nav>
      </header>

      <main>
        <Outlet /> {/* This is where the child routes will be rendered */}
      </main>

      <footer>
        <p>&copy; 2023 My Website</p>
      </footer>
    </>
  );
}

export default Layout;
