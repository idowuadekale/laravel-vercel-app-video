@extends('layouts.default')
@section('title', 'Fellowship Past & Present Leaders - Lasu C&S Chapter')
@section('TopSectionName', 'Fellowship Past & Present Leaders')
@section('style')
    <style>
        .blog_area .alumni-card {
            background-color: var(--surface-color);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .blog_area .alumni-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .blog_area .alumni-card .alumni-image {
            height: 280px;
            overflow: hidden;
            box-shadow: none;
        }

        .blog_area .alumni-card .alumni-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .blog_area .alumni-card .alumni-content {
            padding: 1.5rem;
        }

        .blog_area .alumni-card .alumni-content h4 {
            margin-bottom: 0.25rem;
            color: var(--heading-color);
        }

        .blog_area .alumni-card .alumni-content .alumni-class {
            color: var(--accent-color);
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .blog_area .alumni-card .alumni-content .alumni-position {
            font-weight: 500;
            margin-bottom: 1rem;
            font-style: italic;
        }

        .blog_area .alumni-card .alumni-content p {
            margin-bottom: 1.25rem;
            font-size: 0.95rem;
        }

        .blog_area .alumni-card .alumni-content .read-more {
            font-weight: 600;
            color: var(--accent-color);
            display: inline-flex;
            align-items: center;
        }

        .blog_area .alumni-card .alumni-content .read-more i {
            margin-left: 0.25rem;
            transition: transform 0.3s ease;
        }

        .blog_area .alumni-card .alumni-content .read-more:hover {
            color: color-mix(in srgb, var(--accent-color), transparent 25%);
        }

        .blog_area .alumni-card .alumni-content .read-more:hover i {
            transform: translateX(4px);
        }
    </style>
@endsection

@section('content')
    @include('includes.topsection')

    <section class="blog_area section-padding single-post-area section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 mb-5 mb-lg-0 mx-auto d-block">
                    <div class="blog_left_sidebar">
                        <div class="row mb-5">
                            @if ($leaders->isEmpty())
                                <h4 class="mx-auto d-block text-center">
                                    No record found... Please check again later...
                                </h4>
                            @else
                                @foreach ($leaders as $leader)
                                    <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up" data-aos-delay="300">
                                        <div class="alumni-card">
                                            <div class="alumni-image">
                                                @if ($leader->image)
                                                    <img src="{{ $leader->image }}" alt="Image" class="img-fluid"
                                                        loading="lazy">
                                                @else
                                                    <img src="assets/img/gallery/no-image.jpg" alt="Image"
                                                        class="img-fluid" loading="lazy">
                                                @endif
                                            </div>
                                            <div class="alumni-content">
                                                <h4>{{ $leader->name }}</h4>
                                                <p class="alumni-class">{{ $leader->class }}</p>
                                                <p class="alumni-position">
                                                    {{ $leader->position }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="container">
                            <nav class="blog-pagination justify-content-center d-flexo mt-4">
                                {{ $leaders->links('pagination::bootstrap-5') }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script></script>
@endsection
