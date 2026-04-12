@extends('layouts.default')
@section('title', 'Leaders - Lasu C&S Chapter')
@section('TopSectionName', 'Manage LASU C&S Leaders')
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
                        Add Leader Record
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
                    <form class="form-contact contact_form" action="{{ route('team.store') }}" enctype="multipart/form-data"
                        method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="name" class="form-control" minlength="5"
                                        maxlength="150" required placeholder="Enter Leader FullName">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="position" class="form-label">Position</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="position" id="position" class="form-control" minlength="5"
                                        maxlength="150" autocomplete="on" required placeholder="Enter Position">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="facebook" class="form-label">Social Handle 1</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="url" name="facebook" id="facebook" class="form-control"
                                        placeholder="Enter Social Handle 1 (ex:https://www.facebook.com)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="instagram" class="form-label">Social Handle 2</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="url" name="instagram" id="instagram" class="form-control"
                                        placeholder="Enter Social Handle 2 (ex:https://www.instagram.com)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mt-2">
                                    <img src="" id="previewUploadImg" class="rounded border" style="display: none;"
                                        width="150" height="150" alt="Leaders Image">
                                    <!-- Clear icon -->
                                    <span id="clearPreview" class="text-danger" style="display: none; cursor:pointer;"
                                        title="Remove Upload">
                                        <small><i class="fa fa-times"></i> Remove</small>
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="file" name="image" id="imageUrl" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add New</button>
                    </form>

                    @if ($teamAuth)
                        <p class="mt-3 float-right">
                            <strong>Last updated by:</strong> {{ $teamAuth->user->name ?? 'Unknown' }} at
                            {{ $teamAuth->updated_at->format('d, M, Y. h:i A') }}
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
                            <div class="percentage">Name</div>
                            <div class="visit">Position</div>
                            <div class="serial" style="width: 300px;">Social-1</div>
                            <div class="serial" style="width: 300px;">Social-2</div>
                            <div class="percentage">Actions</div>
                        </div>
                        @foreach ($teams as $member)
                            <div class="table-row">
                                <div class="serial" style="width: 300px;">
                                    @if ($member->image)
                                        <img src="{{ asset('storage/' . $member->image) }}" class="rounded"
                                            style="width: auto; height: 30px;" alt="Image">
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">{{ $member->name }}</div>
                                <div class="visit">
                                    {{ Str::limit(strip_tags($member->position), 50, '...') }}
                                </div>
                                <div class="serial" style="width: 300px;">
                                    @if ($member->facebook)
                                        <a href="{{ $member->facebook }}" target="_blank" class="text-muted">Link1</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="serial" style="width: 300px;">
                                    @if ($member->instagram)
                                        <a href="{{ $member->instagram }}" target="_blank" class="text-muted">Link2</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('team.edit', $member) }}" class="btn bg-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('team.delete', $member->id) }}" method="POST"
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
                        {{ $teams->links('pagination::bootstrap-5') }}
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
