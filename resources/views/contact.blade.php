@extends('layouts.default')
@section('title', 'Contact Us - Lasu C&S Chapter')
@section('TopSectionName', 'Contact Us')
@section('style')
    <style>

    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <!-- ================ contact section start ================= -->
    <section class="contact-section">
        <div class="container">
            <div class="d-none d-sm-block mb-5 pb-4">
                <!-- Custom Map -->
                <div id="map" style="height: 480px;">
                    @if (!empty($landing->map))
                        <iframe width="100%" height="100%" style="border:0" loading="lazy" allowfullscreen
                            src="{{ $landing->map }}">
                        </iframe>
                    @else
                        <iframe width="100%" height="100%" style="border:0" loading="lazy" allowfullscreen
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.4356869097387!2d3.197725773503807!3d6.466360623827753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8696500590b1%3A0xf27b47e41fad6dab!2sLagos%20State%20University!5e0!3m2!1sen!2sng!4v1765370287969!5m2!1sen!2sng">
                        </iframe>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Get in Touch</h2>
                </div>
                <div class="col-lg-8">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form class="form-contact contact_form" action="{{ route('contact.send') }}" method="POST"
                        id="contactForm" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="name" id="name" type="text"
                                        placeholder="Enter your Fullname" minlength="3" maxlength="50" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="email" id="email" type="email" required
                                        placeholder="Enter your Email" autocomplete="on">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text" required
                                        placeholder="Enter your Subject" minlength="3" maxlength="50">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <textarea required class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                        placeholder="Enter Message"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="button button-contactForm boxed-btn">Send</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="fa-solid fa-location-dot"></i></span>
                        <div class="media-body">
                            <h3>Current Address.</h3>
                            <p>{{ $landing?->address ?: 'Not Available' }}</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="fa-solid fa-mobile-screen-button"></i></span>
                        <div class="media-body">
                            <h3>Contact Information.</h3>
                            <p>{{ $landing?->phone ?: 'Not Available' }}</p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="fa-solid fa-envelope"></i></span>
                        <div class="media-body">
                            <h3>Email Address</h3>
                            <p>{{ $landing?->email ?: 'Not Available' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ================ contact section end ================= -->


@endsection
@section('script')
    <script></script>
@endsection
