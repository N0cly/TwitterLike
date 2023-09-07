

const inscriptionButton = document.getElementById("inscriptionButton");
const connexionButton = document.getElementById("connexionButton");
const formInscription = document.getElementById("register");
const formConnexion = document.getElementById("connexion");
formConnexion.style.display = "block";
formInscription.style.display = "none";


// Gestionnaire d'événement pour le bouton "Inscription"
inscriptionButton.addEventListener("click", function () {
    formInscription.style.display = "block";
    formConnexion.style.display = "none";
});

// Gestionnaire d'événement pour le bouton "Connexion"
connexionButton.addEventListener("click", function () {
    formInscription.style.display = "none";
    formConnexion.style.display = "block";
});


const toggle_pswd = document.getElementById("checkpswd");
const field_mdp = document.getElementById("mdp");


// toggle password visibility
toggle_pswd.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = field_mdp.getAttribute('type') === 'password' ? 'text' : 'password';
    field_mdp.setAttribute('type', type);
})
