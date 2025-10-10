document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-comment-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();


            const svgPath = this.querySelector('svg path');
            const likesCountElement = this.querySelector('.likes-count');
            const commentId = this.getAttribute('data-comment-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Defined SVG paths
            const likedPath = 'm480-120-58-52q-101-91-167-157T150-447.5Q111-500 95.5-544T80-634q0-94 63-157t157-63q52 0 99 22t81 62q34-40 81-62t99-22q94 0 157 63t63 157q0 46-15.5 90T810-447.5Q771-395 705-329T538-172l-58 52Z';
            const unlikedPath = 'M440-501Zm0 381L313-234q-72-65-123.5-116t-85-96q-33.5-45-49-87T40-621q0-94 63-156.5T260-840q52 0 99 22t81 62q34-40 81-62t99-22q81 0 136 45.5T831-680h-85q-18-40-53-60t-73-20q-51 0-88 27.5T463-660h-46q-31-45-70.5-72.5T260-760q-57 0-98.5 39.5T120-621q0 33 14 67t50 78.5q36 44.5 98 104T440-228q26-23 61-53t56-50l9 9 19.5 19.5L605-283l9 9q-22 20-56 49.5T498-172l-58 52Zm280-160v-120H600v-80h120v-120h80v120h120v80H800v120h-80Z';

            fetch('/comment/like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    comment_id: commentId
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Toggle SVG path
                        svgPath.setAttribute('d',
                            svgPath.getAttribute('d') === likedPath ? unlikedPath : likedPath
                        );

                        // Update likes count
                        likesCountElement.textContent = data.likes_count;
                    }
                })
                .catch(error => {
                    console.error('Like Error:', error);
                    // alert('An error occurred while processing your request.');
                });
        });
    });
});
