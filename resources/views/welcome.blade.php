@extends('layouts.default')
@section('style')
    <style>
        .modal.anouncement {
            border-radius: 7px;
            overflow: hidden;
            background-color: transparent;
        }

        .modal.anouncement a {
            color: #fff;
        }

        .modal.anouncement .modal-content {
            background-color: transparent;
            border: none;
            border-radius: 7px;
        }

        .modal.anouncement .modal-content .modal-body {
            border-radius: 7px;
            overflow: hidden;
            color: #fff;
            padding-left: 0px;
            padding-right: 0px;
            -webkit-box-shadow: 0 10px 50px -10px rgba(0, 0, 0, 0.9);
            box-shadow: 0 10px 50px -10px rgba(0, 0, 0, 0.9);
        }

        .modal.anouncement .modal-content .modal-body.overlayl {
            position: relative;
        }

        .modal.anouncement .modal-content .modal-body.overlayl:before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal.anouncement .modal-content .modal-body.overlayl .to-front {
            z-index: 2;
            position: relative;
        }

        .modal.anouncement .modal-content .modal-body h2 {
            font-size: 18px;
        }

        .modal.anouncement .modal-content .modal-body p {
            color: #fff;
        }

        .modal.anouncement .modal-content .modal-body h3 {
            color: #fff;
            font-size: 22px;
        }

        .modal.anouncement .modal-content .modal-body .line {
            border-bottom: 1px solid rgba(255, 255, 255, 0.62);
            padding-bottom: 10px;
        }

        .modal.anouncement .cancel a {
            color: rgba(255, 255, 255, 0.5);
            font-size: 13px;
            font-weight: bold;
        }

        .modal .anouncement .cancel a:hover {
            color: #fff;
        }

        .btn {
            border-radius: 4px;
            border: none;
        }

        .btn:active,
        .btn:focus {
            outline: none;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        .bg-image {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Carousel icon controls */
        #announcementModal .carousel-control-prev,
        #announcementModal .carousel-control-next {
            width: 45px;
            height: 45px;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        #announcementModal .carousel-control-prev:hover,
        #announcementModal .carousel-control-next:hover {
            background-color: rgba(0, 0, 0, 0.6);
            transform: translateY(-50%) scale(1.1);
        }

        #announcementModal .carousel-control-prev i,
        #announcementModal .carousel-control-next i {
            color: #fff;
            font-size: 20px;
            pointer-events: none;
            /* Ensures click goes to button */
        }
    </style>
@endsection
@section('content')
    <!--? slider Area Start-->
    <div class="slider-area position-relative">
        <div class="slider-active">
            <!-- Single Slider -->
            <div class="single-slider slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10">
                            <div class="hero__caption">
                                <span data-animation="fadeInLeft" data-delay=".1s">
                                    {{ $landing?->welcome_heading ?: 'Your Journey with God Starts Here – Join Us!' }}
                                </span>
                                <h1 data-animation="fadeInLeft" data-delay=".5s">
                                    {{ $landing?->welcome_bio ?: 'More Than a Church. A Family. A Calling.' }}
                                </h1>
                                <!-- Hero-btn -->
                                <div class="slider-btns">
                                    <!-- Social Icons -->
                                    <div class="social-icons-wrapper" data-animation="fadeInUp" data-delay="1.2s">
                                        <!-- <a href="https://wa.me/YOUR_NUMBER" target="_blank" class="social-icon whatsapp">
                                                                                                                                                                                                                                                                                                                                                                                                                                            <i class="fab fa-whatsapp"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                        </a> -->
                                        @if ($social?->twitter)
                                            <a href="{{ $social?->twitter ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon facebook">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if ($social?->facebook)
                                            <a href="{{ $social?->facebook ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if ($social?->instagram)
                                            <a href="{{ $social?->instagram ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if ($social?->linkedin)
                                            <a href="{{ $social?->linkedin ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon linkedin">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        @endif
                                        @if ($social?->youtube)
                                            <a href="{{ $social?->youtube ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon youtube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        @endif
                                        @if ($social?->tiktok)
                                            <a href="{{ $social?->tiktok ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon tiktok">
                                                <i class="fab fa-tiktok"></i>
                                            </a>
                                        @endif
                                    </div>
                                    @if ($social?->video_link)
                                        <a data-animation="fadeInRight" data-delay="1.0s" class="popup-video video-btn"
                                            href="{{ $social?->video_link ?: 'https://www.youtube.com/watch?v=CvYr4aFNHzM' }}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                        <p class="video-cap d-nonell d-sm-blcok" data-animation="fadeInRight"
                                            data-delay="1.0s">
                                            Watch <br> Video
                                        </p>
                                    @endif
                                    <!-- <a data-animation="fadeInLeft" data-delay="1.0s" href="industries.html"
                                                                                                                                                                                                                                                                                                                                                                                                                                        class="btn hero-btn rounded">Join Us
                                                                                                                                                                                                                                                                                                                                                                                                                                    </a> -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Single Slider -->
            <div class="single-slider slider-height d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-10 col-sm-10">
                            <div class="hero__caption">
                                <span data-animation="fadeInLeft" data-delay=".1s">
                                    No Perfect People Allowed. Just Real Faith.
                                </span>
                                <h1 data-animation="fadeInLeft" data-delay=".5s">
                                    Where Hearts Grow in Faith & Friendship.
                                </h1>
                                <!-- Hero-btn -->
                                <div class="slider-btns">
                                    <!-- Social Icons -->
                                    <div class="social-icons-wrapper" data-animation="fadeInUp" data-delay="1.2s">
                                        @if ($social?->twitter)
                                            <a href="{{ $social?->twitter ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon facebook">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                        @endif
                                        @if ($social?->facebook)
                                            <a href="{{ $social?->facebook ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        @endif
                                        @if ($social?->instagram)
                                            <a href="{{ $social?->instagram ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        @endif
                                        @if ($social?->linkedin)
                                            <a href="{{ $social?->linkedin ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon linkedin">
                                                <i class="fab fa-linkedin"></i>
                                            </a>
                                        @endif
                                        @if ($social?->youtube)
                                            <a href="{{ $social?->youtube ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon youtube">
                                                <i class="fab fa-youtube"></i>
                                            </a>
                                        @endif
                                        @if ($social?->tiktok)
                                            <a href="{{ $social?->tiktok ?: 'javascript:void(0)' }}" target="_blank"
                                                class="social-icon tiktok">
                                                <i class="fab fa-tiktok"></i>
                                            </a>
                                        @endif
                                    </div>
                                    @if ($social?->video_link)
                                        <a data-animation="fadeInRight" data-delay="1.0s" class="popup-video video-btn"
                                            href="{{ $social?->video_link ?: 'https://www.youtube.com/watch?v=CvYr4aFNHzM' }}">
                                            <i class="fas fa-play"></i>
                                        </a>
                                        <p class="video-cap d-nonell d-sm-blcok" data-animation="fadeInRight"
                                            data-delay="1.0s">
                                            Play <br> Video
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Counter Section Begin -->
        <div class="counter-section d-none d-sm-block">
            <div class="cd-timer" id="countdown"
                data-next-program="{{ $nextProgram ? $nextProgram->date . ' ' . $nextProgram->time : '' }}">
                <div class="cd-item">
                    <span>00</span>
                    <p>Days</p>
                </div>
                <div class="cd-item">
                    <span>00</span>
                    <p>Hrs</p>
                </div>
                <div class="cd-item">
                    <span>00</span>
                    <p>Min</p>
                </div>
                <div class="cd-item">
                    <span>00</span>
                    <p>Sec</p>
                </div>
            </div>
            <h5 class="cd-timer-name">
                @if ($nextProgram)
                    {{ $nextProgram->name }}
                @else
                    No upcoming program. Stay tuned!
                @endif
            </h5>
        </div>
        <!-- Counter Section End -->
    </div>
    <!-- slider Area End-->
    <!-- About Section -->
    <section id="call-to-action" class="call-to-action section">
        <div class="container" data-animation="fadeInLeft" data-delay=".1s">
            <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative">
                <div class="content-left" data-aos="fade-right" data-aos-delay="200">
                    <span class="badge text-uppercase mb-2">
                        {{ $landing?->about_heading ?: 'About Us' }}
                    </span>
                    <h2>
                        Cherubim & Seraphim Church Unification Campus Fellowship Lagos State
                        University Chapter Citizen of heaven
                    </h2>
                    <p class="mr-3">
                        {{ $landing?->about_info ?:
                            ' Rooted in love, truth, and purpose, we are a Christ-centered community on LASU main campus
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            committed to worship, growth, and fellowship.' }}
                    </p>
                    <p><span class="uppercase">Motto:</span> “Remember now your creator in the days of your youth.” Eccl.
                        12:1.</p>
                    <p>We belief in</p>
                    <div class="features d-flex flex-wrap mb-4">
                        <div class="feature-item m-2" title="God the Father, Son and Holy Spirit">
                            <i class="far fa-check-circle"></i>
                            <span>The Trinity</span>
                        </div>
                        <div class="feature-item m-2">
                            <i class="far fa-check-circle"></i>
                            <span>Salvation by Grace – Through faith in Jesus Christ </span>
                        </div>
                        <div class="feature-item m-2" title="Making disciples of all nations">
                            <i class="far fa-check-circle"></i>
                            <span>The Great Commission</span>
                        </div>
                        <div class="feature-item m-2">
                            <i class="far fa-check-circle"></i>
                            <span>Biblical Integrity – Scripture as our ultimate guide</span>
                        </div>
                    </div>

                    <a href="{{ route('aboutus') }}" class="btn btn-outline">Learn More</a>
                </div>

                <div class="content-right position-relative" data-aos="fade-left" data-aos-delay="300">
                    <img src="{{ $landing?->about_img ? $landing->about_img : asset('assets/img/hero/top4.jpg') }}"
                        loading="lazy" class="rounded border" width="150" alt="About Image" />
                    <div class="floating-card">
                        <div class="card-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="card-content">
                            <span class="stats-number">Founded</span>
                            <span class="stats-text" data-year="1987"></span>
                            <script>
                                (() => {
                                    const el = document.querySelector('.stats-text');
                                    if (!el) return;

                                    const year = +el.dataset.year;
                                    const age = new Date().getFullYear() - year;

                                    el.textContent = `January ${year}, '${age}'yrs.`;
                                })();
                            </script>
                        </div>
                    </div>
                </div>

                <div class="decoration">
                    <div class="circle-1"></div>
                    <div class="circle-2"></div>
                </div>

            </div>

        </div>

    </section>
    <!-- About Section -->
    <!--? Team Start -->
    <section class="team-area pt-180 pb-100 section-bg" data-background="assets/img/gallery/section_bg02.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <!-- Section Tittle -->
                    <div class="section-tittle section-tittle2 mb-50">
                        <h2>Meet Our Leaders.</h2>
                        <hr>
                        <p>
                            Our fellowship is guided by a team of passionate leaders who serve with humility and follow
                            Christ’s example. Leadership here isn’t about titles—it’s about helping others grow, building
                            community, and letting God lead. Whether you’re new or have been with us for a while, our
                            leaders are here to support, encourage, and inspire you in your spiritual journey.
                        </p>
                        <a href="{{ route('executives.index') }}" class="btn hero-btn mt-30">
                            Current
                            @if ($AdmYear?->year1)
                                {{ $AdmYear?->year1 ?: '----' }}
                            @endif
                            /
                            @if ($AdmYear?->year2)
                                {{ $AdmYear?->year2 ?: '----' }}
                            @endif
                            Executives
                        </a>
                    </div>
                </div>
                @foreach ($teams as $member)
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="single-team mb-30">
                            <div class="team-img">
                                @if ($member->image)
                                    <a href="{{ $member->image }}" class="img-pop-up">
                                        <div class="single-gallery-image"
                                            style="background-image: url('{{ $member->image }}');">
                                        </div>
                                    </a>
                                @else
                                    <div class="single-gallery-image"
                                        style="background: url('{{ asset('assets/img/gallery/no-image.jpg') }}');">
                                    </div>
                                @endif
                                <!-- Blog Social -->
                                <ul class="team-social">
                                    @if ($member->facebook)
                                        <li>
                                            <a href="{{ $member->facebook }}" target="_blank" title="View Profile 1">
                                                <i class="fa fa-globe"></i>
                                            </a>
                                        </li>
                                    @endif
                                    @if ($member->instagram)
                                        <li>
                                            <a href="{{ $member->instagram }}" target="_blank" title="View Profile 2">
                                                <i class="fa-solid fa-user"></i>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="team-caption">
                                <h3><a href="javascript:void(0)">{{ $member->name }}</a></h3>
                                <p>{{ $member->position }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="single-team mb-30">
                        <div class="team-img">
                            @if ($president)
                                @if ($president->image)
                                    <a href="{{ $president->image }}" class="img-pop-up">
                                        <div class="single-gallery-image"
                                            style="background-image: url('{{ $president->image }}');">
                                        </div>
                                    </a>
                                @else
                                    <div class="single-gallery-image"
                                        style="background: url('{{ asset('assets/img/gallery/no-image.jpg') }}');">
                                    </div>
                                @endif
                                <ul class="team-social">
                                    @if (!empty($president->instagram))
                                        <li><a href="{{ $president->instagram }}" target="_blank"><i
                                                    class="fa-solid fa-user"></i></a></li>
                                    @endif
                                </ul>
                            @else
                                <div class="single-gallery-image"
                                    style="background: url('{{ asset('assets/img/gallery/no-image.jpg') }}');">
                                </div>
                            @endif
                        </div>
                        <div class="team-caption">
                            @if ($president)
                                <h3><a href="javascript:void(0)">{{ $president->name }}</a></h3>
                                <p>Fellowship {{ $president->position }}</p>
                            @else
                                <h3><a href="javascript:void(0)">*******</a></h3>
                                <p>Fellowship President</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Team End -->
    <!--? Activities -->
    <section class="accordion fix section-padding30">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-6">
                    <!-- Section Tittle -->
                    <div class="section-tittle text-center mb-80">
                        <h2>Our Activities</h2>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="text-center mx-auto col-lg-">
                    <div class="properties__button mb-40">
                        <!--Nav Button  -->
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                                    role="tab" aria-controls="nav-home" aria-selected="true">
                                    Weekly
                                </a>
                            </div>
                        </nav>
                        <!--End Nav Button  -->
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <!-- Nav Card -->
            <div class="tab-content" id="nav-tabContent">
                <!-- card one -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="accordion-wrapper">
                                <div class="accordion" id="accordionExample">
                                    @if ($activities->isEmpty())
                                        <!-- Default single -->
                                        <div class="card">
                                            <div class="card-header" id="headingEmpty">
                                                <h2 class="mb-0">
                                                    <a href="javascript:void(0)" class="btn-link collapsed"
                                                        data-toggle="collapse" data-target="#collapseEmpty"
                                                        aria-expanded="false" aria-controls="collapseEmpty">
                                                        <span>It's Jesus O'Clock</span>
                                                        <p>Let's talk about Jesus Christ our Master</p>
                                                    </a>
                                                </h2>
                                            </div>
                                            <div id="collapseEmpty" class="collapse show" aria-labelledby="headingEmpty"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <b>Remember Jesus loves you!</b> <br>
                                                    For God so olove the world that he gave his only begotten son that
                                                    whosoever believes in him shouldn't perish but have an evalasting life.
                                                    "John 3: 16"
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($activities as $activity)
                                            @php $id = 'item'.$loop->index; @endphp
                                            <div class="card">
                                                <div class="card-header" id="heading{{ $id }}">
                                                    <h2 class="mb-0">
                                                        <a href="javascript:void(0)" class="btn-link collapsed"
                                                            data-toggle="collapse"
                                                            data-target="#collapse{{ $id }}"
                                                            aria-expanded="false"
                                                            aria-controls="collapse{{ $id }}">
                                                            <span>
                                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $activity->time1)->format('g:i A') }}
                                                                -
                                                                {{ \Carbon\Carbon::createFromFormat('H:i:s', $activity->time2)->format('g:i A') }}
                                                            </span>
                                                            <p>{{ $activity->day }}</p>
                                                        </a>
                                                    </h2>
                                                </div>

                                                <div id="collapse{{ $id }}" class="collapse"
                                                    aria-labelledby="heading{{ $id }}"
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <span>{{ $activity->title }}</span> <br>
                                                        {!! $activity->body !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Nav Card -->
        </div>
    </section>
    <!-- Activities End -->
    <!--? Program Start -->
    <section class="team-area pt-180 pb-100 section-bg" data-background="assets/img/gallery/section_bg02.png">
        <div class="container">
            <!-- Countdown Area Start -->
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <div class="section-tittle section-tittle2 mb-50">
                        <h2>Our Programs.</h2>
                        <hr>
                        <p> <strong>What Next?</strong> Mark your calendars for these exciting upcoming programs for these
                            Administration.
                            Don't miss out and RSVP to secure a space.
                        </p>
                        <a href="{{ route('programs.index') }}" class="btn hero-btn mt-30">
                            View All
                            @if ($AdmYear?->year1)
                                {{ $AdmYear?->year1 ?: '----' }}
                            @endif
                            /
                            @if ($AdmYear?->year2)
                                {{ $AdmYear?->year2 ?: '----' }}
                            @endif
                            Programs
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="countdown-carousel owl-carousel pb-30">
                        @if ($programs->isEmpty())
                            <!-- Placeholder Countdown -->
                            <div class="single-countdown text-center p-5" data-date="2024-07-13T09:00:00">
                                <h3>Stay Tuned!</h3>
                                <p>Our upcoming programs will be announced soon.</p>
                                <div class="cd-timer">
                                    <div class="cd-item"><span class="days">00</span>
                                        <p>Days</p>
                                    </div>
                                    <div class="cd-item"><span class="hours">00</span>
                                        <p>Hrs</p>
                                    </div>
                                    <div class="cd-item"><span class="minutes">00</span>
                                        <p>Min</p>
                                    </div>
                                    <div class="cd-item"><span class="seconds">00</span>
                                        <p>Sec</p>
                                    </div>
                                </div>
                                <i class="fa-solid fa-calendar-days fa-3x" style="color: #6c757d; margin-top: 10px;"></i>
                            </div>
                        @else
                            {{-- Real Programs --}}
                            @foreach ($programs as $program)
                                <div class="single-countdown" data-date="{{ $program->date }}T{{ $program->time }}">
                                    <h3>{{ $program->name }}</h3>
                                    <p>{{ $program->semester }}</p>
                                    <div class="cd-timer">
                                        <div class="cd-item"><span class="days">00</span>
                                            <p>Days</p>
                                        </div>
                                        <div class="cd-item"><span class="hours">00</span>
                                            <p>Hrs</p>
                                        </div>
                                        <div class="cd-item"><span class="minutes">00</span>
                                            <p>Min</p>
                                        </div>
                                        <div class="cd-item"><span class="seconds">00</span>
                                            <p>Sec</p>
                                        </div>
                                    </div>

                                    @if ($program->rsvp)
                                        <a href="{{ $program->rsvp }}" target="_blank" class="btn header-btn rounded">
                                            RSVP
                                        </a>
                                    @else
                                        <a class="btn header-btn rounded disable text-light" style="cursor: not-allowed">
                                            N/A
                                        </a>
                                    @endif

                                    <a href="javascript:void(0)" class="btn rounded calender-btn save-to-calendar"
                                        data-title="{{ $program->name }}"
                                        data-date="{{ $program->date }}T{{ $program->time }}" data-duration="120"
                                        data-description="{{ $program->details ?? '' }}"
                                        data-location="Church Main Hall">
                                        <i class="far fa-calendar-plus"></i> Add to Calendar
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <!-- Countdown Area End -->
        </div>
    </section>
    <!-- Program End -->
    <!--? Gallery Start -->
    <div class="gallery-area fix">
        <div class="container p-0">
            <div class="countdown-carousel owl-carousel pb-10">
                <!-- Image Slide -->
                @if ($galleryImages->count())
                    @foreach ($galleryImages as $img)
                        <div class="single-countdown">
                            <a href="{{ $img->image }}" href="javascript:void(0)" class="img-pop-up">
                                <img class="single-gallery-image img-thumbnail mx-auto d-block" loading="lazy"
                                    src="{{ $img->image }}" alt="Gallery_Image_for_{{ $img->short_bio }}">
                                @if ($img->short_bio)
                                    <h3 class="text-dark">{{ $img->short_bio }}</h3>
                                @endif
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="single-countdown">
                        <h3 class="text-dark">No images in the gallery yet.</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Gallery End -->
    <!-- Faq Section -->
    <section class="faq-9 faq pt-180 pb-100 section-bg" id="faq">
        <div class="container">
            <div class="row">
                <div class="col-lg-5" data-aos="fade-up">
                    <h2 class="faq-title">
                        Have a question? <br>
                        <span class="inner">Our Frequently Asked Questions (FAQ)</span>
                    </h2>
                    <hr>
                    <p class="faq-description">
                        Got questions? We’ve got answers! This section is here to help you understand everything about our
                        fellowship what we do, how to join, and what to expect.
                    </p>
                    <div class="faq-arrow d-none d-lg-block" data-aos="fade-up" data-aos-delay="200">
                        <svg class="faq-arrow" width="200" height="211" viewBox="0 0 200 211" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M198.804 194.488C189.279 189.596 179.529 185.52 169.407 182.07L169.384 182.049C169.227 181.994 169.07 181.939 168.912 181.884C166.669 181.139 165.906 184.546 167.669 185.615C174.053 189.473 182.761 191.837 189.146 195.695C156.603 195.912 119.781 196.591 91.266 179.049C62.5221 161.368 48.1094 130.695 56.934 98.891C84.5539 98.7247 112.556 84.0176 129.508 62.667C136.396 53.9724 146.193 35.1448 129.773 30.2717C114.292 25.6624 93.7109 41.8875 83.1971 51.3147C70.1109 63.039 59.63 78.433 54.2039 95.0087C52.1221 94.9842 50.0776 94.8683 48.0703 94.6608C30.1803 92.8027 11.2197 83.6338 5.44902 65.1074C-1.88449 41.5699 14.4994 19.0183 27.9202 1.56641C28.6411 0.625793 27.2862 -0.561638 26.5419 0.358501C13.4588 16.4098 -0.221091 34.5242 0.896608 56.5659C1.8218 74.6941 14.221 87.9401 30.4121 94.2058C37.7076 97.0203 45.3454 98.5003 53.0334 98.8449C47.8679 117.532 49.2961 137.487 60.7729 155.283C87.7615 197.081 139.616 201.147 184.786 201.155L174.332 206.827C172.119 208.033 174.345 211.287 176.537 210.105C182.06 207.125 187.582 204.122 193.084 201.144C193.346 201.147 195.161 199.887 195.423 199.868C197.08 198.548 193.084 201.144 195.528 199.81C196.688 199.192 197.846 198.552 199.006 197.935C200.397 197.167 200.007 195.087 198.804 194.488ZM60.8213 88.0427C67.6894 72.648 78.8538 59.1566 92.1207 49.0388C98.8475 43.9065 106.334 39.2953 114.188 36.1439C117.295 34.8947 120.798 33.6609 124.168 33.635C134.365 33.5511 136.354 42.9911 132.638 51.031C120.47 77.4222 86.8639 93.9837 58.0983 94.9666C58.8971 92.6666 59.783 90.3603 60.8213 88.0427Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="300">
                    <div class="faq-container">

                        @if ($faqs->isEmpty())
                            <div class="faq-item faq-active">
                                <h3>No Record available</h3>
                                <div class="faq-content">
                                    <p>
                                        Come back to view our faqs!
                                        <br>
                                        Meanwhile, do you know about Jesus? Our lord and Personal Saviour
                                    </p>
                                </div>
                                <i class="faq-toggle fa-solid fa-chevron-right"></i>
                            </div><!-- End Faq item-->
                        @else
                            @foreach ($faqs as $faq)
                                <div class="faq-item {{ $loop->first ? 'faq-active' : '' }}">
                                    <h3>{{ $faq->title }}</h3>
                                    <div class="faq-content">
                                        <p>
                                            {{-- Use this if you want plain text --}}
                                            {{ strip_tags(html_entity_decode($faq->body)) }}
                                            {{-- OR allow HTML (recommended for Quill editor) --}}
                                            {{-- {!! $faq->body !!} --}}
                                        </p>
                                    </div>

                                    <i class="faq-toggle fa-solid fa-chevron-right"></i>
                                </div><!-- End Faq item-->
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /Faq Section -->
    <!--? Donation Area Start-->
    <section class="work-company section-padding30" style="background: #2e0e8c;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12">
                    <!-- Section Tittle -->
                    <div class="section-tittle section-tittle2 mb-50">
                        <h2>Be a Kingdom Builder.</h2>
                        <hr>
                        <p>
                            Your giving makes a difference.
                            Every seed you sow helps us reach more students, grow spiritually, and carry out impactful
                            events on campus and beyond. From outreach to worship gatherings, your support empowers us to
                            live out God’s purpose together.
                            Join us in building a generation that shines for Christ. No gift is too small only a willing
                            heart.
                        </p>
                        <!-- Button to Open the Modal -->
                        <button type="button" class="btn hero-btn mt-30" data-toggle="modal" data-target="#myModal">
                            Sow a Seed
                        </button>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="countdown-carousel owl-carousel pb-30">
                        <!-- Countdown 1 -->
                        <div class="single-countdown">
                            <img class="img-thumbnail mx-auto d-block" src="/assets/img/gallery/support-1.jpg"
                                alt="" style="width:400px;height:400px;">
                        </div>
                        <!-- Countdown 2 -->
                        <div class="single-countdown">
                            <img class="img-thumbnail mx-auto d-block" src="/assets/img/gallery/support.jpg"
                                alt="" style="width:400px;height:400px;">
                        </div>
                        <!-- Countdown 3 -->
                        <div class="single-countdown">
                            <img class="img-thumbnail mx-auto d-block" src="/assets/img/gallery/support-2.jpg"
                                alt="" style="width:400px;height:400px;">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- Donation Area End-->
    <!-- Call To Action Newsletter Section -->
    <section id="call-to-action" class="call-to-action2 section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4 justify-content-between align-items-center">
                <div class="col-lg-6">
                    <div class="cta-content" data-aos="fade-up" data-aos-delay="200">
                        <h2>Newsletter</h2>
                        <p>Subscribe to our mailing list to receive updates and news about
                            upcoming fellowship activities. We’d love to grow in faith and community with you.</p>
                        <form class="php-email-form cta-form" data-aos="fade-up" data-aos-delay="300"
                            action="{{ route('subscribe') }}" method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="Enter your Email address..." aria-label="Email address"
                                    aria-describedby="button-subscribe" required minlength="3" maxlength="300">
                                <button class="btn btn-primary" type="submit" id="button-subscribe">Subscribe</button>
                            </div>
                        </form>
                        <div class="m-1">
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cta-image" data-aos="zoom-out" data-aos-delay="200">
                        <img src="assets/img/gallery/callout.png" alt="" class="img-fluid btn-sm">
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /Call To Action Newsletter Section End -->
    <!--? Fellowship Blog Spot -->
    <section class="home-blog-area section-padding30">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-6">
                    <!-- Section Tittle -->
                    <div class="section-tittle text-center mb-50">
                        <h2>Fellowship Journal</h2>
                        <hr>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="home-blog-single mb-30">
                        <div class="blog-img-cap h-100 d-flex flex-column">
                            <div class="blog-img position-relative" style="height: 350px; overflow: hidden;">
                                <img class="w-100 h-100 object-fit-cover" src="assets/img/blog/blog-2.jpg"
                                    alt="">
                                <!-- Blog date -->
                                <div class="blog-date text-center">
                                    <span> <i class="fa-solid fa-bell"></i></span>
                                    <p>Stay Updated!</p>
                                </div>
                            </div>
                            <div class="blog-cap">
                                <p>| In Case You Missed It</p>
                                <h3>
                                    <a href="{{ route('announcements.index') }}">
                                        Church announcement page for this every administration
                                    </a>
                                </h3>
                                <a href="{{ route('announcements.index') }}" class="more-btn">Read more »</a>
                                <!-- <a href="blog_details.html" class="more-btn float-right">Blog Page</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6">
                    <div class="home-blog-single mb-30">
                        <div class="blog-img-cap h-100 d-flex flex-column">
                            <div class="blog-img position-relative" style="height: 350px; overflow: hidden;">
                                <img class="w-100 h-100 object-fit-cover"
                                    src="{{ asset('assets/img/hero/past_cns.jpg') }}" alt="">
                                <!-- Blog date -->
                                <div class="blog-date text-center">
                                    <span><i class="fa-solid fa-users"></i></span>
                                    <p>Family Reunion</p>
                                </div>
                            </div>
                            <div class="blog-cap">
                                <p>| Leadership History</p>
                                <h3>
                                    <a href="{{ route('leaders.index') }}">
                                        Fellowship leaders: past & present
                                    </a>
                                </h3>
                                <a href="{{ route('leaders.index') }}" class="more-btn">Read more »</a>
                                {{-- <a href="blog_details.html" class="more-btn float-right">Blog Page</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fellowship Blog Spot End -->

    <!-- Show Latest 3 Announcements as Popup -->
    @php
        $announcements = \App\Models\Announcement::latest()->take(3)->get();
    @endphp

    @if ($announcements->count())
        <div class="modal anouncement fade" id="announcementModal" tabindex="-1" role="dialog"
            aria-labelledby="announcementModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body bg-image overlayl"
                        style="background-image: url('{{ asset('assets/img/blog/announcement.jpg') }}');">

                        <div class="line px-3 to-front">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="mx-auto">
                                    <h2 class="text-white m-0 uppercase">
                                        Quick Announcements
                                    </h2>
                                </div>
                                <div class="">
                                    <a href="javascript:void(0)" class="text-white" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <i class="fa-solid fa-circle-xmark fa-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 to-front">
                            <!-- Add carousel-fade for smooth transitions -->
                            <div id="announcementCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel"
                                data-bs-interval="6000">
                                <div class="carousel-inner">

                                    @foreach ($announcements as $key => $announcement)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <div class="text-center text-white">
                                                <h3 class="uppercase">
                                                    {{ Str::limit($announcement->title, 30, '...') }}
                                                </h3>
                                                <p class="mb-4"
                                                    style="white-space: pre-line; font-size:15px; line-height:1.6;">
                                                    {{ Str::limit(strip_tags(html_entity_decode($announcement->body)), 200, '...') }}
                                                </p>
                                                <p class="mb-0 cancel">
                                                    <a href="{{ route('announcements.show', $announcement->slug) }}"
                                                        class="text-light">
                                                        View Details
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Carousel controls -->
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#announcementCarousel" data-bs-slide="prev">
                                    <i class="fa-solid fa-chevron-left fa-lg text-white"></i>
                                    <!-- <span class="visually-hidden">Previous</span> -->
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#announcementCarousel" data-bs-slide="next">
                                    <i class="fa-solid fa-chevron-right fa-lg text-white"></i>
                                    <!-- <span class="visually-hidden">Next</span> -->
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            //################## Slider Background Image Changer
            const sliderArea = document.querySelector('.slider-area');

            const images = [
                '/assets/img/hero/hero4.png',
                @foreach ($images as $image)
                    '{{ $image }}',
                @endforeach
            ];

            let current = 0;
            let preloaded = {};

            function preloadImage(src) {
                if (!preloaded[src]) {
                    const img = new Image();
                    img.src = src;
                    preloaded[src] = true;
                }
            }

            function changeBackground() {
                const next = (current + 1) % images.length;
                const nextImage = images[next];

                preloadImage(nextImage);

                const temp = new Image();
                temp.src = nextImage;
                temp.onload = () => {
                    sliderArea.classList.remove('active');
                    setTimeout(() => {
                        sliderArea.style.backgroundImage = `url(${nextImage})`;
                        void sliderArea.offsetWidth; // restart animation
                        sliderArea.classList.add('active');
                        current = next;
                    }, 300);
                };
            }

            // Initial background
            sliderArea.style.backgroundImage = `url(${images[0]})`;
            sliderArea.classList.add('active');

            if (images.length > 1) preloadImage(images[1]);

            setInterval(changeBackground, 9000);
            //####################### Slider Background Image Changer End
            //############################################## Announcement PopUp
            const modal = new bootstrap.Modal(document.getElementById('announcementModal'));
            // modal.show();
            if (!localStorage.getItem('announcementShownToday')) {
                const modal = new bootstrap.Modal(document.getElementById('announcementModal'));
                modal.show();
                localStorage.setItem('announcementShownToday', new Date().toDateString());
            }
            // #################### Announcement PopUp END

            // Handle all calendar save links
            document.addEventListener('click', function(e) {
                if (e.target.closest('.save-to-calendar')) {
                    e.preventDefault();
                    const link = e.target.closest('.save-to-calendar');
                    addToCalendarDirectly(link);
                }
            });

            function addToCalendarDirectly(link) {
                const title = link.getAttribute('data-title');
                const dateStr = link.getAttribute('data-date');
                const duration = parseInt(link.getAttribute('data-duration')) || 120; // Default 2 hours
                const description = link.getAttribute('data-description') || '';
                const location = link.getAttribute('data-location') || '';

                try {
                    const startDate = new Date(dateStr);
                    const endDate = new Date(startDate.getTime() + duration * 60000);

                    // 1. First try the Web Calendar API (works on some mobile devices)
                    if (navigator.calendar && navigator.calendar.createEvent) {
                        navigator.calendar.createEvent({
                            title: title,
                            location: location,
                            description: description,
                            startDate: startDate,
                            endDate: endDate
                        });
                        showSavedFeedback(link);
                        return;
                    }

                    // 2. Try the MS Outlook protocol (works for Outlook desktop)
                    if (navigator.userAgent.includes('Windows')) {
                        const outlookUrl = generateOutlookUrl(title, startDate, endDate, description, location);
                        window.location.href = outlookUrl;
                        setTimeout(() => showSavedFeedback(link), 500);
                        return;
                    }

                    // 3. Try the Google Calendar web interface
                    const googleUrl = generateGoogleCalendarUrl(title, startDate, endDate, description, location);
                    window.open(googleUrl, '_blank');
                    showSavedFeedback(link);

                } catch (error) {
                    console.error('Error adding to calendar:', error);
                    // Fallback to manual .ics download if all else fails
                    downloadIcsFile(title, startDate, endDate, description, location);
                    showSavedFeedback(link);
                }
            }

            function generateGoogleCalendarUrl(title, startDate, endDate, description, location) {
                const format = (date) => date.toISOString().replace(/-|:|\.\d+/g, '');
                return `https://www.google.com/calendar/render?action=TEMPLATE` +
                    `&text=${encodeURIComponent(title)}` +
                    `&dates=${format(startDate)}/${format(endDate)}` +
                    `&details=${encodeURIComponent(description)}` +
                    `&location=${encodeURIComponent(location)}` +
                    `&sf=true&output=xml`;
            }

            function generateOutlookUrl(title, startDate, endDate, description, location) {
                const format = (date) => date.toISOString().replace(/-|:|\.\d+/g, '').slice(0, 15) + 'Z';
                return `outlookcal:${format(startDate)}/${format(endDate)}` +
                    `?subject=${encodeURIComponent(title)}` +
                    `&body=${encodeURIComponent(description)}` +
                    `&location=${encodeURIComponent(location)}`;
            }

            function downloadIcsFile(title, startDate, endDate, description, location) {
                const icsData = [
                    'BEGIN:VCALENDAR',
                    'VERSION:2.0',
                    'BEGIN:VEVENT',
                    `UID:${Date.now()}@yourdomain.com`,
                    `DTSTAMP:${new Date().toISOString().replace(/-|:|\.\d+/g, '')}`,
                    `DTSTART:${startDate.toISOString().replace(/-|:|\.\d+/g, '')}`,
                    `DTEND:${endDate.toISOString().replace(/-|:|\.\d+/g, '')}`,
                    `SUMMARY:${title}`,
                    `DESCRIPTION:${description.replace(/\n/g, '\\n')}`,
                    `LOCATION:${location}`,
                    'END:VEVENT',
                    'END:VCALENDAR'
                ].join('\r\n');

                // Create invisible iframe to handle the download
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                iframe.src = URL.createObjectURL(new Blob([icsData], {
                    type: 'text/calendar'
                }));
                document.body.appendChild(iframe);
                setTimeout(() => document.body.removeChild(iframe), 1000);
            }

            function showSavedFeedback(link) {
                const originalHTML = link.innerHTML;
                link.innerHTML = '<i class="fas fa-check"></i> Added!';
                link.style.pointerEvents = 'none';

                setTimeout(() => {
                    link.innerHTML = originalHTML;
                    link.style.pointerEvents = 'auto';
                }, 2000);
            }

        });

        $(document).ready(function() {
            // Initialize carousel
            $(".countdown-carousel").owlCarousel({
                items: 1,
                loop: true,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true
            });

            // Initialize all countdowns
            function initializeCountdowns() {
                $('.single-countdown').each(function() {
                    const countdownElement = $(this);
                    const endDate = new Date(countdownElement.data('date')).getTime();

                    // Update countdown immediately
                    updateCountdown(countdownElement, endDate);

                    // Set interval to update every second
                    setInterval(function() {
                        updateCountdown(countdownElement, endDate);
                    }, 1000);
                });
            }

            // Update a single countdown
            function updateCountdown(element, endDate) {
                const now = new Date().getTime();
                const distance = endDate - now;

                if (distance < 0) {
                    // Time's up!
                    element.find('.days').text('00');
                    element.find('.hours').text('00');
                    element.find('.minutes').text('00');
                    element.find('.seconds').text('00');
                    return;
                }

                // Calculate time units
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Update the display
                element.find('.days').text(days.toString().padStart(2, '0'));
                element.find('.hours').text(hours.toString().padStart(2, '0'));
                element.find('.minutes').text(minutes.toString().padStart(2, '0'));
                element.find('.seconds').text(seconds.toString().padStart(2, '0'));
            }

            // Start all countdowns
            initializeCountdowns();

            // Reinitialize countdowns when carousel changes (for visibility)
            $('.countdown-carousel').on('changed.owl.carousel', function() {
                initializeCountdowns();
            });

            //Calender Method

        });

        $(document).ready(function() {
            var $countdown = $("#countdown");
            if (!$countdown.length) return;
            var timerdate = $countdown.attr("data-next-program");
            if (!timerdate) {
                console.warn("Countdown date missing");
                return;
            }
            $countdown.countdown(timerdate, function(event) {
                $(this).html(
                    "<div class='cd-item'><span>" + event.strftime('%D') + "</span><p>Days</p></div>" +
                    "<div class='cd-item'><span>" + event.strftime('%H') + "</span><p>Hrs</p></div>" +
                    "<div class='cd-item'><span>" + event.strftime('%M') + "</span><p>Min</p></div>" +
                    "<div class='cd-item'><span>" + event.strftime('%S') + "</span><p>Sec</p></div>"
                );
            });
        });
    </script>
@endsection
