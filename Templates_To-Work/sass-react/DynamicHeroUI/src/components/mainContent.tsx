import HeroImg from "../assets/HeroImg.png";
import Rightpart from "../assets/rightpart.png";

export default function MainContent() {
  return (
    <div className="mainContentPart">
      <div className="section_hero-img-left">
        <img src={HeroImg} alt="" />
      </div>
      <div className="section_hero-content-right">
           <img src={Rightpart} alt="" />
      </div>
    </div>
  );
}
