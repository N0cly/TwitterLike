e = false;
function togglePasswordVisibility(id) {
    var passwordField = document.getElementById(id);
    var eyeIcon = document.querySelector("#" + id + "-eye");

    if (passwordField.getAttribute("type") === "password") {
        passwordField.setAttribute("type", "text");
        eyeIcon.src = "Images/Form/oeil.png";
    } else {
        passwordField.setAttribute("type", "password");
        eyeIcon.src = "Images/Form/oeil_ferme.png";
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

