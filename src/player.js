import videojs from 'video.js';
import 'video.js/dist/video-js.css';
import 'videojs-playlist'; // Importez videojs-playlist

import 'videojs-playlist-ui/dist/videojs-playlist-ui.css';
import videojsPlaylistUi from 'videojs-playlist-ui';

import './player.css';

import { setupFavorites } from './player-favorites.js';

window.videojs = videojs;


// # Playlist array structure
// $playlist[] = array(
//     'sources' => array(
//         'src' => Wrap::build_url ($this->path_url . '/' . $filename),
//         'type' => $file->mime_type,
//     ),
//     'name' => $file->name,
//     'poster' => $file->get_thumb(false),
// );


window.setupPlayer = function(playlist) {
    document.addEventListener('DOMContentLoaded', function() {
        window.player = videojs('player');
        player.playlist(playlist);
        player.playlist.autoadvance(0);
        player.playlistUi();

        setupFavorites(player);

        // Créer un nouvel élément pour le titre de la vidéo
        var videoTitle = document.createElement('div');
        videoTitle.className = 'video-title';
        videoTitle.style.display = 'none'; // Cacher le titre par défaut

        // Créer un nouvel élément pour le titre de la vidéo
        var videoTitle = document.createElement('div');
        videoTitle.className = 'video-title';

        var playerElement = document.getElementById('player');
        playerElement.appendChild(videoTitle); // Ajouter le titre à l'élément du lecteur

        var controlBar = document.getElementsByClassName('vjs-control-bar')[0];
        controlBar.appendChild(videoTitle); // Ajouter le titre à la barre de contrôle
        
        player.on('ready', function() {
            var prevButton = document.createElement('button');
            prevButton.innerHTML = '&#9664;';
            prevButton.addEventListener('click', function() {
                player.playlist.previous();
            });

            var nextButton = document.createElement('button');
            nextButton.innerHTML = '&#9654;';
            nextButton.addEventListener('click', function() {
                player.playlist.next();
            });

            var controlBar = document.getElementsByClassName('vjs-control-bar')[0];
            var playToggle = document.getElementsByClassName('vjs-play-control')[0];

            controlBar.insertBefore(prevButton, playToggle);

            if (playToggle.nextSibling) {
                controlBar.insertBefore(nextButton, playToggle.nextSibling);
            } else {
                controlBar.appendChild(nextButton);
            }
            
        });
        
        player.on('playlistitem', function() {
            // Obtenir l'index de l'élément actuel
            var currentIndex = player.playlist.currentItem();

            // Obtenir l'objet vidéo actuel
            var currentVideo = player.playlist()[currentIndex];

            // Mettre à jour le titre chaque fois que la vidéo change
            videoTitle.textContent = currentVideo.name;
        });

        player.on('loadedmetadata', function() {
            // Obtenir l'index de l'élément actuel
            var currentIndex = player.playlist.currentItem();
    
            // Obtenir l'objet vidéo actuel
            var currentVideo = player.playlist()[currentIndex];
    
            // Afficher le titre de la vidéo actuelle
            videoTitle.textContent = currentVideo.name;
            videoTitle.style.display = 'block';
        });
    
        var files = document.querySelectorAll('.file.playable');
        files.forEach(function(file) {
            file.addEventListener('click', function() {
                var playlistIndex = parseInt(this.getAttribute('data-index'), 10);
                player.playlist.currentItem(playlistIndex);
                player.play();
                
                // Afficher le conteneur <dialog>
                dialog.showModal();
            });
        });

        var dialog = document.getElementById('player-modal');
        dialog.addEventListener('close', function() {
            player.pause();
        });
        dialog.addEventListener('click', function() {
            // player.pause();
            this.close();
        });

        var video = dialog.querySelector('#player .video-js');
        video.addEventListener('click', function(event) {
            event.stopPropagation();
        });
        
        var listButtons = document.querySelectorAll('.file.playable .button');
        listButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                // Votre code pour gérer le clic sur le bouton ici...
            });
        });
    });
}
