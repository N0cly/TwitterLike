
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

