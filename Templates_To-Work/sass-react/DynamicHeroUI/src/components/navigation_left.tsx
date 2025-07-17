import { Link } from "react-router-dom";
import imgProfile from "../assets/imgprofile.jpg";
import Logo from "../assets/Logo.jpg";

export default function navigationLeft() {
  return (
    <div className="navigation_main-left">
      <div className="logo">
        <Link to={"/"}>
          <img src={Logo} alt="" />
        </Link>
      </div>
      <nav>
        <ul>
          <li>
            <Link to="/">
              <i className="fa fa-home" aria-hidden="true"></i>
            </Link>
          </li>
          <li>
            <Link to="/">
              <i className="fa fa-building" aria-hidden="true"></i>{" "}
            </Link>
          </li>
          <li>
            <Link to="/">
              <i className="fa fa-cart-arrow-down" aria-hidden="true"></i>{" "}
            </Link>
          </li>
          <li>
            <Link to="/">
              <i className="fa fa-heart" aria-hidden="true"></i>
            </Link>
          </li>
        </ul>
      </nav>
      <div className="Profile_img">
        <img src={imgProfile} alt="Profile" />
      </div>
    </div>
  );
}

//
