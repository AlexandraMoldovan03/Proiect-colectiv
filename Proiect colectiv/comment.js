document.addEventListener('DOMContentLoaded', function () {
    const postCommentButtons = document.querySelectorAll('.post-comment-button');

    postCommentButtons.forEach(button => {
        button.addEventListener('click', () => {
            const postId = button.dataset.postId;
            const commentInput = document.querySelector(`.comment-input[data-post-id='${postId}']`);
            const commentText = commentInput.value.trim();

            if (commentText !== '') {
                // Trimiteți datele către fișierul PHP pentru a salva comentariul în baza de date
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_comment.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        if (this.responseText === 'success') {
                            // Dacă inserarea în baza de date a fost reușită, actualizați afișarea comentariilor
                            fetchComments(postId);
                            commentInput.value = ''; // Ștergeți textul din input după ce a fost postat comentariul
                            // Reîncărcați pagina pentru a actualiza postările
                            location.reload();
                        } else {
                            alert('Failed to add comment. Please try again.');
                        }
                    }
                };
                xhr.send(`post_id=${postId}&comment_text=${encodeURIComponent(commentText)}`);
            } else {
                alert('Please enter a comment.');
            }
        });
    });

    function fetchComments(postId) {
        // Selectați containerul pentru afișarea comentariilor sub postare
        const commentsContainer = document.querySelector(`.feed[data-post-id="${postId}"] .comments-container`);

        // Faceți o cerere AJAX pentru a obține comentariile din baza de date pentru postul specificat
        const xhr = new XMLHttpRequest();
        xhr.open('GET', `get_comments.php?post_id=${postId}`, true);
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                // Parsați răspunsul JSON pentru a obține comentariile
                const comments = JSON.parse(this.responseText);

                // Ștergeți toate comentariile existente din containerul de comentarii
                commentsContainer.innerHTML = '';

                // Iterați prin fiecare comentariu și adăugați-l în containerul de comentarii
                comments.forEach(comment => {
                    const commentElement = document.createElement('div');
                    commentElement.classList.add('comment');
                    commentElement.innerHTML = `
                        <span>${comment.fname} ${comment.lname}</span>
                        <span>${comment.created_at}</span>
                        <p>${comment.comment_text}</p>
                    `;
                    commentsContainer.appendChild(commentElement);
                });
            }
        };
        xhr.send();
    }
});