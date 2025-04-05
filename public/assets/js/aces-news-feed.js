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

    // Like toggle functionality
    $('.aces-like-btn').on('click', function(e) {
        e.preventDefault();

        var btn = $(this);
        var likesStore = btn.data('likes-store');      // URL for like action
        var newsFeedId = btn.data('news-feed-id');       // NewsFeed ID
        var csrfToken  = btn.data('like-csrf');          // CSRF token

        $.ajax({
            url: likesStore,
            type: 'POST',
            data: { newsfeed_id: newsFeedId },
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                if (response.success) {
                    // Update button text based on toggle state
                    if (response.liked) {
                        btn.find('span').text('Unlike (' + response.likes_count + ')');
                    } else {
                        btn.find('span').text('Like (' + response.likes_count + ')');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating like:', error);
            }
        });
    });

    // Post a new NewsFeed
    $('.aces-content button[type="submit"]').on('click', function(e){
        e.preventDefault();

        var $container = $(this).closest('.aces-content');
        var postUrl    = $container.data('news-feed-store'); // e.g., route('merchant.news-feed.store')
        var postCsrf   = $container.data('csrf');
        var newsfeedText = $container.find('textarea[name="newsfeed_text"]').val();
        var privacy      = $container.find('input[name="privacy"]').val();

        var postData = {
            newsfeed_text: newsfeedText,
            privacy: privacy
        };

        $.ajax({
            url: postUrl,
            type: 'POST',
            data: postData,
            headers: { 'X-CSRF-TOKEN': postCsrf },
            success: function(response) {
                $('#postModal').modal('hide');
                $container.find('textarea[name="newsfeed_text"]').val('');
                console.log('NewsFeed posted:', response.newsfeed);
                // Optionally, refresh the feed or append the new post.
            },
            error: function(xhr, status, error) {
                console.error('Error posting newsfeed:', error);
                alert('An error occurred while posting. Please try again.');
            }
        });
    });

    // Post a comment or reply
    $(document).on('click', '.aces-add-comment-btn', function(e){
        e.preventDefault();

        var $wrapper = $(this).closest('.aces-add-comment-input-wrapper');
        var newsFeedId  = $wrapper.data('news-feed-id');
        var actionStore = $wrapper.data('action-store');
        var actionMethod= $wrapper.data('action-method');
        var csrfToken   = $wrapper.data('csrf');
        var commentText = $wrapper.find('.aces-add-comment-input').val().trim();
        var parentId    = $wrapper.data('news-feed-comment');

        if(commentText === ''){
            return;
        }

        var postData = {
            newsfeed_id: newsFeedId,
            comment: commentText
        };

        if (parentId) {
            postData.parent_id = parentId;
        }

        $.ajax({
            url: actionStore,
            type: actionMethod,
            data: postData,
            headers: { 'X-CSRF-TOKEN': csrfToken },
            success: function(response) {
                if(response.success) {
                    $wrapper.find('.aces-add-comment-input').val('');
                    console.log('Comment submitted:', response.comment);
                    // Optionally update the UI to display the new comment.
                }
            },
            error: function(xhr, status, error) {
                console.error('Error submitting comment:', error);
                alert('Error submitting comment. Please try again.');
            }
        });
    });

    $(document).on('click', '.aces-comment-actions .aces-comment-reply', function(e) {
        e.preventDefault();

        // Get the clicked comment container and determine its depth
        var $currentComment = $(this).closest('.aces-comment');
        var depth = $currentComment.parents('.aces-comment').length + 1;

        // Determine the target container for appending the reply input.
        // If the current comment is at depth 4 (reply3), then append the reply input to the parent's container,
        // so the new reply will be a sibling (another reply3) under reply2.
        var $targetContainer;
        if (depth === 4) {
            // $currentComment is reply3; find its parent's replies container.
            $targetContainer = $currentComment.parent().closest('.aces-comment').children('.aces-replies').first();
        } else {
            // Otherwise, append directly to the current comment's replies container.
            $targetContainer = $currentComment.children('.aces-replies').first();
        }

        // Retrieve dynamic data: newsfeed ID, comment ID, action URL, and CSRF token.
        var newsfeedId = $(this).closest('.aces-feed-item').data('news-feed-id');
        var commentId = $currentComment.data('comment-id');
        // Get these values from the main "Add comment" bar, assuming they are consistent across the feed.
        var $mainWrapper = $(this).closest('.aces-feed-comments').find('.aces-add-comment-input-wrapper').first();
        var storeRoute = $mainWrapper.data('action-store');
        var csrfToken  = $mainWrapper.data('csrf');

        // Build the reply input markup.
        var replyMarkup =
            '<div class="aces-add-comment pt-0 appended-reply">' +
            '<img class="aces-add-comment-avatar" src="/assets/images/2.jpg" alt="User Avatar"/>' +
            '<div class="aces-add-comment-input-wrapper" ' +
            'data-news-feed-id="' + newsfeedId + '" ' +
            'data-news-feed-comment="' + commentId + '" ' +
            'data-action-store="' + storeRoute + '" ' +
            'data-action-method="POST" ' +
            'data-csrf="' + csrfToken + '">' +
            '<input type="text" class="aces-add-comment-input" placeholder="Add a comment..."/>' +
            '<button class="aces-add-comment-btn">' +
            '<i class="fa fa-paper-plane" aria-hidden="true"></i>' +
            '</button>' +
            '</div>' +
            '</div>';

        // Append the reply markup to the target container.
        $targetContainer.append(replyMarkup);
    });
});
