<header>
    <!--? Header Start -->
    <div class="header-area">
        <div class="main-header header-sticky">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-2 col-lg-2 col-md-1">
                        <div class="logo">
                            <a href="{{ route('welcome') }}">
                                <img src="{{ asset('assets/img/logo/lasu_cns_logo.png') }}" alt="lasu_cns_logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10">
                        <div class="menu-main d-flex align-items-center justify-content-end">
                            <!-- Main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="{{ route('welcome') }}">Home</a></li>
                                        <li><a href="{{ route('aboutus') }}">About Us</a></li>
                                        <li><a href="#">
                                                Explore <i class="fa-solid fa-chevron-down btn-sm"></i></i>
                                            </a>
                                            <ul class="submenu">
                                                <li><a href="{{ route('announcements.index') }}">Announcement</a></li>
                                                <li><a href="{{ route('executives.index') }}">Executives</a></li>
                                                <li><a href="{{ route('galleries.index') }}">Gallery</a></li>
                                                <li><a href="{{ route('programs.index') }}">Programs</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="{{ route('contact') }}">Contact</a></li>
                                        @auth
                                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                        @endauth
                                    </ul>
                                </nav>
                            </div>
                            <div class="header-right-btn f-right d-none d-lg-block ml-30">
                                <button class="btn header-btn rounded" data-toggle="modal" data-target="#myModal">
                                    Support the Fellowship
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>
