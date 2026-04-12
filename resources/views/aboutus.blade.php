@extends('layouts.default')
@section('title', 'About Us - Lasu C&S Chapter')
@section('TopSectionName', 'About Us')
@section('style')
    <style>
        body {
            font-family: var(--default-font);
        }

        :root {
            /* --default-font: "Roboto", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"; */
            --default-font: Lora, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            --heading-font: "Raleway", sans-serif;
            --nav-font: "Poppins", sans-serif;
        }

        /* Global Colors - The following color variables are used throughout the website. Updating them here will change the color scheme of the entire website */
        :root {
            --background-color: #f1f5f7;
            /* Background color for the entire website, including individual sections */
            --default-color: #010608;
            /* Default color used for the majority of the text content across the entire website */
            --heading-color: #26264b;
            /* Color for headings, subheadings and title throughout the website */
            --accent-color: #04415f;
            /* Accent color that represents your brand on the website. It's used for buttons, links, and other elements that need to stand out */
            --surface-color: #ffffff;
            /* The surface color is used as a background of boxed elements within sections, such as cards, icon boxes, or other elements that require a visual separation from the global background. */
            --contrast-color: #ffffff;
            /* Contrast color for text, ensuring readability against backgrounds of accent, heading, or default colors. */
        }

        /*--------------------------------------------------------------
                                                                                                                    # About Section
                                                                                                                    --------------------------------------------------------------*/
        .about .about-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .about .about-content h3 {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .about .about-content p {
            margin-bottom: 30px;
        }

        .about .about-content .timeline {
            position: relative;
            margin-top: 40px;
            padding-left: 30px;
        }

        .about .about-content .timeline:before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background-color: color-mix(in srgb, var(--accent-color), transparent 70%);
        }

        .about .about-content .timeline .timeline-item {
            position: relative;
            margin-bottom: 30px;
        }

        .about .about-content .timeline .timeline-item:last-child {
            margin-bottom: 0;
        }

        .about .about-content .timeline .timeline-item .timeline-dot {
            position: absolute;
            left: -35px;
            top: 5px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background-color: var(--accent-color);
        }

        .about .about-content .timeline .timeline-item .timeline-content h4 {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: var(--heading-color);
        }

        .about .about-content .timeline .timeline-item .timeline-content p {
            margin-bottom: 0;
        }

        .about .about-image {
            position: relative;
        }

        .about .about-image img {
            width: 100%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .about .about-image .mission-vision {
            margin-top: 30px;
            display: block;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .about .about-image .mission-vision {
                grid-template-columns: 1fr;
            }
        }

        .about .about-image .mission-vision .mission,
        .about .about-image .mission-vision .vision {
            background-color: var(--surface-color);
            padding: 25px;
            margin-top: 5px;
            border-radius: 10px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }

        .about .about-image .mission-vision .mission h3,
        .about .about-image .mission-vision .vision h3 {
            font-size: 1.3rem;
            margin-bottom: 15px;
            font-weight: 600;
            position: relative;
            padding-left: 15px;
        }

        .about .about-image .mission-vision .mission h3:before,
        .about .about-image .mission-vision .vision h3:before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            width: 5px;
            height: 20px;
            background-color: var(--accent-color);
            border-radius: 3px;
        }

        .about .about-image .mission-vision .mission p,
        .about .about-image .mission-vision .vision p {
            margin-bottom: 0;
            font-size: 0.95rem;
            text-align: justify;
        }

        .page-section {
            margin-top: 5rem;
            margin-bottom: 5rem;
        }

        .cta {
            padding-top: 5rem;
            padding-bottom: 5rem;
            /* background-color: rgba(230, 167, 86, 0.9); */
            /* background-color: #331391; */
            background-color:
                color-mix(in srgb, #331391, transparent 90%);
            /* color: #331391; */
        }

        .cta .cta-inner {
            position: relative;
            padding: 3rem;
            margin: 0.5rem;
        }

        .cta .cta-inner:before {
            border-radius: 0.5rem;
            content: "";
            position: absolute;
            top: -0.5rem;
            bottom: -0.5rem;
            left: -0.5rem;
            right: -0.5rem;
            border: 0.25rem solid rgba(255, 255, 255, 0.85);
            z-index: -1;
        }

        .section-heading {
            text-transform: uppercase;
        }

        .section-heading .section-heading-upper {
            display: block;
            font-size: 1rem;
            font-weight: 800;
        }

        .section-heading .section-heading-lower {
            display: block;
            font-size: 3rem;
            font-weight: 100;
        }

        .bg-faded {
            /* background-color: #f6e1c5; */
            /* background-color: color-mix(in srgb, #331391, transparent 97%); */
            background: #fff;
        }
    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-content content-left" data-aos="fade-up" data-aos-delay="200">
                        <h3>Our Story</h3>
                        <h2>Welcome to Church</h2>
                        <p>
                            Cherubim and Seraphim Church Unification Campus
                            Fellowship, Lagos State University Chapter, citizen of heaven (LASU C&S) is a vibrant Christian
                            fellowship committed
                            to raising godly men and women who live out the values of Christ both within and beyond the
                            university community.
                        </p>
                        <p>
                            Founded in <b>1987</b>, LASU C&S has remained steadfast in its mandate for
                            <script>
                                document.write(new Date().getFullYear() - 1987)
                            </script> years of continuous spiritual growth, worship, discipleship, and
                            service
                            (1987–
                            <script>
                                document.write(new Date().getFullYear())
                            </script>). What began as a small
                            gathering of believers has grown into a strong spiritual family dedicated to transforming lives
                            through the Word of God, prayer, and practical Christian living.
                        </p>

                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot fas fa-circle"></div>
                                <div class="timeline-content">
                                    <h4>1987</h4>
                                    <p>
                                        LASU C&S was founded as a non-denominational Christian
                                        fellowship committed to worship, fellowship, and the teaching of God’s Word.
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-dot fas fa-circle"></div>
                                <div class="timeline-content">
                                    <h4>1990s</h4>
                                    <p>
                                        The fellowship became firmly established on campus, with regular prayer meetings,
                                        Bible studies, and Christian fellowship among students.
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-dot fas fa-circle"></div>
                                <div class="timeline-content">
                                    <h4>2000s</h4>
                                    <p>
                                        LASU C&S strengthened its focus on discipleship, evangelism, and leadership
                                        development, raising spiritually mature and responsible Christian leaders.
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-dot fas fa-circle"></div>
                                <div class="timeline-content">
                                    <h4>2010s</h4>
                                    <p>
                                        The fellowship expanded its impact through structured leadership, outreach programs,
                                        and sustained spiritual activities within the university community.
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-dot fas fa-circle"></div>
                                <div class="timeline-content">
                                    <h4>Till Date (
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script>)
                                    </h4>
                                    <p>
                                        Today, LASU C&S stands as a vibrant fellowship with decades of consistent worship,
                                        teaching, and service, continuing its mission of raising Christ-centered
                                        ambassadors.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6">
                    <div class="about-image" data-aos="zoom-in" data-aos-delay="300">
                        <img src="assets/img/hero/hero3.jpg" style="width: auto; height: 350px;" alt="Campus"
                            class="img-fluid rounded">

                        <div class="mission-vision" data-aos="fade-up" data-aos-delay="400">
                            <div class="mission">
                                <h3>Our Mission</h3>
                                <p>
                                    The mission statement of the Church shall be:To raise and nurture generations of
                                    Cherubim & Seraphim youths, especially students and graduatesof higher institutions of
                                    learning in Nigeria and overseas, to worship together in oneness of mind and purpose,
                                    spread the gospel of Jesus Christ, teach the fear of God, love of God and mankind, with
                                    the view of making them Christ-like.
                                </p>
                            </div>

                            <div class="vision mt-2">
                                <h3>Our Vision</h3>
                                <p>
                                    The vision statement of the Church shall be "That they all may be one, as You, Father,
                                    are in Me, and I in You...'' (John 17:21.)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="about-mid-img mx-auto">
                    <img loading="lazy" src="{{ asset('assets/img/gallery/jesus.jpg?v=2') }}" alt="Digital Platform"
                        class="img-fluid rounded-4 mx-auto d-block">
                </span>
            </div>

            <section class="page-section cta">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-9 mx-auto">
                            <div class="cta-inner bg-faded text-center rounded">
                                <h2 class="section-heading mb-4">
                                    <span class="section-heading-upper">OUR COVENANT SONG</span>
                                    <span class="section-heading-lower">C&S HYMN NO 803STANZA 3</span>
                                </h2>
                                <p class="d-flex mb-0">
                                    <!-- <div class=" mx-autop"> -->
                                    <pre class="justified-text">
                            Jo maje ki fitila egbe yi ku
                            jo mase je k' ota le ri gbe se
                            jo tun gbogbo ibaje inu re se
                            je ko gbile nu' fe oun' wa mimo
                            Wo Oba Sion o d' owo re
                            Nitori Jesu ma sai gbo ebe wa
                        </pre>
                                    <pre class="justified-text">
                            Quench not thy light forever in this order
                            Never allow the foes to draw us back
                            Remove the filthiness in every corner
                            Establish us forever and ever more
                            Thou God of Zion, oh! God of light
                            Let not the savour of Thy salt ever lost
                        </pre>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="col-lg-12">
                <div class="mt-5">
                    <blockquote class="generic-blockquote justified-text">
                        <b>THE TRINITY OF THE FATHER, THE SON AND THE HOLY
                            SPIRIT IN THE GOD HEAD:</b>
                        “We believe in the supremacy and sovereignty of God the
                        father. We recognize and accept that he created the heaven,
                        earth, and everything for his purpose (Deut. 6:4)
                        We believe that Jesus Christ is the only begotten son of God
                        who came into this world with humility and died for our sin;
                        through His death and resurrection, He gave us Salvation (1
                        Cor. 15:16-17). We believe that Christ is the word and life
                        from God (John 1) and in His second coming (1 Thess. 4:16-
                        17).
                        It is also our belief that the Holy Spirit is the third Trinity who
                        evolves from the father and the Son to comfort, direct and
                        empower man (John 14). We recognize and accept the
                        manifestation of Holy Spirit through the gifts of Hoy Spirit
                        such as wisdom, faith, healing, the working of miracles,
                        6 prophecy, discerning of spirit, diverse kinds of tongues and
                        interpretation of tongue etc. (1 Cor. 12:8-11), and also the
                        fruits of the Holy Spirit as Love, Joy, Peace, gentleness,
                        Longsuffering, goodness, faith, meekness and temperance:
                        (Gal 5:22-23).”
                    </blockquote>
                </div>
            </div>

            <!--================ Pagination Area =================-->
            @include('includes.pagination')
        </div>
    </section><!-- /About Section -->


@endsection
@section('script')
    <script></script>
@endsection
