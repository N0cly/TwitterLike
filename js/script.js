

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



// function showPwd1() {
//     var x = document.getElementById("mdp1");
//     if (x.type === "password") {
//         x.type = "text";
//     } else {
//         x.type = "password";
//     }
// }
//
// function showPwd2() {
//     var x = document.getElementById("mdp2");
//     if (x.type === "password") {
//         x.type = "text";
//     } else {
//         x.type = "password";
//     }
// }

function togglePasswordVisibility(id) {
    var x = document.getElementById(id);
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}


function afficherFormulaire(formulaire) {
    var formulaireInscription = document.getElementById("register");
    var formulaireConnexion = document.getElementById("connexion");

    if (formulaire === "inscription") {
        formulaireInscription.style.display = "block";
        formulaireConnexion.style.display = "none";
    } else if (formulaire === "connexion") {
        formulaireInscription.style.display = "none";
        formulaireConnexion.style.display = "block";
    }
}