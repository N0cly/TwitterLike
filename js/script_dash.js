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
                    const currentLikeCount = parseInt(button.textContent.match(/\d+/)[0]);
                    if(data.action === 'liked') {
                        button.textContent = `❤️ ${currentLikeCount + 1}`;
                        button.classList.add('liked');
                    } else if(data.action === 'unliked') {
                        button.textContent = `❤️ ${currentLikeCount - 1}`;
                        button.classList.remove('liked');
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

const publicationButton = document.getElementById('ouvrirPublication');
const modal = document.getElementById('modal');

publicationButton.addEventListener('click', () => {
    modal.style.display = 'block';
});

window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});

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
        document.getElementById('id_pere' + id_post).value = id_post;
        document.getElementById('commentModal' + id_post).style.display = 'block';
    });
});

// ... Autre code JavaScript ...

document.addEventListener('DOMContentLoaded', function() {
    const posts = document.querySelectorAll('.post');

    posts.forEach(post => {
        const commentButton = post.querySelector('.post-action.comment');
        const id_post = commentButton.dataset.id_post;
        const commentsContainer = document.getElementById('comments' + id_post);

        commentButton.addEventListener('click', function() {
            commentsContainer.style.display = commentsContainer.style.display === 'none' ? 'block' : 'none';
        });

        // Check if the post has comments
        if (commentsContainer.children.length > 0) {
            const commentBanner = document.createElement('div');
            commentBanner.className = 'comment-banner';
            commentBanner.dataset.id_post = id_post;
            commentBanner.innerHTML = '<span>Afficher les commentaires</span>';

            commentBanner.addEventListener('click', function() {
                commentsContainer.style.display = commentsContainer.style.display === 'none' ? 'block' : 'none';
            });

            post.appendChild(commentBanner);
        }
    });
});

// ... Autre code JavaScript ...


