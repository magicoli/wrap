import videojs from 'video.js';
import 'video.js/dist/video-js.css';
import 'videojs-playlist'; // Importez videojs-playlist

import 'videojs-playlist-ui/dist/videojs-playlist-ui.css';
import videojsPlaylistUi from 'videojs-playlist-ui';

import './player.css';

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
        var player = videojs('player');
        player.playlist(playlist);
        player.playlist.autoadvance(0);
        player.playlistUi();

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

        // Charger les favoris stockés
        var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        var favButton;

        // Ajouter la classe tag-favorite aux éléments favoris
        favorites.forEach(function(index) {
            var element = document.querySelector('.file.playable[data-index="' + index + '"]');
            element.classList.add('tag-favorite');
        });
        
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

            // Créer un bouton de favori
            favButton = document.createElement('button');
            favButton.innerHTML = '&#10084;'; // Symbole de coeur
            favButton.className = 'vjs-fav-button';

            // Obtenir la barre de progression
            var progressBar = document.getElementsByClassName('vjs-progress-control')[0];

            // Ajouter le bouton de favori à la barre de contrôle avant la barre de progression
            controlBar.insertBefore(favButton, progressBar);
        
            // Gestionnaire d'événements pour le bouton de favori
            favButton.addEventListener('click', function() {
                // Obtenir l'index de l'élément actuel
                var currentIndex = player.playlist.currentItem();
        
                // Obtenir l'élément avec le même data-index que l'élément actuel
                var currentElement = document.querySelector('.file.playable[data-index="' + currentIndex + '"]');
        
                // Ajouter ou supprimer la classe tag-favorite
                currentElement.classList.toggle('tag-favorite');
        
                // Mettre à jour les favoris stockés
                var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
                var favoriteIndex = favorites.indexOf(currentIndex);
        
                if (favoriteIndex !== -1) {
                    // Supprimer des favoris
                    favorites.splice(favoriteIndex, 1);
                    // Supprimer la classe active
                    favButton.classList.remove('active');
                } else {
                    // Ajouter aux favoris
                    favorites.push(currentIndex);
                    // Ajouter la classe active
                    favButton.classList.add('active');
                }

                // Enregistrer les favoris
                localStorage.setItem('favorites', JSON.stringify(favorites));
            });
        });

        function updateFavButtonState() {
            // Obtenir l'index de l'élément actuel
            var currentIndex = player.playlist.currentItem();

            // Mettre à jour les favoris stockés
            var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
            var favoriteIndex = favorites.indexOf(currentIndex);

            if (favoriteIndex !== -1) {
                // Si la vidéo actuelle est un favori, ajouter la classe active
                favButton.classList.add('active');
            } else {
                // Sinon, supprimer la classe active
                favButton.classList.remove('active');
            }
        }

        player.on('loadedmetadata', function() {
            updateFavButtonState();
        });

        player.on('playlistitem', function() {
            updateFavButtonState();
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

        player.on('playlistitem', function() {
            // Obtenir l'index de l'élément actuel
            var currentIndex = player.playlist.currentItem();

            // Obtenir l'objet vidéo actuel
            var currentVideo = player.playlist()[currentIndex];

            // Mettre à jour le titre chaque fois que la vidéo change
            videoTitle.textContent = currentVideo.name;
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
