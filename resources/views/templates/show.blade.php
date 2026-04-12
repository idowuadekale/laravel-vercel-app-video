@extends('layouts.default')
@section('title', 'Newsletters - Lasu C&S Chapter')
@section('TopSectionName', ' 📭' . $template->subject)
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
                        @if ($template->image_url)
                            <img src="{{ $template->image_url }}" class="img-fluid" alt="Template Image" loading="lazy">
                        @else
                            <img src="{{ asset('assets/img/blog/announcement.jpg') }}" alt="No Image" class="img-fluid"
                                loading="lazy">
                        @endif
                        <div class="image-caption">

                        </div>
                        <div class="image-caption">
                            <i class="fa fa-clock"></i> <strong>Published:</strong>
                            {{ $template->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="visit-content border">
                        <h3 class="uppercase pt-4">{{ $template->subject }}</h3>
                        <hr class="p-0 m-0">
                        <div class="show-body">
                            {!! $template->content !!}
                        </div>
                        <ul class="d-flex visit-options">
                            <li class="m-2"><i class="far fa-calendar-plus"></i> <strong>Last Updated:</strong>
                                {{ \Carbon\Carbon::parse($template->updated_at)->format('l, F jS Y.') }}
                            </li>
                            <li class="m-2"><i class="fas fa-file-image"></i> <strong>Flyer:</strong>
                                @if ($template->image)
                                    <a href="{{ asset('storage/' . $template->image) }}" class="text-muted" target="_blank">
                                        View Image
                                    </a>
                                @else
                                    N/A
                                @endif
                            </li>
                        </ul>
                        <a href="{{ route('templates.index') }}" class="btn btn-secondary mt-3">Back</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
@section('script')
    <script></script>
@endsection
