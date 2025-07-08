import { createBrowserRouter } from "react-router-dom";
import Layout from "../layouts/Layout";
import Home from "../pages/Home";
import NotFound from "../pages/Notfound";
import About from "../pages/About";
import Contact from "../pages/Contact";
import Skills from "../pages/Skills";
import Project from "../pages/Project";
import LoginPage from "../pages/LoginPage";
import RegisterPage from "../pages/RegisterPage";
export const router = createBrowserRouter([
  {
    element: <Layout />,
    children: [
      // { 
      //   path: "/login", 
      //   element: <LoginPage />,
      //  },    { 
      //   path: "/register", 
      //   element: <RegisterPage />,
      //  }, 
      //   { 
      //   path: "/dashboard", 
      //   element: <h1>Dashboard</h1>,
      //  },
      {
        path: "/",
        element: <Home />,
      },
      {
        path: "/about",
        element: <About />,
      },
      {
        path: "/skills",
        element: <Skills />,
      },
      {
        path: "/project",
        element: <Project />,
      },
      {
        path: "/contact",
        element: <Contact />,
      },
      {
        path: "*",
        element: <NotFound />,
      },
    ],
  },
]);
