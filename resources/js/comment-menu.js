document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.comments-trigger').forEach(trigger => {
        trigger.addEventListener('click', function() {
            const publicationId = this.getAttribute('data-publication-id');
            const commentsPopup = document.getElementById(`comments-popup-${publicationId}`);

            if (commentsPopup) {
                openPopup(commentsPopup, publicationId);
            }
        });
    });

    document.querySelectorAll('.close-popup-btn').forEach(closeBtn => {
        closeBtn.addEventListener('click', function() {
            const commentsPopup = this.closest('.comments-popup-modal');
            if (commentsPopup) {
                closePopup(commentsPopup);
            }
        });
    });

    document.querySelectorAll('.comments-popup-modal').forEach(popup => {
        popup.addEventListener('click', function(event) {
            if (event.target === popup) {
                closePopup(popup);
            }
        });
    });


    function openPopup(popup, publicationId) {
        popup.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        switchTab('comments', publicationId);

        const commentsTab = document.getElementById(`comments-tab-${publicationId}`);
        const likesTab = document.getElementById(`likes-tab-${publicationId}`);

        if (commentsTab) {
            commentsTab.onclick = () => switchTab('comments', publicationId);
        }
        if (likesTab) {
            likesTab.onclick = () => switchTab('likes', publicationId);
        }
    }

    function closePopup(popup) {
        popup.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function switchTab(tab, publicationId) {
        const commentsTab = document.getElementById(`comments-tab-${publicationId}`);
        const likesTab = document.getElementById(`likes-tab-${publicationId}`);
        const commentsContent = document.getElementById(`comments-content-${publicationId}`);
        const likesContent = document.getElementById(`likes-content-${publicationId}`);
        const commentInputSection = document.getElementById(`comment-input-section-${publicationId}`);

        const activeClasses = ['border-blue-500', 'text-gray-900', 'dark:text-white', 'font-semibold'];
        const inactiveClasses = ['border-transparent', 'text-gray-500', 'dark:text-gray-400', 'hover:text-gray-700', 'dark:hover:text-gray-300', 'font-medium'];

        if (tab === 'comments') {
            commentsTab.classList.add('border-b-2', 'border-blue-500', 'text-gray-900', 'dark:text-white', 'font-semibold');
            commentsTab.classList.remove('text-gray-500', 'dark:text-gray-400', 'font-medium', 'border-transparent');

            likesTab.classList.add('text-gray-500', 'dark:text-gray-400', 'font-medium', 'border-transparent');
            likesTab.classList.remove('border-b-2', 'border-blue-500', 'text-gray-900', 'dark:text-white', 'font-semibold');

            commentsContent.classList.remove('hidden');
            likesContent.classList.add('hidden');
            if (commentInputSection) commentInputSection.classList.remove('hidden');
        } else {
            likesTab.classList.add('border-b-2', 'border-blue-500', 'text-gray-900', 'dark:text-white', 'font-semibold');
            likesTab.classList.remove('text-gray-500', 'dark:text-gray-400', 'font-medium', 'border-transparent');

            commentsTab.classList.add('text-gray-500', 'dark:text-gray-400', 'font-medium', 'border-transparent');
            commentsTab.classList.remove('border-b-2', 'border-blue-500', 'text-gray-900', 'dark:text-white', 'font-semibold');

            likesContent.classList.remove('hidden');
            commentsContent.classList.add('hidden');
            if (commentInputSection) commentInputSection.classList.add('hidden');
        }
    }
});