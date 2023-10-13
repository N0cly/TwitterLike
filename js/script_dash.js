document.addEventListener("DOMContentLoaded", () => {
    const ouvrirPublicationBtn = document.getElementById("ouvrirPublication");
    const modal = document.getElementById("modal");
    const effacerContenuBtn = document.getElementById("effacerContenu");
    const effacerImageBtn = document.getElementById("effacerImage");
    const imageInput = document.getElementById("image");
    const contenuTextarea = document.getElementById("contenu");

    ouvrirPublicationBtn.addEventListener("click", () => {
        modal.style.display = "block";
    });

    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });

    effacerContenuBtn.addEventListener("click", () => {
        contenuTextarea.value = "";
    });

    effacerImageBtn.addEventListener("click", () => {
        imageInput.value = "";
    });
});
