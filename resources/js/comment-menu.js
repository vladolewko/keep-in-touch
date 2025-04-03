document.addEventListener('DOMContentLoaded', function() {
    const commentsPopup = document.getElementById('comments-popup');
    const commentsTab = document.getElementById('comments-tab');
    const likesTab = document.getElementById('likes-tab');
    const commentsContent = document.getElementById('comments-content');
    const likesContent = document.getElementById('likes-content');
    const commentInputSection = document.getElementById('comment-input-section');
    const closePopupBtn = document.getElementById('close-popup');

    // Add click handlers to all "View all comments" triggers
    document.querySelectorAll('.comments-trigger').forEach(trigger => {
        trigger.addEventListener('click', function() {
            openPopup();
        });
    });

    // Close popup when clicking the close button
    closePopupBtn.addEventListener('click', closePopup);

    // Close popup when clicking outside of it
    commentsPopup.addEventListener('click', function(event) {
        if (event.target === commentsPopup) {
            closePopup();
        }
    });

    // Tab switching
    commentsTab.addEventListener('click', function() {
        switchTab('comments');
    });

    likesTab.addEventListener('click', function() {
        switchTab('likes');
    });

    function openPopup() {
        commentsPopup.classList.remove('hidden');
        document.body.classList.add('overflow-hidden'); // Prevent scrolling
    }

    function closePopup() {
        commentsPopup.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function switchTab(tab) {
        if (tab === 'comments') {
            commentsTab.classList.add('text-white', 'border-b-2', 'border-yellow-400');
            commentsTab.classList.remove('text-gray-400');
            likesTab.classList.add('text-gray-400');
            likesTab.classList.remove('text-white', 'border-b-2', 'border-yellow-400');

            commentsContent.classList.remove('hidden');
            likesContent.classList.add('hidden');
            commentInputSection.classList.remove('hidden');
        } else {
            likesTab.classList.add('text-white', 'border-b-2', 'border-yellow-400');
            likesTab.classList.remove('text-gray-400');
            commentsTab.classList.add('text-gray-400');
            commentsTab.classList.remove('text-white', 'border-b-2', 'border-yellow-400');

            likesContent.classList.remove('hidden');
            commentsContent.classList.add('hidden');
            commentInputSection.classList.add('hidden');
        }
    }
});
