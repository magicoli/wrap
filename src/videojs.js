import videojs from 'video.js';
import 'video.js/dist/video-js.css';
import 'videojs-playlist'; // Importez videojs-playlist

import 'videojs-playlist-ui/dist/videojs-playlist-ui.css';
import videojsPlaylistUi from 'videojs-playlist-ui';

// npm view videojs-playlist-ui dependenciesnpm view videojs-playlist-ui dependenciesimport videojsPlaylistUi from 'videojs-playlist-ui';

import './videojs.css';

window.videojs = videojs;

window.setupPlayer = function(playlist) {
    document.addEventListener('DOMContentLoaded', function() {
        var player = videojs('player');
        player.playlist(playlist);
        player.playlist.autoadvance(0);
        player.playlistUi();

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
    });
}
