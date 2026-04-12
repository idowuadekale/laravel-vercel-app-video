@extends('layouts.default')
@section('title', 'Gallery - Lasu C&S Chapter')
@section('TopSectionName', 'View Collections')
@section('style')
    <style>

    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <!--? Gallery Start -->
    <section class="pricing-card-area section-padding services">
        <div class="container">
            <div class="section-top-borderp">
                <h5 class="mb-0 float-right sm-hide">
                    Captured Memories
                </h5>
                <h1>Pictorial Excerpt</h1>
                <hr>
            </div>
            <div class="row">
                @if ($galleries->isEmpty())
                    <h4 class="mx-auto d-block text-center">
                        No record found... Please check again later...
                    </h4>
                @else
                    @foreach ($galleries as $gallery)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-10">
                            <div class="single-card text-center mb-30 shadow">
                                <div class="card-top">
                                    <span>{{ \Carbon\Carbon::parse($gallery->date)->format('l, F jS Y') }}</span>
                                    <h4>{{ $gallery->name }}</h4>
                                </div>
                                <div class="card-bottom">
                                    <ul>
                                        <li>
                                            @if (!empty($gallery->live))
                                                <a href="{{ $gallery->live }}" class="text-success"
                                                    style="font-weight: 500;" target="_blank">
                                                    Watch Live Stream
                                                </a>
                                            @else
                                                <span>No live stream available</span>
                                            @endif
                                        </li>
                                        <!-- Not available -->
                                        <!-- <li>{{ $gallery->live ? $gallery->live : 'Live session unavailable.' }}</li> -->
                                    </ul>
                                    <a href="{{ $gallery->link }}" target="_blank" class="black-btn d-block">
                                        View <small>(Google Drive)</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="container">
                <nav class="blog-pagination justify-content-center d-flexo mt-4">
                    {{ $galleries->links('pagination::bootstrap-5') }}
                </nav>
            </div>

        </div>
        <!--================ Pagination Area =================-->
        @include('includes.pagination')
    </section>
    <!-- Gallery End -->

@endsection
@section('script')
    <script></script>
@endsection
