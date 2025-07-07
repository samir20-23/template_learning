import { Outlet, Link } from "react-router-dom";
import "../App.css";
import imgUrl from "../assets/img/logo.png";
function Layout() {
  return (
    <>
      <header>
        <nav>
          <ul>
            <div className="logo">
              <Link to="/">
                <img src={imgUrl} alt="Logo" className="h-12 w-auto" />
              </Link>
            </div>
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
            <li>
              <Link to="/Login">Login</Link>
            </li>
            <li>
              <Link to="/Register">Register</Link>
            </li>
          </ul>
        </nav>
      </header>

      <main className="main">
        <Outlet />
      </main>

      <footer>
        <p>&copy; 2023 My Website</p>
      </footer>
    </>
  );
}

export default Layout;
