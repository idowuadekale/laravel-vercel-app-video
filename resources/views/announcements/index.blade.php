@extends("layouts.default")
@section("title", "Announcement - Lasu C&S Chapter")
@section("TopSectionName", "Announcement Page")
@section("style")
<style>
.blog_area a:hover,
.blog_area a :hover {
    background: #fff;
    -webkit-background-clip::padding-box;
    -webkit-text-fill-color:#331391;
    text-decoration: none;
    transition: .4s
}

.announcement-body {
    font-size: 16px;
    color: #333;
    line-height: 1.7;
    height: 150px;
    /* use max-height instead of height for flexibility */
    overflow: hidden;
    white-space: pre-line;
    text-transform: none;
    /* avoid auto-capitalizing full text */
    margin-top: -5px;
}

.blog_item_img img {
    object-fit: cover;
    height: 200px;
    width: 100%;
}
</style>
@endsection

@section("content")
@include("includes.topsection")

<section class="blog_area section-padding single-post-area section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-5 mb-lg-0 mx-auto d-block">
                <div class="blog_left_sidebar">
                    <div class="row">                        
                        @if($announcements->isEmpty())
                          <h4 class="mx-auto d-block text-center">               
                            No record found... Please check again later...           
                        </h4>           
                        @else
                        @foreach($announcements as $announcement)
                        <div class="col-lg-4 col-md-6">
                            <article class="blog_item card">
                                <div class="blog_item_img">
                                    @if($announcement->image_url)
                                    <img class="card-img rounded-0" src="{{ $announcement->image_url }}"
                                        alt="Announcemet_Image">
                                    @else
                                    <img class="card-img rounded-0" src="{{ asset('assets/img/blog/announcement.jpg') }}" alt="No Image">
                                    @endif
                                    <a href="{{ route('announcements.show', $announcement) }}" class="blog_item_date">
                                        <h3>{{ $announcement->created_at->format('d') }}</h3>
                                        <p>{{ $announcement->created_at->format('M, Y') }}</p>
                                    </a>
                                </div>
                                <div class="blog_details">
                                    <a class="d-inline-block" href="{{ route('announcements.show', $announcement) }}">
                                        <h2 class="blog-head uppercase pt-2 px-4" style="font-size: 25px;">
                                            {{ Str::limit($announcement->title, 50, '...') }}
                                        </h2>
                                    </a>
                                    <p class="announcement-body px-3">
                                        {{ Str::limit(strip_tags(html_entity_decode($announcement->body)), 230, '...') }}
                                    </p>
                                    <ul class="blog-info-link mx-3">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-clock"></i>
                                                {{ $announcement->created_at->diffForHumans() }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-bullhorn"></i>{{ $announcement->tag ?? 'General' }}
                                            </a>
                                        </li>
                                    </ul>
                                    <a href="{{ route('announcements.show', $announcement) }}" class="btn m-3"
                                        style="padding: 15px; color: #fff;">
                                        View
                                    </a>
                                </div>
                            </article>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="container">
                        <nav class="blog-pagination justify-content-center d-flexo mt-4">
                            {{ $announcements->links('pagination::bootstrap-5') }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section("script")
<script>
</script>
@endsection