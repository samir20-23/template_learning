import HeroImg from "../assets/HeroImg.png";
export default function MainContent() {
  return (
    <div className="mainContentPart">
      <div className="section_hero-img-left">
        <img src={HeroImg} alt="" />
      </div>
      {/* right */}
      <div className="section_hero-content-right">
        <div className="heroSectionrightleft">
          <div className="section_hero_top-left">
            <div className="icon">
              <i className="fa fa-address-book" aria-hidden="true"></i>
            </div>
          </div>

          <div className="section_hero_top-right">
            <div className="section_hero_top-right-top">
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
              <div className="cercle"></div>
            </div>
            <div className="tetleContentpage">big title</div>
          </div>
        </div>
        <div className="downSEction">balckpart</div>
      </div>
    </div>
  );
}
