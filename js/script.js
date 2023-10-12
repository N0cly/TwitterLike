
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

function togglePasswordVisibility(id) {
    var input = document.getElementById(id);
    if (input.type === "password") {
        input.type = "text";
    } else {
        input.type = "password";
    }
}


