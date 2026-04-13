@extends('layouts.default')
@section('title', 'Programs - Lasu C&S Chapter')
@section('TopSectionName', $program->name . ' 📍')
@section('style')
    <style>

    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <section id="announcements" class="announcements section">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row mt-5 campus-visit">
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="visit-image">
                        @if ($program->image)
                            <img src="{{ $program->image }}" class="img-fluid" alt="Program Image" loading="lazy">
                        @else
                            <img src="{{ asset('assets/img/gallery/no-image.jpg') }}" alt="No Image" class="img-fluid"
                                loading="lazy">
                        @endif
                        <div class="image-caption">
                            <i class="fa fa-clock"></i> <strong>Published:</strong>
                            {{ $program->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="visit-content border">
                        <h3 class="uppercase pt-4">{{ $program->name }}</h3>
                        <hr class="p-0 m-0">
                        <div class="show-body">
                            {!! $program->details !!}
                        </div>
                        <ul class="visit-options">
                            <span class="d-flex">
                                <li class="m-2"><i class="fa fa-bank"></i>
                                    <strong>Period:</strong> {{ $program->semester }}
                                </li>
                                <li class="m-2"><i class="fa fa-clock"></i>
                                    <strong>Time:</strong>
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $program->time)->format('g:i A') }}
                                </li>
                            </span>
                            <li class="m-2"><i class="far fa-calendar-plus"></i>
                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($program->date)->format('l, F jS Y.') }}
                            </li>
                        </ul>

                        @if ($program->rsvp)
                            <a href="{{ $program->rsvp }}" target="_blank" class="btn btn-secondary mt-3"
                                style="padding: 25px; width: 30%;">RSVP</a>
                        @endif

                        <a href="{{ route('programs.index') }}" class="btn btn-secondary mt-3">Back</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@section('script')
    <script></script>
@endsection
