@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    @php
        /**
         * Recursively flatten all nested replies into one collection.
         *
         * @param \Illuminate\Support\Collection $replies
         * @return \Illuminate\Support\Collection
         */
        function flattenReplies($replies) {
            $flat = collect();
            foreach ($replies as $reply) {
                $flat->push($reply);
                if ($reply->replies->isNotEmpty()) {
                    $flat = $flat->merge(flattenReplies($reply->replies));
                }
            }
            return $flat;
        }
    @endphp

    <!-- START: Post Composer -->
    <div class="aces-postbox shadow-sm mb-3">
        <!-- Top Section: Avatar + Textarea -->
        <div class="aces-postbox-top">
            <a href="">
                <img class="aces-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="User Avatar">
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
                <button class="aces-dropdown-btn bg-light border border-solid py-2">
                    <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                </button>
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
            <!-- FEED ITEM -->
            <div class="aces-feed-item shadow-sm" data-news-feed-id="{{ __($newsfeed->id) }}">
                <!-- Post Header -->
                <div class="aces-feed-header">
                    <img class="aces-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="User Avatar"/>
                    <div class="aces-feed-userinfo">
                        <h6 class="aces-feed-username">
                            {{ __($newsfeed->newsfeedable?->name) }} •
                            <span class="fw-light">{{ $newsfeed->short_created_at }}</span>
                        </h6>
                        <small class="aces-feed-meta">{{ __($newsfeed->newsfeedable?->company_name) }}</small>
                    </div>
                    <div class="aces-dropdown ms-auto">
                        <button class="aces-dropdown-btn bg-light border border-solid py-2">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </button>
                        <div class="aces-dropdown-content">
                            <ul>
                                <li>Create a poll</li>
                                <li>Ask a question</li>
                                <li>Help</li>
                                <li>
                                    <a href="{{ route('merchant.news-feed.destroy', $newsfeed->id) }}" data-confirm-delete="true">
                                        {{ __('Delete News Feed') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Post Body -->
                <div class="aces-feed-body">
                    <p>{{ __($newsfeed->text) }}</p>
                </div>

                <!-- Reaction Bar -->
                <div class="aces-feed-actions">
                    <button class="aces-like-btn"
                            data-likes-store="{{ route('merchant.news-feed-like.store') }}"
                            data-news-feed-id="{{ __($newsfeed->id) }}"
                            data-like-csrf="{{ csrf_token() }}">
                        <i class="fa fa-thumbs-up"></i>
                        <span>{{ __('Liked (' . $newsfeed->likes->count() . ')') }}</span>
                    </button>
                    <button class="aces-comment-btn" data-news-feed-id="{{ __($newsfeed->id) }}">
                        <i class="fa fa-comment"></i>
                        <span>{{ __('Comments (' . $newsfeed->comments->count() . ')') }}</span>
                    </button>
                    <button class="aces-share-btn ms-auto">
                        <i class="fa fa-share"></i>
                        <span>{{ __('Share') }}</span>
                    </button>
                </div>

                <!-- Comment Section Container -->
                <div class="aces-feed-comments">
                    <!-- "Add a comment..." bar -->
                    <div class="aces-add-comment">
                        <img class="aces-add-comment-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="User Avatar"/>
                        <div class="aces-add-comment-input-wrapper"
                             data-news-feed-id="{{ __($newsfeed->id) }}"
                             data-news-feed-comment=""
                             data-action-store="{{ route('merchant.news-feed-comment.store') }}"
                             data-action-method="POST"
                             data-csrf="{{ csrf_token() }}">
                            <input type="text" class="aces-add-comment-input" placeholder="Add a comment..."/>
                            <button class="aces-add-comment-btn">
                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Top-level Comments --}}
                    @foreach($newsfeed->comments as $l => $comment)
                        <div class="aces-comment" data-comment-id="{{ $comment->id }}">
                            <div class="aces-comment-main">
                                <img class="aces-comment-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="{{ __($comment->actor?->name) }}"/>
                                <div class="aces-comment-content">
                                    <div class="aces-comment-content-highlight">
                                        <div class="aces-comment-header">
                                            <span class="aces-comment-author">{{ __($comment->actor?->name) }}</span>
                                            <span class="aces-comment-time">{{ __($comment->short_created_at) }}</span>
                                        </div>
                                        <div class="aces-comment-text">
                                            {{ __($comment->comment) }}
                                        </div>
                                    </div>
                                    <div class="aces-comment-actions">
                                        <span class="aces-comment-like">Like (3)</span>
                                        <span class="aces-comment-separator">•</span>
                                        <span class="aces-comment-reply">Reply</span>
                                    </div>
                                </div>
                            </div>
                            <div class="aces-replies">
                                @if($comment->replies->isNotEmpty())
                                    @foreach($comment->replies as $i => $reply1)
                                        <div class="aces-comment" data-comment-id="{{ $reply1->id }}">
                                            <div class="aces-comment-main">
                                                <img class="aces-comment-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="Comment Avatar" />
                                                <div class="aces-comment-content">
                                                    <div class="aces-comment-content-highlight">
                                                        <div class="aces-comment-header">
                                                            <span class="aces-comment-author">{{ __($reply1->actor?->name) }}</span>
                                                            <span class="aces-comment-time">{{ __($reply1->short_created_at) }}</span>
                                                        </div>
                                                        <div class="aces-comment-text">
                                                            {{ __($reply1->comment) }}
                                                        </div>
                                                    </div>
                                                    <div class="aces-comment-actions">
                                                        <span class="aces-comment-like">Like (5)</span>
                                                        <span class="aces-comment-separator">•</span>
                                                        <span class="aces-comment-reply">Reply</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="aces-replies">
                                                @if($reply1->replies->isNotEmpty())
                                                    @foreach($reply1->replies as $p => $reply2)
                                                        <div class="aces-comment" data-comment-id="{{ $reply2->id }}">
                                                            <div class="aces-comment-main">
                                                                <img class="aces-comment-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="Comment Avatar" />
                                                                <div class="aces-comment-content">
                                                                    <div class="aces-comment-content-highlight">
                                                                        <div class="aces-comment-header">
                                                                            <span class="aces-comment-author">{{ __($reply2->actor?->name) }}</span>
                                                                            <span class="aces-comment-time">{{ __($reply2->short_created_at) }}</span>
                                                                        </div>
                                                                        <div class="aces-comment-text">
                                                                            {{ __($reply2->comment) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="aces-comment-actions">
                                                                        <span class="aces-comment-like">Like (5)</span>
                                                                        <span class="aces-comment-separator">•</span>
                                                                        <span class="aces-comment-reply">Reply</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="aces-replies">
                                                                @php
                                                                    // Flatten all deeper replies (reply3, reply4, etc.) into one group.
                                                                    $flattenedReplies = flattenReplies($reply2->replies);
                                                                @endphp
                                                                @if($flattenedReplies->isNotEmpty())
                                                                    @foreach($flattenedReplies as $deepReply)
                                                                        <div class="aces-comment" data-comment-id="{{ $deepReply->id }}">
                                                                            <div class="aces-comment-main">
                                                                                <img class="aces-comment-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="Comment Avatar" />
                                                                                <div class="aces-comment-content">
                                                                                    <div class="aces-comment-content-highlight">
                                                                                        <div class="aces-comment-header">
                                                                                            <span class="aces-comment-author">{{ __($deepReply->actor?->name) }}</span>
                                                                                            <span class="aces-comment-time">{{ __($deepReply->short_created_at) }}</span>
                                                                                        </div>
                                                                                        <div class="aces-comment-text">
                                                                                            {{ __($deepReply->comment) }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="aces-comment-actions">
                                                                                        <span class="aces-comment-like">Like (5)</span>
                                                                                        <span class="aces-comment-separator">•</span>
                                                                                        <span class="aces-comment-reply">Reply</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="aces-replies">
                                                                                <!-- Empty container for new replies -->
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content aces-content" data-news-feed-store="{{ route('merchant.news-feed.store') }}" data-csrf="{{ csrf_token() }}">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create post</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="aces-postbox-top">
                        <a href="">
                            <img class="aces-avatar" src="{{ asset('assets/images/2.jpg') }}" alt="User Avatar">
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
