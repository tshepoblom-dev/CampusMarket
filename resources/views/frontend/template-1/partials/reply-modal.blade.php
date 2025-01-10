<!-- Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="replyModalLabel">{{ translate('Leave A Reply') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('blog.comment') }}" method="POST">
                @csrf
                <input type="hidden" name="blog_id" value="{{ $blog_details->id }}">
                <input type="hidden" name="parent_id" id="parent_id" value="">
                <div class="modal-body">
                    <div class="comment-form mt-0">
                        <div class="row">
                            @if (Auth::guest())
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-inner">
                                        <input type="text" name="user_name"
                                            placeholder="{{ translate('Your Name') }} :" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-6">
                                    <div class="form-inner">
                                        <input type="email" name="user_email"
                                            placeholder="{{ translate('Your Email') }} :" required>
                                    </div>
                                </div>
                            @endif
                            <div class="col-12">
                                <div class="form-inner">
                                    <textarea name="comment" placeholder="{{ translate('Write Reply') }} :" rows="6" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ translate('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ translate('Reply') }}</button>
            </form>
        </div>
    </div>
</div>
</div>
