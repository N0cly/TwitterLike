e = false;
function togglePasswordVisibility(id) {
    if(e){
        document.getElementById("mdp2").setAttribute("type", "text");
        document.getElementById("eye").src="Images/Form/oeil.png"
        e=false;
    }
    else{
        document.getElementById("mdp2").setAttribute("type", "password");
        document.getElementById("eye").src="Images/Form/oeil_ferme.png"
        e=true;
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

