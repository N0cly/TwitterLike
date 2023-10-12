document.addEventListener('DOMContentLoaded', function () {
    const errorContainer = document.querySelector('.error');
    const closeButton = document.querySelector('.error__close');

    function showError() {
        errorContainer.style.top = '0';
    }

    function hideError() {
        errorContainer.style.top = '-100px';
    }

    closeButton.addEventListener('click', hideError);

    // Utilisez cette ligne pour afficher la fenêtre d'erreur (par exemple après une opération avec une erreur)
    // showError();
});