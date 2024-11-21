<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                    <i class="fas fa-search"></i>
                </a>
            </li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
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
            <!-- Dashboard -->
            <li class="{{ setActiveRoute(['admin.dashboard.index']) }}">
                <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Sections -->
            @canany(['home index', 'feedback index'])
                <li
                    class="dropdown {{ setActiveRoute(['admin.hero.*', 'admin.features.*', 'admin.statistical.*', 'admin.feedback.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-th-large"></i>
                        <span>Home Sections</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('home index')
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
                        @endcan
                        @can('feedback index')
                            <li class="{{ setActiveRoute(['admin.feedback.*']) }}">
                                <a class="nav-link" href="{{ route('admin.feedback.index') }}">
                                    <i class="fas fa-comment-dots"></i>
                                    Feedback
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- Listing -->
            @canany(['listing items index', 'listing index', 'pending listing update', 'evaluate listing update',
                'support listing index'])
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
                        @can('listing index')
                            <li class="{{ setActiveRoute(['admin.listing.*']) }}">
                                <a class="nav-link" href="{{ route('admin.listing.index') }}">
                                    <i class="fas fa-list-alt"></i>
                                    All Listings
                                </a>
                            </li>
                        @endcan

                        @can('listing items index')
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
                        @endcan

                        @can('pending listing update')
                            <li class="{{ setActiveRoute(['admin.pending.*']) }}">
                                <a class="nav-link" href="{{ route('admin.pending.index') }}">
                                    <i class="fas fa-clock"></i>
                                    Pending Listing
                                </a>
                            </li>
                        @endcan

                        @can('evaluate listing update')
                            <li class="{{ setActiveRoute(['admin.evaluate.*']) }}">
                                <a class="nav-link" href="{{ route('admin.evaluate.index') }}">
                                    <i class="fas fa-star-half-alt"></i>
                                    Evaluate
                                </a>
                            </li>
                        @endcan

                        @can('support listing index')
                            <li class="{{ setActiveRoute(['admin.supports.*']) }}">
                                <a class="nav-link" href="{{ route('admin.supports.index') }}">
                                    <i class="fas fa-headset"></i>
                                    Supports
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- Blog -->
            @canany(['blog index', 'comment blog index', 'topic index'])
                <li class="dropdown {{ setActiveRoute(['admin.blog.*', 'admin.blog-topic.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fab fa-blogger-b"></i>
                        <span>Blog</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('blog index')
                            <li class="{{ setActiveRoute(['admin.blog.*']) }}">
                                <a class="nav-link" href="{{ route('admin.blog.index') }}">
                                    <i class="far fa-newspaper"></i>
                                    Blogs
                                </a>
                            </li>
                        @endcan

                        @can('topic index')
                            <li class="{{ setActiveRoute(['admin.blog-topic.*']) }}">
                                <a class="nav-link" href="{{ route('admin.blog-topic.index') }}">
                                    <i class="fas fa-tags"></i>
                                    Topics
                                </a>
                            </li>
                        @endcan

                        @can('comment blog index')
                            <li class="{{ setActiveRoute(['admin.blog-comment.*']) }}">
                                <a class="nav-link" href="{{ route('admin.blog-comment.index') }}">
                                    <i class="fas fa-comment"></i>
                                    Comment Status
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            <!-- Pages -->
            @canany(['about update', 'contact update', 'privacy policy update', 'term update'])
                <li
                    class="dropdown {{ setActiveRoute(['admin.about-us.*', 'admin.contact-us.*', 'admin.privacy-policy.*', 'admin.terms-and-conditions.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-file-alt"></i>
                        <span>Pages</span>
                    </a>
                    @can('about update')
                        <ul class="dropdown-menu">
                            <li class="{{ setActiveRoute(['admin.about-us.*']) }}">
                                <a class="nav-link" href="{{ route('admin.about-us.index') }}">
                                    <i class="fas fa-users"></i>
                                    About Us
                                </a>
                            </li>
                        </ul>
                    @endcan

                    @can('contact update')
                        <ul class="dropdown-menu">
                            <li class="{{ setActiveRoute(['admin.contact-us.*']) }}">
                                <a class="nav-link" href="{{ route('admin.contact-us.index') }}">
                                    <i class="fas fa-envelope"></i>
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    @endcan

                    @can('privacy policy update')
                        <ul class="dropdown-menu">
                            <li class="{{ setActiveRoute(['admin.privacy-policy.*']) }}">
                                <a class="nav-link" href="{{ route('admin.privacy-policy.index') }}">
                                    <i class="fas fa-user-shield"></i>
                                    Privacy Policy
                                </a>
                            </li>
                        </ul>
                    @endcan

                    @can('term update')
                        <ul class="dropdown-menu">
                            <li class="{{ setActiveRoute(['admin.terms-and-conditions.*']) }}">
                                <a class="nav-link" href="{{ route('admin.terms-and-conditions.index') }}">
                                    <i class="fas fa-info-circle"></i>
                                    Terms&Conditions
                                </a>
                            </li>
                        </ul>
                    @endcan
                </li>
            @endcanany

            <!-- Permission -->
            @can('permission index')
                <li class="dropdown {{ setActiveRoute(['admin.user-role.*', 'admin.permission.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-key"></i>
                        <span>Permission</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="{{ setActiveRoute(['admin.permission.*']) }}">
                            <a class="nav-link" href="{{ route('admin.permission.index') }}">
                                <i class="fas fa-user-shield"></i>
                                User Permissions
                            </a>
                        </li>
                        <li class="{{ setActiveRoute(['admin.user-role.*']) }}">
                            <a class="nav-link" href="{{ route('admin.user-role.index') }}">
                                <i class="fas fa-users-cog"></i>
                                User Roles
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            <!-- Package -->
            @can('package index')
                <li>
                    <a class="nav-link" href="{{ route('admin.packages.index') }}">
                        <i class="fas fa-box-open"></i>
                        <span>Manage Packages</span>
                    </a>
                </li>
            @endcan

            <!-- Menu Builder -->
            @can('menu builder index')
                <li>
                    <a class="nav-link" href="{{ route('admin.menu-builder-section.index') }}">
                        <i class="fas fa-list-alt"></i>
                        <span>Menu Builder</span>
                    </a>
                </li>
            @endcan

            <!-- Order -->
            @can('order index')
                <li>
                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Order</span>
                    </a>
                </li>
            @endcan

            <!-- Message -->
            @can('message index')
                <li>
                    <a class="nav-link" href="{{ route('admin.message.index') }}">
                        <i class="fas fa-envelope"></i>
                        <span>Message</span>
                    </a>
                </li>
            @endcan

            <!-- Settings -->
            @canany(['general setting update', 'payment setting update'])
                <li class="dropdown {{ setActiveRoute(['admin.setting.*', 'admin.payment-settings.*']) }}">
                    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                        <i class="fas fa-cogs"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="dropdown-menu">
                        @can('general setting update')
                            <li class="{{ setActiveRoute(['admin.setting.*']) }}">
                                <a class="nav-link" href="{{ route('admin.setting.index') }}">
                                    <i class="fas fa-cog"></i>
                                    General Settings
                                </a>
                            </li>
                        @endcan

                        @can('payment setting update')
                            <li class="{{ setActiveRoute(['admin.payment-settings.*']) }}">
                                <a class="nav-link" href="{{ route('admin.payment-settings.index') }}">
                                    <i class="fas fa-credit-card"></i>
                                    Payment Settings
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
        </ul>
    </aside>
</div>
