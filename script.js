

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



function showPwd() {
    var x = document.getElementById("mdp1");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}