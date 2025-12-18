import Controller from "./helpers/Controller.js";

import common from "./controllers/common.js";
import templateMap from "./controllers/templateMap.js";
import AlertComponent from "./components/AlertComponent.js";
import BannerComponent from "./components/BannerComponent.js";
import HeaderParallax from "./components/HeaderParallax.js";
import videoPlayer from "./components/VideoPlayer.js";
import TagFilters from "./components/TagFilters.js";
import HeaderMenu from "./components/HeaderMenu.js";
import SearchToggle from "./components/SearchToggle.js";
import HeaderScroll from "./components/HeaderScroll.js";

const modules = [
  common,
  templateMap,
  AlertComponent,
  BannerComponent,
  HeaderParallax,
  videoPlayer,
  TagFilters,
  HeaderMenu,
  SearchToggle,
  HeaderScroll,
];
const controller = new Controller(modules);
controller.ready();
