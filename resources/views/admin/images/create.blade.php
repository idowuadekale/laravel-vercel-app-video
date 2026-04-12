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
                        Add Group Image
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
                    <form class="form-contact contact_form" action="{{ route('images.store') }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <span class="text-danger">*</span>
                                    <input type="file" name="image" id="imageUrl" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp" required>
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                                <div class="my-2">
                                    <img src="" id="previewUploadImg" class="rounded border" style="display: none;"
                                        width="150" height="150" alt="Group Image">
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
                                        minlength="3" maxlength="150" placeholder="Enter Short Title (ex:Church Retreat)">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add New</button>
                    </form>

                    @if ($groupAuth)
                        <p class="mt-3 float-right">
                            <strong>Last updated by:</strong> {{ $groupAuth->user->name ?? 'Unknown' }} at
                            {{ $groupAuth->updated_at->format('d, M, Y. h:i A') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="section-top-border">
                <h3 class="contact-title mb-30">
                    Available Records
                </h3>
                <hr>
                <div class="progress-table-wrap">
                    <div class="progress-table">
                        <div class="table-head">
                            <div class="serial" style="width: 300px;">Images</div>
                            <div class="percentage">Short Title</div>
                            <div class="percentage">Actions</div>
                        </div>
                        @foreach ($groups as $group)
                            <div class="table-row">
                                <div class="serial" style="width: 300px;">
                                    @if ($group->image)
                                        <img src="{{ asset('storage/' . $group->image) }}" class="rounded"
                                            style="width: auto; height: 30px;" alt="Image">
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">
                                    @if ($group->short_bio)
                                        {{ \Illuminate\Support\Str::limit(strip_tags($group->short_bio), 50, '...') }}
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('images.edit', $group) }}" class="btn bg-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('images.delete', $group->id) }}" method="POST"
                                            class="btn bg-danger p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-transparent border-none p-1 px-2"
                                                onclick="return confirm('Delete this record?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="container">
                    <nav class="blog-pagination justify-content-center d-flexo mt-4">
                        {{ $groups->links('pagination::bootstrap-5') }}
                    </nav>
                </div>

                <!--================ Pagination Area =================-->
                @include('includes.Dashpagination')
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
