<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Messages
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-message">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b>
                            <p>Hello, Bro!</p>
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="assets/img/avatar/avatar-2.png" class="rounded-circle">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Dedik Sugiharto</b>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="assets/img/avatar/avatar-3.png" class="rounded-circle">
                            <div class="is-online"></div>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Agung Ardiansyah</b>
                            <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="assets/img/avatar/avatar-4.png" class="rounded-circle">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Ardian Rahardiansyah</b>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                            <div class="time">16 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-avatar">
                            <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle">
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Alfa Zulkarnain</b>
                            <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">Notifications
                    <div class="float-right">
                        <a href="#">Mark All As Read</a>
                    </div>
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-primary text-white">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Template update is available now!
                            <div class="time text-primary">2 Min Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>You</b> and <b>Dedik Sugiharto</b> are now friends
                            <div class="time">10 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-success text-white">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <b>Kusnaedi</b> has moved task <b>Fix bug header</b> to <b>Done</b>
                            <div class="time">12 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-danger text-white">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Low disk space. Let's clean it!
                            <div class="time">17 Hours Ago</div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-bell"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            Welcome to Stisla template!
                            <div class="time">Yesterday</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </li>
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" style="width:30px; height: 30px" src="{{ asset(auth()->user()->avatar) }}"
                    class="rounded-circle mr-2">
                <div class="d-sm-none d-lg-inline-block">{!! auth()->user()->name !!}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> Activities
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <div class="dropdown-divider"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </div>
        </li>
    </ul>
</nav>
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard.index') }}">Admin Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard.index') }}">AD</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Starter</li>

            <!-- Dashboard -->
            <li class="{{ setActiveRoute(['admin.dashboard.index']) }}">
                <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Sections -->
            <li
                class="dropdown {{ setActiveRoute(['admin.hero.*', 'admin.features.*', 'admin.statistical.*', 'admin.feedback.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-th-large"></i>
                    <span>Home Sections</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ setActiveRoute(['admin.hero-section.*']) }}">
                        <a class="nav-link" href="{{ route('admin.hero-section.index') }}">
                            <i class="fas fa-image"></i>
                            Hero
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.features.*']) }}">
                        <a class="nav-link" href="{{ route('admin.features.index') }}">
                            <i class="fas fa-layer-group"></i>
                            Features
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.statistical.*']) }}">
                        <a class="nav-link" href="{{ route('admin.statistical.index') }}">
                            <i class="fas fa-sort-numeric-up"></i>
                            Statistical
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.feedback.*']) }}">
                        <a class="nav-link" href="{{ route('admin.feedback.index') }}">
                            <i class="fas fa-comment-dots"></i>
                            Feedback
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Listing -->
            <li
                class="dropdown {{ setActiveRoute([
                    'admin.listing.*',
                    'admin.category.*',
                    'admin.location.*',
                    'admin.facility.*',
                    'admin.pending.*',
                    'admin.evaluate.*',
                    'admin.supports.*',
                ]) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-list"></i>
                    <span>Listing</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ setActiveRoute(['admin.listing.*']) }}">
                        <a class="nav-link" href="{{ route('admin.listing.index') }}">
                            <i class="fas fa-list-alt"></i>
                            All Listings
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.category.*']) }}">
                        <a class="nav-link" href="{{ route('admin.category.index') }}">
                            <i class="fas fa-tags"></i>
                            Category
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.location.*']) }}">
                        <a class="nav-link" href="{{ route('admin.location.index') }}">
                            <i class="fas fa-map-marker-alt"></i>
                            Location
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.facility.*']) }}">
                        <a class="nav-link" href="{{ route('admin.facility.index') }}">
                            <i class="fas fa-building"></i>
                            Facility
                        </a>
                    </li>

                    <li class="{{ setActiveRoute(['admin.pending.*']) }}">
                        <a class="nav-link" href="{{ route('admin.pending.index') }}">
                            <i class="fas fa-clock"></i>
                            Pending Listing
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.evaluate.*']) }}">
                        <a class="nav-link" href="{{ route('admin.evaluate.index') }}">
                            <i class="fas fa-star-half-alt"></i>
                            Evaluate
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.supports.*']) }}">
                        <a class="nav-link" href="{{ route('admin.supports.index') }}">
                            <i class="fas fa-headset"></i>
                            Supports
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Package -->
            <li class="dropdown {{ setActiveRoute(['admin.packages.*', 'admin.payment-settings.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-box"></i>
                    <span>Package</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ setActiveRoute(['admin.packages.*']) }}">
                        <a class="nav-link" href="{{ route('admin.packages.index') }}">
                            <i class="fas fa-box-open"></i>
                            All Packages
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.payment-settings.*']) }}">
                        <a class="nav-link" href="{{ route('admin.payment-settings.index') }}">
                            <i class="fas fa-credit-card"></i>
                            Payment
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Blog -->
            <li class="dropdown {{ setActiveRoute(['admin.blog.*', 'admin.blog-topic.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fab fa-blogger-b"></i>
                    <span>Blog</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ setActiveRoute(['admin.blog.*']) }}">
                        <a class="nav-link" href="{{ route('admin.blog.index') }}">
                            <i class="far fa-newspaper"></i>
                            Blogs
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.blog-topic.*']) }}">
                        <a class="nav-link" href="{{ route('admin.blog-topic.index') }}">
                            <i class="fas fa-tags"></i>
                            Topics
                        </a>
                    </li>
                    <li class="{{ setActiveRoute(['admin.blog-comment.*']) }}">
                        <a class="nav-link" href="{{ route('admin.blog-comment.index') }}">
                            <i class="fas fa-comment"></i>
                            Comment Status
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Pages -->
            <li class="dropdown {{ setActiveRoute(['admin.about-us.*']) }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-laptop"></i>
                    <span>Pages</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ setActiveRoute(['admin.about-us.*']) }}">
                        <a class="nav-link" href="{{ route('admin.about-us.index') }}">
                            <i class="fas fa-info-circle"></i>
                            About Us
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Order -->
            <li>
                <a class="nav-link" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Order</span>
                </a>
            </li>

            <!-- Message -->
            <li>
                <a class="nav-link" href="{{ route('admin.message.index') }}">
                    <i class="fas fa-envelope"></i>
                    <span>Message</span>
                </a>
            </li>

            <!-- Settings -->
            <li>
                <a class="nav-link" href="{{ route('admin.setting.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
