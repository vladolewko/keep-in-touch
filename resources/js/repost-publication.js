document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.repost-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const svgElement = this.querySelector('svg');
            const repostsCountElement = this.querySelector('.reposts-count');
            const publicationId = this.getAttribute('data-publication-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const repostedFill = 'blue';
            const unrepostedFill = 'gray';

            fetch('/publication/repost', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    publication_id: publicationId
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
                        // Update the fill color based on the returned state
                        const newFill = data.reposted ? repostedFill : unrepostedFill;
                        svgElement.setAttribute('fill', newFill);

                        // Update text color classes based on the returned state
                        if (data.reposted) {
                            repostsCountElement.classList.add('text-blue-800');
                            repostsCountElement.classList.remove('text-gray-500');
                        } else {
                            repostsCountElement.classList.add('text-gray-500');
                            repostsCountElement.classList.remove('text-blue-800');
                        }

                        // Update the count
                        repostsCountElement.textContent = data.reposts_count;
                    }
                })
                .catch(error => {
                    console.error('Repost Error:', error);
                });
        });
    });
});
