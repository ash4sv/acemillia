@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <!-- START: Post Composer -->
    <div class="aces-postbox shadow-sm mb-3">
        <!-- Top Section: Avatar + Textarea -->
        <div class="aces-postbox-top">
            <a href="">
                <img class="aces-avatar" src="{!! asset('assets/images/2.jpg') !!}" alt="User Avatar">
            </a>
            <textarea class="aces-textarea" placeholder="Share your thoughts..."></textarea>
        </div>
        <!-- Bottom Section: Action Buttons + Dropdown -->
        <div class="aces-postbox-bottom">
            <div class="aces-action bg-light border border-solid mb-md-0 mb-2">
                <i class="fa fa-image me-2 text-success"></i>
                <span>Photo</span>
            </div>
            <div class="aces-action bg-light border border-solid mb-md-0 mb-2">
                <i class="fa fa-video-camera me-2 text-info"></i>
                <span>Video</span>
            </div>
            <div class="aces-action bg-light border border-solid mb-md-0 mb-2">
                <i class="fa fa-calendar me-2 text-danger"></i>
                <span>Event</span>
            </div>
            <div class="aces-action bg-light border border-solid mb-md-0 mb-2">
                <i class="fa fa-smile-o me-2 text-warning"></i>
                <span>Feeling/Activity</span>
            </div>

            <!-- Dropdown -->
            <div class="aces-dropdown ms-md-auto ms-0 mb-md-0 mb-2">
                <button class="aces-dropdown-btn bg-light border border-solid py-2"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                <div class="aces-dropdown-content">
                    <ul>
                        <li>Create a poll</li>
                        <li>Ask a question</li>
                        <li>Help</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Post Composer -->

    <!-- Feed Container (Holds multiple feed items) -->
    <div class="aces-feed-list">
        @foreach($newsfeeds as $key => $newsfeed)
        <!-- FEED ITEM #1 (Merchant-like user: Name + Company + Time) -->
        <div class="aces-feed-item shadow-sm">
            <!-- Post Header -->
            <div class="aces-feed-header">
                <img class="aces-avatar" src="{!! asset('assets/images/2.jpg') !!}" alt="User Avatar"/>
                <div class="aces-feed-userinfo">
                    <h6 class="aces-feed-username">{!! __($newsfeed->newsfeedable?->name) !!} • <span class="fw-light">{!! $newsfeed->short_created_at !!}</span></h6>
                    <small class="aces-feed-meta">{!! __($newsfeed->newsfeedable?->company_name) !!}</small>
                </div>
                <div class="aces-dropdown ms-auto">
                    <button class="aces-dropdown-btn bg-light border border-solid py-2"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                    <div class="aces-dropdown-content">
                        <ul>
                            <li>Create a poll</li>
                            <li>Ask a question</li>
                            <li>Help</li>
                            <li>
                                <a href="{!! route('merchant.news-feed.destroy', $newsfeed->id) !!}" data-confirm-delete="true">{!! __('Delete News Feed') !!}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Post Body -->
            <div class="aces-feed-body">
                <p>{!! __($newsfeed->text) !!}</p>
                <img class="aces-feed-image" src="{!! asset('assets/images/01.jpg') !!}" alt="Post Image" />
            </div>

            <!-- Reaction Bar -->
            <div class="aces-feed-actions">
                <button class="aces-like-btn" data-likes-store="{!! route('merchant.news-feed-like.store') !!}" data-news-feed-id="{!! __($newsfeed->id) !!}" data-like-csrf="{!! csrf_token() !!}">
                    <i class="fa fa-thumbs-up"></i>
                    <span>{!! __( 'Liked ' . '(' . $newsfeed->likes->count() . ')') !!}</span>
                </button>
                <button class="aces-comment-btn" data-news-feed-id="{!! __($newsfeed->id) !!}">
                    <i class="fa fa-comment "></i>
                    <span>{!! __( 'Comments' . '(' . $newsfeed->comments->count() . ')') !!}</span>
                </button>
                <button class="aces-share-btn ms-auto">
                    <i class="fa fa-share"></i>
                    <span>{!! __('Share') !!}</span>
                </button>
            </div>

            <!-- Comment Section Container -->
            <div class="aces-feed-comments">

                <!-- 1) "Add a comment..." bar at the top -->
                <div class="aces-add-comment">
                    <img class="aces-add-comment-avatar" src="{!! asset('assets/images/2.jpg') !!}" alt="User Avatar"/>
                    <div class="aces-add-comment-input-wrapper"
                         data-news-feed-id="{!! __($newsfeed->id) !!}"
                         data-news-feed-comment=""
                         data-action-store="{!! route('merchant.news-feed-comment.store') !!}"
                         data-action-method="{!! __('POST') !!}"
                         data-csrf="{!! csrf_token() !!}">
                        <input type="text" class="aces-add-comment-input" placeholder="Add a comment..."/>
                        <button class="aces-add-comment-btn">
                            <i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>

                {{--<hr class="aces-divider" />--}}

                @foreach($newsfeed->comments as $key => $comment)
                <!-- 2) First Top-Level Comment (Frances) -->
                <div class="aces-comment">
                    <div class="aces-comment-main">
                        <!-- Avatar on the left -->
                        <img class="aces-comment-avatar" src="{!! asset('assets/images/2.jpg') !!}" alt="{!! __($comment->actor?->name) !!}" />
                        <!-- Comment Content to the right of the avatar -->
                        <div class="aces-comment-content">
                            <div class="aces-comment-content-highlight">
                                <!-- Name on left, time on right (same row) -->
                                <div class="aces-comment-header">
                                    <span class="aces-comment-author">{!! __($comment->actor?->name) !!}</span>
                                    <span class="aces-comment-time">5hr</span>
                                </div>
                                <!-- Comment text below -->
                                <div class="aces-comment-text">
                                    {!! __($comment->comment) !!}
                                </div>
                            </div>
                            <!-- Actions row: Like(x) • View x replies -->
                            <div class="aces-comment-actions">
                                <span class="aces-comment-like">Like (3)</span>
                                <span class="aces-comment-separator">•</span>
                                <span class="aces-comment-like">Reply</span>
                                <span class="aces-comment-separator">•</span>
                                <span class="aces-comment-view-replies">View 5 replies</span>
                            </div>
                        </div>
                    </div>

                    <!-- Nested Replies -->
                    <div class="aces-replies">
                        <!-- Replies comment -->
                        <div class="aces-add-comment pt-0">
                            <img class="aces-add-comment-avatar" src="{!! asset('assets/images/2.jpg') !!}" alt="User Avatar"/>
                            <div class="aces-add-comment-input-wrapper"
                                 data-news-feed-id="{!! __($newsfeed->id) !!}"
                                 data-news-feed-comment="{!! __($comment->id) !!}"
                                 data-action-store="{!! route('merchant.news-feed-comment.store') !!}"
                                 data-action-method="{!! __('POST') !!}"
                                 data-csrf="{!! csrf_token() !!}">
                                <input type="text" class="aces-add-comment-input" placeholder="Add a comment..."/>
                                <button class="aces-add-comment-btn">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Reply #1 (Lori) -->
                        <div class="aces-comment">
                            <div class="aces-comment-main">
                                <img class="aces-comment-avatar" src="http://acemillia.test/assets/images/2.jpg" alt="Comment Avatar" />
                                <div class="aces-comment-content">
                                    <div class="aces-comment-content-highlight">
                                        <div class="aces-comment-header">
                                            <span class="aces-comment-author">Lori Stevens</span>
                                            <span class="aces-comment-time">2hr</span>
                                        </div>
                                        <div class="aces-comment-text">
                                            See resolved goodness felicity shy civility domestic had. Drawings
                                            offended yet answered Jennings perceive.
                                        </div>
                                    </div>
                                    <div class="aces-comment-actions">
                                        <span class="aces-comment-like">Like (5)</span>
                                        <span class="aces-comment-separator">•</span>
                                        <span class="aces-comment-like">Reply</span>
                                    </div>
                                </div>
                            </div>
                            <div class="aces-replies">
                                <div class="aces-comment">
                                    <div class="aces-comment-main">
                                        <img class="aces-comment-avatar" src="http://acemillia.test/assets/images/2.jpg" alt="Comment Avatar" />
                                        <div class="aces-comment-content">
                                            <div class="aces-comment-content-highlight">
                                                <div class="aces-comment-header">
                                                    <span class="aces-comment-author">Lori Stevens</span>
                                                    <span class="aces-comment-time">2hr</span>
                                                </div>
                                                <div class="aces-comment-text">
                                                    See resolved goodness felicity shy civility domestic had. Drawings
                                                    offended yet answered Jennings perceive.
                                                </div>
                                            </div>
                                            <div class="aces-comment-actions">
                                                <span class="aces-comment-like">Like (5)</span>
                                                <span class="aces-comment-separator">•</span>
                                                <span class="aces-comment-like">Reply</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reply #2 (Billy) -->
                        <div class="aces-comment">
                            <div class="aces-comment-main">
                                <img class="aces-comment-avatar" src="http://acemillia.test/assets/images/2.jpg" alt="Comment Avatar"/>
                                <div class="aces-comment-content">
                                    <div class="aces-comment-content-highlight">
                                        <div class="aces-comment-header">
                                            <span class="aces-comment-author">Billy Vasquez</span>
                                            <span class="aces-comment-time">15min</span>
                                        </div>
                                        <div class="aces-comment-text">
                                            Wishing calling is warrant settled was lucky.
                                        </div>
                                    </div>
                                    <div class="aces-comment-actions">
                                        <span class="aces-comment-like">Like (0)</span>
                                        <span class="aces-comment-separator">•</span>
                                        <span class="aces-comment-like">Reply</span>
                                    </div>
                                </div>
                            </div>
                            <div class="aces-replies">
                                <div class="aces-comment">
                                    <div class="aces-comment-main">
                                        <img class="aces-comment-avatar" src="http://acemillia.test/assets/images/2.jpg" alt="Comment Avatar" />
                                        <div class="aces-comment-content">
                                            <div class="aces-comment-content-highlight">
                                                <div class="aces-comment-header">
                                                    <span class="aces-comment-author">Lori Stevens</span>
                                                    <span class="aces-comment-time">2hr</span>
                                                </div>
                                                <div class="aces-comment-text">
                                                    See resolved goodness felicity shy civility domestic had. Drawings
                                                    offended yet answered Jennings perceive.
                                                </div>
                                            </div>
                                            <div class="aces-comment-actions">
                                                <span class="aces-comment-like">Like (5)</span>
                                                <span class="aces-comment-separator">•</span>
                                                <span class="aces-comment-like">Reply</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- "Load more replies" -->
                        <div class="aces-load-replies">
                            <span class="aces-ellipsis"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
                            <span class="aces-load-replies-text">Load more replies</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- 3) Second Top-Level Comment (Frances) -->
                <div class="aces-comment">
                    <div class="aces-comment-main">
                        <img
                            class="aces-comment-avatar"
                            src="http://acemillia.test/assets/images/2.jpg"
                            alt="Comment Avatar"
                        />
                        <div class="aces-comment-content">
                            <div class="aces-comment-content-highlight">
                                <div class="aces-comment-header">
                                    <span class="aces-comment-author">Frances Guerrero</span>
                                    <span class="aces-comment-time">4min</span>
                                </div>
                                <div class="aces-comment-text">
                                    Removed demands expense account in outward tedious do. Particular way
                                    thoroughly unaffected projection.
                                </div>
                            </div>
                            <div class="aces-comment-actions">
                                <span class="aces-comment-like">Like (1)</span>
                                <span class="aces-comment-separator">•</span>
                                <span class="aces-comment-like">Reply</span>
                                <span class="aces-comment-separator">•</span>
                                <span class="aces-comment-view-replies">View 6 replies</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4) "Load more comments" -->
                <div class="aces-load-comments">
                    <span class="aces-ellipsis"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
                    <span class="aces-load-comments-text">Load more comments</span>
                </div>

            </div>
        </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content aces-content" data-news-feed-store="{!! route('merchant.news-feed.store') !!}" data-csrf="{!! csrf_token() !!}">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="">Create post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="aces-postbox-top">
                        <a href="">
                            <img class="aces-avatar" src="{!! asset('assets/images/2.jpg') !!}" alt="User Avatar">
                        </a>
                        <textarea name="newsfeed_text" class="aces-textarea" placeholder="Share your thoughts..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="dropdown aces-dropdown2 me-auto">
                        <button class="btn btn-primary btn-lg bg-white text-dark dropdown-toggle me-auto border border-solid rounded-1 px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="pe-1">Dropdown button</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" data-button="friends" href="#">Friends</a></li>
                            <li><a class="dropdown-item" data-button="private" href="#">Only me</a></li>
                            <li><a class="dropdown-item" data-button="public" href="#">Public</a></li>
                        </ul>
                        <input type="hidden" name="privacy" value="">
                    </div>

                    <button type="button" class="btn btn-secondary btn-lg rounded-1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-lg rounded-1">Post</button>
                </div>
            </div>
        </div>
    </div>

@endsection
