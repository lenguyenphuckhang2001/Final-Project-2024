<section id="wsus__banner" style="background: url({{ asset(@$hero->background) }})">
    <div class="wsus__banner_overlay">
        <div class="container">

            <div class="row">
                <div class="col-xl-12 col-md-12">
                    <div class="wsus__banner_text">
                        <h1>{!! @$hero->title !!}</h1>
                        <p>{!! @$hero->sub_title !!}</p>
                    </div>
                </div>
                <div class="col-xl-12 col-md-12 mt-5">
                    <form action="{{ route('listings') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="wsus__search_area">
                                    <input type="text" name="search" placeholder="What we are looking for?">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="wsus__search_area">
                                    <select class="select_2" name="category">
                                        <option value="">Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="wsus__search_area">
                                    <select class="select_2" name="location">
                                        <option value="">Location</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->slug }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="wsus__search_area m-0">
                                    <button type="submit" class="read_btn">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
