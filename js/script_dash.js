const likeButtons = document.querySelectorAll('.like');

likeButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const id_post = this.dataset.id_post;

        fetch('like_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({id_post}),
            credentials: 'include',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Extraire le nombre actuel de "likes" du texte du bouton
                    const currentLikeCount = parseInt(button.textContent.match(/\d+/)[0]);

                    // Mettre à jour le compteur de "likes" sur la page en fonction de l'action effectuée
                    if(data.action === 'liked') {
                        button.textContent = `❤️ ${currentLikeCount + 1}`;
                        button.classList.add('liked'); // Ajouter la classe CSS 'liked'
                    } else if(data.action === 'unliked') {
                        button.textContent = `❤️ ${currentLikeCount - 1}`;
                        button.classList.remove('liked'); // Retirer la classe CSS 'liked'
                    }
                } else {
                    console.error('An error occurred:', data.error);
                }
            })
            .catch(error => {
                console.error('Error during fetch operation:', error);
            });
    });
});


// Sélection du bouton "Nouvelle publication" et de la modal
const publicationButton = document.getElementById('ouvrirPublication');
const modal = document.getElementById('modal');

// Ouverture de la modal lors du clic sur le bouton "Nouvelle publication"
publicationButton.addEventListener('click', () => {
    modal.style.display = 'block';
});

// Fermeture de la modal lors du clic en dehors de celle-ci
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

// Si vous avez des boutons de fermeture dans votre modal, vous pouvez également ajouter un événement de clic pour ceux-ci
const closeModalButtons = document.querySelectorAll('.close-modal');
closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        modal.style.display = 'none';
    });
});

const deleteButtons = document.querySelectorAll('.delete');

deleteButtons.forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();

        const id_post = this.dataset.id_post;

        fetch('delete_post.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({id_post}),
            credentials: 'include',
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    console.error('An error occurred:', data.error);
                }
            })
            .catch(error => {
                console.error('Error during fetch operation:', error);
            });
    });
});

const commentButtons = document.querySelectorAll('.comment');
commentButtons.forEach(button => {
    button.addEventListener('click', function() {
        const id_post = this.dataset.id_post;
        document.getElementById('id_pere' + id_post).value = id_post; // Utilisez l'ID unique
        document.getElementById('commentModal' + id_post).style.display = 'block'; // Utilisez l'ID unique
    });
});

const toggleCommentsButtons = document.querySelectorAll('.toggle-comments');
toggleCommentsButtons.forEach(button => {
    button.addEventListener('click', function() {
        const id_post = this.dataset.id_post;
        const commentsContainer = document.getElementById(`commentsContainer${id_post}`);
        commentsContainer.style.display = (commentsContainer.style.display === 'none') ? 'block' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const commentBanners = document.querySelectorAll('.comment-banner');
    commentBanners.forEach(banner => {
        banner.addEventListener('click', function() {
            const id_post = this.dataset.id_post;
            const commentsContainer = document.getElementById('comments' + id_post);
            commentsContainer.style.display = commentsContainer.style.display === 'none' ? 'block' : 'none';
        });
    });
});
