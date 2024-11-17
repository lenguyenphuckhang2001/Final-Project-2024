<!-----------Top Bar---------->
<section id="wsus__topbar">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-md-7 d-none d-md-block">
                <ul class="wsus__topbar_left">
                    <li><a href="mailto:lenguyenphuckhang0604@gmail.com"><i class="fal fa-envelope"></i>
                            lenguyenphuckhang@gmail.com</a></li>
                    <li><a href="callto:+6958474522655"><i class="fal fa-phone-alt"></i>+6958474522655</a></li>
                </ul>
            </div>
            <div class="col-xl-6 col-md-5">
                <div class="wsus__topbar_right">
                    <a href="{{ route('login') }}"><i class="fas fa-user"></i> Login</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-----------Menu---------->
<nav class="navbar navbar-expand-lg main_menu">
    <div class="container">
        <a class="navbar-brand" href="index.html">
            <img src="" alt="DB.Card">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="far fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about-us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('listings') }}">Listing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">pages <i class="far fa-chevron-down"></i></a>
                    <ul class="menu_droapdown">
                        <li><a href="list_category.html">list category</a></li>
                        <li><a href="dsahboard.html">dashboard</a></li>
                        <li><a href="agent_public_profile.html">agent profile</a></li>
                        <li><a href="payment_page.html">Payment Page</a></li>
                        <li><a href="privacy_policy.html">Privacy Policy</a></li>
                        <li><a href="terms_conditions.html">Terms Conditions</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blogs') }}">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact-us') }}">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
