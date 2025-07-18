import HeroImg from "../assets/HeroImg.png";
import Rightpart from "../assets/rightpartt.png";
import RightImg from "../assets/rightIMG.png";

export default function MainContent() {
  return (
    <div className="mainContentPart">
      <div className="section_hero-img-left">
        <img src={HeroImg} className="img1" alt="" />
        <img src={HeroImg} className="img2" alt="" />
      </div>
      <div className="section_hero-content-right">
        {/* search */}
        <div className="topbox">
          <div className="backgIcon">
            <i
              className="fa fa-instagram"
              id="iconinstagram"
              aria-hidden="true"
            ></i>
          </div>

          <div className="search_bar">
            <button className="searchInput">
              <i className="fa fa-search" aria-hidden="true"></i>
              <p>SEARCH</p>
            </button>
            <button className="searchFilter">
              <div className="item1"></div>
              <div className="item2"></div>
              <div className="item3"></div>
            </button>
          </div>
          <div className="backgCercle">
            <div className="cercle"></div>
          </div>
        </div>
        <img src={Rightpart} alt="" />

        {/* down box */}
        <div className="borderradius"></div>
        <div className="downbox">
          <div className="titlepart">
            <p>40% OFF</p>
            <span>ON RACKET</span>
            <button>SHOP NOW</button>
          </div>
          <div className="boximg">
            <img src={RightImg} className="boximg1" alt="" />
            <img src={RightImg} className="boximg2" alt="" />

          </div>
        </div>
      </div>
    </div>
  );
}
