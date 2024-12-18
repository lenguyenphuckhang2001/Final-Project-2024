<div class="dashboard_sidebar">
    <span class="close_icon"><i class="far fa-times"></i></span>
    <a href="#" class="dash_logo"><img src="{{ asset(auth()->user()->avatar) }}" alt="logo" class="img-fluid"></a>
    <a href="#" class="d-flex justify-content-center align-items-center mt-3">
        <p>{{ auth()->user()->email }}</p>
    </a>
    <ul class="dashboard_link">
        <li><a href="{{ route('user.dashboard') }}"><i class="fas fa-tachometer"></i>Dashboard</a></li>
        <li><a href="{{ route('user.profile.index') }}"><i class="far fa-user"></i> Profile</a></li>
        <li><a href="{{ route('user.listing.index') }}"><i class="fas fa-list-ul"></i> Listings</a></li>
        <li><a href="{{ route('user.listing.create') }}"><i class="fal fa-plus-circle">
                </i> Create New Listing
            </a>
        </li>
        <li><a href="{{ route('user.evaluate.index') }}"><i class="far fa-star"></i> Evaluate</a></li>
        <li><a href="dsahboard_wishlist.html"><i class="far fa-heart"></i> Wishlist</a></li>
        <li><a href="{{ route('user.order.index') }}"><i class="fal fa-notes-medical"></i> Orders</a></li>
        <li><a href="{{ route('user.messages.index') }}"><i class="far fa-comments-alt"></i> Message</a></li>
        <li>
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i
                        class="far fa-sign-out-alt"></i> Logout</a>
            </form>
        </li>
    </ul>
</div>
