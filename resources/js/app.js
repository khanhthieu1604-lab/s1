import './bootstrap';
import { animate, createTimeline } from 'animejs';
import Alpine from 'alpinejs';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Lenis from 'lenis';

// Swiper
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

// Adapter for Anime.js v4 to maintain v3 compatibility
const anime = (params) => animate(params);
anime.timeline = (params) => createTimeline(params);

window.Alpine = Alpine;
window.anime = anime;
window.Swiper = Swiper;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.Lenis = Lenis;

Alpine.start();