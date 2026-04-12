<footer>
    <!-- Footer Start-->
    <div class="footer-area footer-padding">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                    <div class="single-footer-caption mb-50">
                        <div class="single-footer-caption mb-30">
                            <div class="footer-tittle">
                                <h4>About Us</h4>
                                <hr>
                                <div class="footer-pera" style="text-align: start;">
                                    <p>Cherubim & Seraphim Church Unification Campus Fellowship Lagos State
                                        University Chapter | Citizen of heaven</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $landings = \App\Models\LandingPage::first();
                @endphp
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Contact Info</h4>
                            <ul>
                                <li>
                                    <p>Address : {{ $landings?->address ?: 'Not Available' }}</p>
                                </li>
                                <li><a href="#">Phone : {{ $landings?->phone ?: 'Not Available' }}</a></li>
                                <li><a href="#">Email : {{ $landings?->email ?: 'Not Available' }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Important Link</h4>
                            <ul>
                                <li><a href="{{ route('aboutus') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                <li><a href="{{ route('announcements.index') }}">Announcement</a></li>
                                <li>
                                    <a href="{{ route('dashboard') }}">
                                        Administrator Login <i class="fas fa-user-shield"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-5">
                    <div class="single-footer-caption mb-50">
                        <div class="footer-tittle">
                            <h4>Newsletter</h4>
                            <div class="footer-pera footer-pera2">
                                <p>Subscribe to our mailing list to receive updates and news about
                                    upcoming fellowship activities.</p>
                            </div>
                            <!-- Form -->
                            <!-- <div class="footer-form">
                                <div id="mc_embed_signupl">
                                    <form action="{{ route('subscribe') }}" method="post"
                                        class="subscribe_form relativel mail_partl">
                                        @csrf
                                        <input type="email" name="email" id="newsletter-form-email"
                                            placeholder="Email Address" class="placeholder hide-on-focus"
                                            onfocus="this.placeholder = ''"
                                            onblur="this.placeholder = ' Email Address '">
                                        <div class="form-icon">
                                            <button type="submit" id="button-subscribe"
                                                class="email_icono newsletter-submito button-contactFormk"><img
                                                    src="assets/img/gallery/form.png" alt=""></button>
                                        </div>
                                        <div class="mt-10 info"></div>
                                    </form>
                                    <div class="m-1">
                                        @if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show">
                                            {{ session()->get('success') }}
                                        </div>
@endif
                                        @if (session('error'))
<div class="alert alert-danger alert-dismissible fade show">
                                            {{ session('error') }}
                                        </div>
@endif
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer-bottom area -->
    <div class="footer-bottom-area footer-bg">
        <div class="container">
            <div class="footer-border">
                <div class="row d-flex justify-content-betweenj align-items-center">
                    <div class="col-xl-6 col-lg-6">
                        <div class="footer-social f-left">
                            {{-- <a href="#"><i class="fab fa-twitter"></i></a> --}}
                            {{-- <a href="https://www.facebook.com/sai4ull"><i class="fab fa-facebook-f"></i></a> --}}
                            {{-- <a href="#"><i class="fas fa-globe"></i></a> --}}
                            {{-- <a href="#"><i class="fab fa-behance"></i></a> --}}
                            <a href="{{ route('dashboard') }}">Administrator Login <i
                                    class="fas fa-user-shield"></i></a>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 ">
                        <div class="footer-copy-right">
                            <p>
                                &copy;
                                <script>
                                    document.write(new Date().getFullYear());
                                </script> <strong>Lasu Chapter</strong> All rights reserved
                                <span>v1.0.0</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End-->
</footer>
