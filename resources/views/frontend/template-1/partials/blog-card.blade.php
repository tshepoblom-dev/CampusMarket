<div class="single-blog-style1 wow fadeInDown" data-wow-duration="1.5s" data-wow-delay="{{ ($key + 1) * 0.2 }}s">
    <div class="blog-img">
        <a href="{{ url('blog/' . $blog->slug) }}" class="blog-date"><i
                class="bi bi-calendar-check"></i>{{ date('F d, Y', strtotime($blog->created_at)) }}</a>
        <img alt="image" src="{{ asset('uploads/blog/' . $blog->image) }}">
    </div>
    <div class="blog-content">
        <h5><a href="{{ url('blog/' . $blog->slug) }}">{{ $blog->getTranslation('title') }}</a></h5>
        <div class="blog-meta">
            <div class="author">
                @if ($blog->users->image)
                    <img alt="image" src="{{ asset('uploads/users/' . $blog->users->image) }}">
                @else
                    <img alt="image" src="{{ asset('uploads/users/user.png') }}">
                @endif
                <a href="{{ url('blog/' . $blog->slug) }}" class="author-name">{{ $blog->users->username }}</a>
            </div>
            <div class="comment">
                <img alt="image" src="{{ asset('frontend/images/icons/comment-icon.svg') }}">
                <a href="#"
                    class="comment">{{ $blog->comments->count() < 9 ? '0' . $blog->comments->count() : $blog->comments->count() }}
                    {{ $blog->comments->count() > 1 ? 'Comments' : 'Comment' }}</a>
            </div>
        </div>
    </div>
</div>
