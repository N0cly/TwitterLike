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

    const likeButtons = document.querySelectorAll('.like');

    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id_post = this.dataset.id_post;
            console.log("Bouton 'Like' cliqué pour le post avec l'ID :", id_post);

            fetch('like_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({id_post})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Nouveau compteur de likes pour le post avec l'ID", id_post, ":", data.newLikeCount);
                        this.textContent = `❤️ ${data.newLikeCount}`;
                    } else {
                        console.error("La requête n'a pas réussi. Réponse du serveur :", data.message);
                    }
                })
                .catch(error => {
                    console.error("Erreur lors de la requête Fetch :", error);
                });
        });
    });
});
