import { Link } from "react-router-dom";
import imgProfile from "../assets/imgprofile.jpg";
import FooterImg from "../assets/footer.png";

export default function footer() {
  return (
    <div className="FooterPart">
      <p className="title">NEW ARRIVALS</p>
      <div className="imgcontent">
        <img src={FooterImg} alt="" />
      </div>
      <div className="partGetNow">
        <Link to="/" className="linkGETnow">
          GET NOW
        </Link>
      </div>
    </div>
  );
}
