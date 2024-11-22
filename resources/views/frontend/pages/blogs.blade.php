@extends('frontend.layouts.main')

@section('contents')
    <div id="breadcrumb_part" style="background: url({{ config('settings.bkg_blog') }})">
        <div class="bread_overlay">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-white">
                        <h4>Blog</h4>
                        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#"> Home </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> blog </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="blog_part">
        <div class="blog_part_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="blog_sidebar">
                            <div class="blog_search">
                                <form action="{{ route('blogs') }}" method="GET">
                                    <input type="text" name="search" placeholder="Find your blog">
                                    <button type="submit"><i class="far fa-search"></i></button>
                                </form>
                                <div class="blog_category">
                                    <div class="blog_category_header">
                                        <h4>Topics: </h4>
                                        <ul>
                                            @foreach ($topics as $topic)
                                                <li>
                                                    <a href="{{ route('blogs', ['topic' => $topic->slug]) }}">
                                                        {{ $topic->topic }}
                                                        -
                                                        <span>{{ $topic->blogs_count }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach ($blogs as $blog)
                        <div class="col-xl-4 col-sm-6 col-lg-6">
                            <div class="single_blog">
                                <div class="img">
                                    <img src="{{ asset($blog->image) }}" alt="image" class="img-fluid w-100">
                                </div>
                                <div class="text">
                                    <span><i class="fal fa-calendar-alt"></i>
                                        {{ date('d M Y', strtotime($blog->created_at)) }}</span>
                                    <span><i class="fas fa-user"></i> Author: {{ $blog->author->name }}</span>
                                    <a href="{{ route('blog.detail', $blog->slug) }}"
                                        class="title">{{ cutString($blog->title, 30) }}</a>
                                    <p>{{ cutString(strip_tags($blog->content), 101) }}</p>
                                    <a class="read_btn" href="{{ route('blog.detail', $blog->slug) }}">Read More
                                        <i class="far fa-chevron-double-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="pagination" class="d-flex justify-content-center">
                            <!-- $blogs->hasPages(): Kiểm tra xem có nhiều hơn 1 trang trong kq phân trang không. Nếu kq > 1 tức là có phân còn = 1 thì không phân -->
                            @if ($blogs->hasPages())
                                {{-- $blogs->links(): Phương thức này được gọi trên đối tượng phân trang ($blogs), để tạo ra các liên kết phân trang như "Previous", "Next", và các trang số. --}}
                                {{-- $blogs->withQueryString(): Phương thức này giúp giữ lại tất cả các tham số truy vấn (query parameters) hiện tại trong URL.
                                VD: blogs?search=fitness sau khi qua trang sẽ giữ giá trị và thêm page=2 (blogs?search=fitness&page=2) chứ không phải là (blogs?search=2) --}}
                                {{ $blogs->withQueryString()->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
