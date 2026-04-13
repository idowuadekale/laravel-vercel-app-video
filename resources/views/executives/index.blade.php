@extends('layouts.default')
@section('title', 'Current Executives - Lasu C&S Chapter')
@section('TopSectionName', 'Ojo - Epe - Ikeja Executives')
@section('style')
    <style>
        .search-container {
            margin-bottom: 30px;
        }

        .search-form {
            display: flex;
            max-width: 500px;
            margin: 0 auto 30px;
            position: relative;
        }

        .search-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            padding-right: 40px;
        }

        .clear-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            display: none;
            font-size: 30px;
        }

        .clear-btn:hover {
            color: #666;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #666;
        }
    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <section class="team-area pt-100 pb-100">
        <div class="container">

            <!-- Search Form -->
            <form id="searchForm" class="search-form">
                <input type="text" id="searchInput" class="search-input" placeholder="Search executives..."
                    autocomplete="off">
                <button type="button" id="clearButton" class="clear-btn">×</button>
            </form>

            <!-- Executives Section -->
            <div class="row">
                <div class="col-12">
                    <span class="badge badge-dark text-uppercase mb-2 p-3">
                        Ojo Current
                        @if ($AdmYear?->year1)
                            {{ $AdmYear?->year1 ?: '----' }}
                        @endif
                        /
                        @if ($AdmYear?->year2)
                            {{ $AdmYear?->year2 ?: '----' }}
                        @endif
                        Executives
                    </span>
                    <hr>
                </div>
            </div>

            @if ($executives->isEmpty())
                <div class="no-results">
                    No Ojo executives record found existing...
                </div>
            @else
                <!-- Executives List -->
                <div class="row" id="executivesContainer">
                    @foreach ($executives as $executive)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-team mb-30">
                                <div class="team-img">
                                    @if ($executive->image)
                                        <a href="{{ $executive->image }}" href="javascript:void(0)" class="img-pop-up">
                                            <div class="single-gallery-image"
                                                style="background-image: url('{{ $executive->image }}');">
                                            </div>
                                        </a>
                                    @else
                                        <div class="single-gallery-image"
                                            style="background: url('{{ asset('assets/img/gallery/no-image.jpg') }}');">
                                        </div>
                                    @endif
                                    @if ($executive->instagram)
                                        <ul class="team-social">
                                            <li>
                                                <a href="{{ $executive->instagram }}" target="_blank"
                                                    title="View social handle">
                                                    <i class="fa-solid fa-user-tie"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    @endif
                                </div>
                                <div class="team-caption team-caption2">
                                    <h3><a href="{{ $executive->image }}" class="img-pop-up">{{ $executive->name }}</a></h3>
                                    <p>{{ $executive->position }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="container">
                        <nav class="blog-pagination justify-content-center d-flexo mt-4">
                            {{ $executives->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>

                </div>
            @endif

            <!-- Secretaries List -->
            <div class="row">
                <div class="col-12">
                    <span class="badge badge-dark text-uppercase mb-2 p-3">
                        Epe - Ikeja Current
                        @if ($AdmYear?->year1)
                            {{ $AdmYear?->year1 ?: '----' }}
                        @endif
                        /
                        @if ($AdmYear?->year2)
                            {{ $AdmYear?->year2 ?: '----' }}
                        @endif
                        Executives
                    </span>
                    <hr>
                </div>
            </div>
            @if ($secretaries->isEmpty())
                <div class="no-results">
                    No Epe / Ikeja executives record found existing...
                </div>
            @else
                <!-- Secretaries Section -->
                <div class="row" id="secretariesContainer">
                    @foreach ($secretaries as $secretary)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="single-team mb-30">
                                <div class="team-img">
                                    @if ($secretary->image)
                                        <a href="{{ $secretary->image }}" href="javascript:void(0)" class="img-pop-up">
                                            <div class="single-gallery-image"
                                                style="background-image: url('{{ $secretary->image }}');">
                                            </div>
                                        </a>
                                    @else
                                        <div class="single-gallery-image"
                                            style="background: url('{{ asset('assets/img/gallery/no-image.jpg') }}');">
                                        </div>
                                    @endif
                                    @if ($secretary->instagram)
                                        <ul class="team-social">
                                            <li>
                                                <a target="_blank" href="{{ $secretary->instagram }}"
                                                    title="View social handle">
                                                    <i class="fa-solid fa-user-tie"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    @endif
                                </div>
                                <div class="team-caption team-caption2">
                                    <h3><a href="{{ $secretary->image }}" class="img-pop-up">{{ $secretary->name }}</a>
                                    </h3>
                                    <p>{{ $secretary->position }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="container">
                        <nav class="blog-pagination justify-content-center d-flexo mt-4">
                            {{ $secretaries->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>

                </div>
            @endif

            <!--================ Pagination Area =================-->
            @include('includes.pagination')

        </div>
    </section>

@endsection
@section('script')
    <script></script>
@endsection
