@extends('layouts.default')
@section('title', 'Group Image - Lasu C&S Chapter')
@section('TopSectionName', 'Manage Group Images')
@section('style')
    <style>
    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <section class="button-area">
        <div class="container box_1170 border-top-generic">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">
                        Edit Group Image
                    </h2>
                    <hr>

                    <div class="float-right">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                                {{ session()->get('success') }}
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
                                    <li class="text-danger m-2">{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="col-md-12">
                    <form class="form-contact contact_form" action="{{ route('images.update', $group) }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="file" name="image" id="imageUrl" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                                <div class="my-2">
                                    @if ($group->image)
                                        <img src="{{ $group->image }}" class="rounded border" width="150" height="150"
                                            alt="Group Image">
                                    @endif
                                    <img src="" id="previewUploadImg" class="rounded border" style="display: none;"
                                        width="150" height="150" alt="Leaders Image">
                                    <!-- Clear icon -->
                                    <span id="clearPreview" class="text-danger" style="display: none; cursor:pointer;"
                                        title="Remove Upload">
                                        <small><i class="fa fa-times"></i> Remove</small>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="short_bio" class="form-label">Short Title</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="text" name="short_bio" id="short_bio" class="form-control"
                                        minlength="3" maxlength="150" placeholder="Enter Short Title (ex:Church Retreat)"
                                        value="{{ old('short_bio', $group->short_bio) }}">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                    <!--================ Pagination Area =================-->
                    @include('includes.Dashpagination')
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script>
        $("#imageUrl").on("change", e => {
            let file = e.target.files[0];
            if (file) {
                $("#previewUploadImg").attr("src", URL.createObjectURL(file));
                $("#previewUploadImg").show();
                $("#clearPreview").show();
            }
        });
        $("#clearPreview").on("click", () => {
            $("#imageUrl").val("");
            $("#previewUploadImg").hide();
            $("#clearPreview").hide();
        });
    </script>
@endsection
