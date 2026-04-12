@extends('layouts.default')
@section('title', 'Announcements - Lasu C&S Chapter')
@section('TopSectionName', ' 📢' . $announcement->title)
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
                        @if ($announcement->image_url)
                            <img src="{{ $announcement->image_url }}" class="img-fluid" alt="Announcement Image"
                                loading="lazy">
                        @else
                            <img src="{{ asset('assets/img/blog/announcement.jpg') }}" alt="No Image" class="img-fluid"
                                loading="lazy">
                        @endif
                        <div class="image-caption">

                        </div>
                        <div class="image-caption">
                            <i class="fa fa-clock"></i> <strong>Published:</strong>
                            {{ $announcement->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="visit-content border">
                        <h3 class="uppercase pt-4">{{ $announcement->title }}</h3>
                        <hr class="p-0 m-0">
                        <div class="show-body">
                            {!! $announcement->body !!}
                        </div>
                        <ul class="d-flex visit-options">
                            <li class="m-2"><i class="far fa-calendar-plus"></i> <strong>Date:</strong>
                                {{ \Carbon\Carbon::parse($announcement->date)->format('l, F jS Y.') }} </li>
                            <li class="m-2"><i class="fa fa-bullhorn"></i> <strong>Tag:</strong>
                                {{ $announcement->tag ?? 'General' }} </li>
                        </ul>
                        <a href="{{ route('announcements.index') }}" class="btn btn-secondary mt-3">Back</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@section('script')
    <script></script>
@endsection
