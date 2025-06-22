$(document).ready(function() {
    // Toggle dropdown on "..." button click
    $('.aces-dropdown-btn').on('click', function(e) {
        e.stopPropagation(); // Prevent click event from bubbling
        $(this).siblings('.aces-dropdown-content').toggle();
    });

    // Hide dropdown when clicking anywhere outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.aces-dropdown').length) {
            $('.aces-dropdown-content').hide();
        }
    });

    // Auto-expand textarea as the user types
    $('.aces-textarea').each(function () {
        // Set initial height based on scroll height
        this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    }).on('input', function () {
        // Reset height
        this.style.height = 'auto';
        // Set new height
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Example: Toggle "Like" state on post's Like button
    $('.aces-like-btn').on('click', function(e) {
        e.preventDefault();

        var btn = $(this);
        var likesStore = btn.data('likes-store');         // URL for like action
        var newsFeedId = btn.data('news-feed-id');          // ID of the newsfeed item
        var csrfToken  = btn.data('like-csrf');          // ID of the newsfeed item

        $.ajax({
            url: likesStore,
            type: 'POST',
            data: { newsfeed_id: newsFeedId },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                /*var btnSelector = '.aces-like-btn[data-news-feed-id="' + newsFeedId + '"]';
                $(btnSelector).load(window.location.href + ' ' + btnSelector, function(){
                    console.log("Like button refreshed.");
                });*/
            },
            error: function(xhr, status, error) {
                console.error('Error updating like:', error);
            }
        });
    });

    // Example: Toggle "Liked(x)" on a comment
    $('.aces-comment-action').on('click', function() {
        // If the text is "Liked(2)", you could change it to "Unlike(2)" etc.
        // This is purely an example; customize as needed.
        if ($(this).text().includes('Liked')) {
            $(this).text($(this).text().replace('Liked', 'Unlike'));
        } else if ($(this).text().includes('Unlike')) {
            $(this).text($(this).text().replace('Unlike', 'Liked'));
        }
    });

    // When the textarea receives focus (or is clicked)
    $('.aces-textarea').on('focus click', function(){
        // Open the modal with id "postModal"
        $('#postModal').modal('show');
    });

    // Set default selection to "Public"
    $('.aces-dropdown2 .dropdown-toggle span.pe-1').text('Public');
    $('.aces-dropdown2 input[type="hidden"]').val('public');

    // Listen for click events on the dropdown items
    $('.aces-dropdown2 .dropdown-item').on('click', function(e) {
        e.preventDefault();
        // Retrieve the selected text and its data-button value
        var selectedText = $(this).text().trim();
        var dataValue = $(this).data('button');

        // Update the hidden input value
        $(this).closest('.aces-dropdown2').find('input[type="hidden"]').val(dataValue);

        // Update the button's <span class="pe-2"> content with the selected text
        $(this).closest('.aces-dropdown2').find('.dropdown-toggle span.pe-1').text(selectedText);
    });

    // When the submit button (type="submit") is clicked inside .aces-content
    $('.aces-content button[type="submit"]').on('click', function(e){
        e.preventDefault();

        var $container = $(this).closest('.aces-content');
        var postUrl = $container.data('news-feed-store');
        var postCsrf = $container.data('csrf');

        var newsfeedText = $container.find('textarea[name="newsfeed_text"]').val();
        var privacy = $container.find('input[name="privacy"]').val();

        var postData = {
            newsfeed_text: newsfeedText,
            privacy: privacy
        };

        $.ajax({
            url: postUrl,
            type: 'POST',
            data: postData,
            headers: {
                'X-CSRF-TOKEN': postCsrf
            },
            success: function(response) {
                $('#postModal').modal('hide');
                $container.find('textarea[name="newsfeed_text"]').val('');
                /*$('.aces-feed-list').load(window.location.href + ' .aces-feed-list > *');*/
            },
            error: function(xhr, status, error) {
                console.error('Error posting newsfeed:', error);
                alert('An error occurred while posting. Please try again.');
            }
        });
    });

    $('.aces-add-comment-btn').on('click', function(e){
        e.preventDefault();

        // Find the input wrapper that contains data attributes
        var $wrapper = $(this).closest('.aces-add-comment-input-wrapper');
        var newsFeedId = $wrapper.data('news-feed-id');
        var actionStore = $wrapper.data('action-store');
        var actionMethod = $wrapper.data('action-method');  // e.g., "POST"
        var csrfToken = $wrapper.data('csrf');
        var commentText = $wrapper.find('.aces-add-comment-input').val().trim();

        if(commentText === ''){
            return; // do nothing if input is empty
        }

        $.ajax({
            url: actionStore,
            type: actionMethod,
            data: {
                newsfeed_id: newsFeedId,
                comment: commentText
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                /*$wrapper.find('.aces-add-comment-input').val('');
                var btnSelector = '.aces-comment-btn[data-news-feed-id="' + newsFeedId + '"]';
                $(btnSelector).load(window.location.href + ' ' + btnSelector, function(){
                    /!*console.log("Like button refreshed.");*!/
                });
                $('.aces-feed-comments').load(window.location.href + ' .aces-feed-comments > *', function(){
                    $wrapper.find('.aces-add-comment-input').val('');
                });*/
            },
            error: function(xhr, status, error) {
                console.error('Error submitting comment:', error);
                alert('Error submitting comment. Please try again.');
            }
        });
    });
});
