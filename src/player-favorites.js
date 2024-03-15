//  # HTML structure
// $content .= sprintf( 
//     '<li id="%s" class="%s" data-index="%s">
//         <span class=thumbnail>%s</span>
//         <span class=name>%s</span>
//         <span class=buttons></span>
//     </li>',
//     'list-item-' . $id,
//     join(' ', $classes),
//     $idx,
//     $thumb,
//     $name,
// );

// # Playlist array structure
// $playlist[] = array(
//     'sources' => array(
//         'src' => Wrap::build_url ($this->path_url . '/' . $filename),
//         'type' => $file->mime_type,
//     ),
//     'name' => $file->name,
//     'poster' => $file->get_thumb(false),
// );

export function setupFavorites(player) {
    // Charger les favoris stockés
    var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
    var favButton;

    // Ajouter la classe tag-favorite aux éléments favoris
    favorites.forEach(function(src) {
        var index = player.playlist().findIndex(function(item) {
            return item.sources.src === src;
        });
        var element = document.querySelector('.file.playable[data-index="' + index + '"]');
        if (element) {
            element.classList.add('tag-favorite');
        }
    });

    // Créer un bouton de favori pour chaque élément de la liste
    var listItems = document.querySelectorAll('.file.playable');
    listItems.forEach(function(listItem) {
        var buttonContainer = document.createElement('span');
        buttonContainer.className = 'button favorite';

        var favButtonListItem = document.createElement('span');
        favButtonListItem.innerHTML = '&#10084;'; // Symbole de coeur
        favButtonListItem.className = 'button-favorite';

        buttonContainer.appendChild(favButtonListItem);

        var buttons = listItem.querySelector('.buttons');
        buttons.appendChild(buttonContainer);

        // Gestionnaire d'événements pour le bouton de favori de la liste
        favButtonListItem.addEventListener('click', function() {
            // Obtenir l'index et le src de l'élément actuel
            var currentIndex = parseInt(listItem.getAttribute('data-index'), 10);
            var currentSrc = player.playlist()[currentIndex].sources.src;

            // Ajouter ou supprimer la classe tag-favorite
            listItem.classList.toggle('tag-favorite');

            // Mettre à jour les favoris stockés
            var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
            var favoriteIndex = favorites.indexOf(currentSrc);

            if (favoriteIndex !== -1) {
                // Supprimer des favoris
                favorites.splice(favoriteIndex, 1);
            } else {
                // Ajouter aux favoris
                favorites.push(currentSrc);
            }

            // Enregistrer les favoris
            localStorage.setItem('favorites', JSON.stringify(favorites));
        });
    });

    player.on('ready', function() {
        // Créer un bouton de favori
        favButton = document.createElement('button');
        favButton.innerHTML = '&#10084;'; // Symbole de coeur
        favButton.className = 'vjs-fav-button';

        // Obtenir la barre de progression
        var progressBar = document.getElementsByClassName('vjs-progress-control')[0];

        // Ajouter le bouton de favori à la barre de contrôle avant la barre de progression
        var controlBar = document.getElementsByClassName('vjs-control-bar')[0];
        controlBar.insertBefore(favButton, progressBar);
    
        // Gestionnaire d'événements pour le bouton de favori
        favButton.addEventListener('click', function() {
            // Obtenir l'index et le src de l'élément actuel
            var currentIndex = player.playlist.currentItem();
            var currentSrc = player.playlist()[currentIndex].sources.src;
        
            // Obtenir l'élément avec le même data-index que l'élément actuel
            var currentElement = document.querySelector('.file.playable[data-index="' + currentIndex + '"]');
        
            // Ajouter ou supprimer la classe tag-favorite
            currentElement.classList.toggle('tag-favorite');
        
            // Mettre à jour les favoris stockés
            var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
            var favoriteIndex = favorites.indexOf(currentSrc);
        
            if (favoriteIndex !== -1) {
                // Supprimer des favoris
                favorites.splice(favoriteIndex, 1);
                // Supprimer la classe active
                favButton.classList.remove('active');
            } else {
                // Ajouter aux favoris
                favorites.push(currentSrc);
                // Ajouter la classe active
                favButton.classList.add('active');
            }
        
            // Enregistrer les favoris
            localStorage.setItem('favorites', JSON.stringify(favorites));
        });
    });

    function updateFavButtonState() {
        // Obtenir l'index et le src de l'élément actuel
        var currentIndex = player.playlist.currentItem();
        var currentSrc = player.playlist()[currentIndex].sources.src;
    
        // Mettre à jour les favoris stockés
        var favorites = JSON.parse(localStorage.getItem('favorites')) || [];
        var favoriteIndex = favorites.indexOf(currentSrc);
    
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
};
