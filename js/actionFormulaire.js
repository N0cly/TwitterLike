// Récupération des éléments HTML
const ouvrirPublicationButton = document.getElementById('ouvrirPublication');
const formulairePublication = document.getElementById('formulairePublication');
const effacerContenuButton = document.getElementById('effacerContenu');
const effacerImageButton = document.getElementById('effacerImage');
const contenuTextarea = document.getElementById('contenu');
const imageInput = document.getElementById('image');

// Gestionnaire d'événement pour ouvrir la fenêtre modale
ouvrirPublicationButton.addEventListener('click', function() {
    formulairePublication.style.display = 'block';
});

// Gestionnaire d'événement pour effacer le contenu du champ de texte
effacerContenuButton.addEventListener('click', function() {
    contenuTextarea.value = '';
});

// Gestionnaire d'événement pour effacer le contenu du champ d'image
effacerImageButton.addEventListener('click', function() {
    imageInput.value = '';
});
