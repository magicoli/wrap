import videojs from 'video.js';
import 'video.js/dist/video-js.css';
// Importez votre CSS principal après les CSS de Video.js pour éviter les problèmes de priorité CSS
import './player.css';

// Utilisez Video.js ici
const player = videojs('my-video');
