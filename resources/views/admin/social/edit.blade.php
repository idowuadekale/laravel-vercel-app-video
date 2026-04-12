@extends("layouts.default")
@section("title", "Social Handles - Lasu C&S Chapter")
@section("TopSectionName", "Manage Social Handles")
@section("style")
<style>

</style>
@endsection
@section("content")

<!--================ Top section Area =================-->
@include("includes.topsection")

<section class="button-area">
    <div class="container box_1170 border-top-generic">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">
                    {{ $social ? 'Edit Social Handles' : 'Set Social Handles' }}
                </h2>
                <hr>

                <div class="float-right">
                    @if (session()->has("success"))
                    <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                        {{session()->get("success")}}
                    </div>
                    @endif
                    <script>
                    // Auto-dismiss after 4 seconds
                    setTimeout(function() {
                        let alert = document.getElementById('success-alert');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                            setTimeout(() => alert.remove(), 900); // Optional: remove element after fade
                        }
                    }, 8000); //8seconds
                    </script>
                </div>
                <div class="mx-auto text-center shadow-sm mb-3">
                    @if ($errors->any())
                    <ul class="d-md-inline-flex">
                        @foreach ($errors->all() as $error)
                        <li class="text-danger m-2">{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <form class="form-contact contact_form" action="{{ route('social.update') }}" method="POST"
                    autocomplete="off">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="facebook" class="form-label">Facebook</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="facebook" id="facebook" class="form-control" minlength="3"
                                    value="{{ old('facebook', $social->facebook ?? '') }}"
                                    placeholder="Enter Facebook URL">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="twitter" class="form-label">Twitter</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="twitter" id="twitter" class="form-control" minlength="3"
                                    value="{{ old('twitter', $social->twitter ?? '') }}"
                                    placeholder="Enter Twitter URL">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="instagram" class="form-label">Instagram</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="instagram" id="instagram" class="form-control" minlength="3"
                                    value="{{ old('instagram', $social->instagram ?? '') }}"
                                    placeholder="Enter Instagram URL">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="linkedin" class="form-label">LinkedIn</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="linkedin" id="linkedin" class="form-control" minlength="3"
                                    value="{{ old('linkedin', $social->linkedin ?? '') }}"
                                    placeholder="Enter LinkedIn URL">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="youtube" class="form-label">YouTube</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="youtube" id="youtube" class="form-control" minlength="3"
                                    value="{{ old('youtube', $social->youtube ?? '') }}"
                                    placeholder="Enter YouTube URL">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tiktok" class="form-label">TikTok</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="tiktok" id="tiktok" class="form-control" minlength="3"
                                    value="{{ old('tiktok', $social->tiktok ?? '') }}" placeholder="Enter TikTok URL">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="video_link" class="form-label">Video Link</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="video_link" id="video_link" class="form-control" minlength="3"
                                    value="{{ old('video_link', $social->video_link ?? '') }}"
                                    placeholder="Enter video_link URL">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>

                @if($social)
                <p class="mt-3 float-right">
                    <strong>Last updated by:</strong> {{ $social->user->name ?? 'Unknown' }} at
                    {{ $social->updated_at->format('d, M, Y. h:i A') }}
                </p>
                @endif

                <!--================ Pagination Area =================-->
                @include("includes.Dashpagination")
            </div>
        </div>
    </div>
</section>

@endsection
@section("script")
<script>

</script>
@endsection