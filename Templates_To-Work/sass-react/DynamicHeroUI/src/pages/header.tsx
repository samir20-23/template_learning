import NavigationLeft from "../components/navigation_left";
import Footer from "../components/footer";
import MainContent from "../components/mainContent";

import "../App.scss";
export default function Header() {
  return (
    <>
      <div className="header_main">
        <div className="nav_main-left">
          <div className="navigation_main-left">
            {/* navigation mian left */}
            <NavigationLeft />
          </div>
          <div className="footer_main-left">
            {/* footer */}
            <Footer />
          </div>
        </div>
        {/*  right------ */}
        <div className="nav_main-rigth">
          {/* nav_main-right */}
          <MainContent />
        </div>
      </div>
    </>
  );
}
