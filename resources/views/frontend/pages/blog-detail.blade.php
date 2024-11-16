@extends('frontend.layouts.main')

@section('contents')
    <div id="breadcrumb_part">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>Blog Detail</h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page">Blog Detail</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="blog_details">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-7">
                    <div class="main_blog">
                        <div class="main_blog_img">
                            <img src="{{ asset($blog->image) }}" alt="blog" class="img-fluid w-100">
                        </div>
                        <ul class="main_blog_header">
                            <li><a href="javascript:;"><i class="fal fa-calendar-alt"></i>
                                    {{ date('d M Y', strtotime($blog->created_at)) }}</a>
                            </li>
                            <li><a href="javascript:;"><i class="fal fa-comment-dots"></i> {{ $blog->comments_count }}
                                    Comment</a>
                            </li>
                            <li><a href="javascript:;"><i class="fal fa-eye"></i> {{ $blog->view }}</a></li>
                            <li><a href="javascript:;"><i class="fal fa-tags"></i> {{ $blog->topic->topic }} </a></li>
                        </ul>
                        <h4>{{ $blog->title }}</h4>
                        {!! $blog->content !!}
                        <div class="blog_comment_area">
                            <h5 class="wsus__single_comment_heading">Total Comment - {{ count($comments) }}</h5>
                            @if (count($comments) > 0)
                                @foreach ($comments as $comment)
                                    <div class="wsus__single_comment">
                                        <div class="wsus__single_comment_img" style="height: 70px;object-fit:cover;">
                                            <img src="{{ asset($comment->user->avatar) }}" alt="avatar"
                                                class="img-fluid w-100">
                                        </div>
                                        <div class="wsus__single_comment_text">
                                            <h5>{{ $comment->user->name }}</h5>
                                            <span>{{ date('d M Y', strtotime($comment->created_at)) }}</span>
                                            <p>{{ $comment->message }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div id="pagination" class="d-flex justify-content-center my-5">
                                    @if ($comments->hasPages())
                                        {{ $comments->links() }}
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-info my-4">
                                    <p>There are currently no comments on this blog</p>
                                </div>
                            @endif
                            @auth
                                <form action="{{ route('blog-comment') }}" method="POST" class="input_comment">
                                    @csrf
                                    <h5>Post your comment </h5>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="blog_single_input">
                                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                <textarea cols="3" rows="5" name="message" placeholder="Message..."></textarea>
                                                <button type="submit" class="read_btn">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endauth
                            @guest
                                <div class="alert alert-info">
                                    Please <a href="{{ route('login') }}">login</a> to comment this blog
                                </div>
                            @endguest
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="blog_sidebar">
                        <div class="sidebar_blog">
                            <h4 class="mb-3">Related Post</h4>
                            @foreach ($relatedBlogs as $relatedBlog)
                                <a href="{{ route('blog.detail', $relatedBlog->slug) }}" class="sidebar_blog_single">
                                    <div class="sidebar_blog_img">
                                        <img src="{{ asset($relatedBlog->image) }}" alt="blog" class="img-fluid w-100">
                                    </div>
                                    <div class="sidebar_blog_text">
                                        <h5>{{ cutString($relatedBlog->title, 20) }}</h5>
                                        <p> <span>{{ date('d M Y', strtotime($relatedBlog->created_at)) }} </span>
                                            {{ $relatedBlog->comments_count }} Comment
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
