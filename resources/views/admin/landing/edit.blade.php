@extends('layouts.default')
@section('title', 'Home Page - Lasu C&S Chapter')
@section('TopSectionName', 'Manage Home Page')
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
                        {{ $landing ? 'Edit Home Page' : 'Set Home Page' }}
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
                    <form class="form-contact contact_form" action="{{ route('landing.update') }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" title="Example: Your Journey with God Starts Here – Join Us!">
                                    <label for="welcome_heading" class="form-label">Welcome Heading</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="text" name="welcome_heading" id="welcome_heading" class="form-control"
                                        minlength="3" maxlength="100" placeholder="Enter Welcome Heading"
                                        value="{{ old('welcome_heading', $landing->welcome_heading ?? '') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" title="Example: More Than a Church. A Family. A Calling.">
                                    <label for="welcome_bio" class="form-label">Welcome Bio</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="text" name="welcome_bio" id="welcome_bio" class="form-control"
                                        minlength="3" maxlength="100" placeholder="Enter Welcome Bio"
                                        value="{{ old('welcome_bio', $landing->welcome_bio ?? '') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="about_img" class="form-label">About Image</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="file" name="about_img" id="imageUrl" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                                <div class="my-2">
                                    @if (!empty($landing->about_img))
                                        <img src="{{ asset('storage/' . $landing->about_img) }}" class="rounded border"
                                            width="150" height="150" alt="Program Image">
                                    @endif
                                    <img src="" id="previewUploadImg" class="rounded border" style="display: none;"
                                        width="150" height="150" alt="Program Image">
                                    <!-- Clear icon -->
                                    <span id="clearPreview" class="text-danger" style="display: none; cursor:pointer;"
                                        title="Remove Upload">
                                        <small><i class="fa fa-times"></i> Remove</small>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group" title="Example: About Us">
                                    <label for="about_heading" class="form-label">About Heading</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="text" name="about_heading" id="about_heading" class="form-control"
                                        minlength="3" maxlength="30" placeholder="Enter About Heading"
                                        value="{{ old('about_heading', $landing->about_heading ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group"
                                    title="Example: We are a community of believers committed to spiritual growth and fellowship.">
                                    <label for="about_info" class="form-label">About Info
                                        <small>(max: 400 words)</small>
                                    </label>
                                    <small class="text-warning">(optional)</small>
                                    <textarea class="form-control" minlength="3" maxlength="400" name="about_info" id="about_info" cols="20"
                                        rows="4" placeholder="Enter About Info">
                                        {{ old('about_info', $landing->about_info ?? '') }}
                                    </textarea>
                                </div>
                                {{-- <div class="form-group"
                                    title="Example: We are a community of believers committed to spiritual growth and fellowship.">
                                    <label for="about_info" class="form-label">About Info</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="text" name="about_info" id="about_info" class="form-control"
                                        minlength="3" maxlength="200" placeholder="Enter About Info"
                                        value="{{ old('about_info', $landing->about_info ?? '') }}">
                                </div> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="tel" name="phone" id="phone" class="form-control"
                                        placeholder="Enter Phone Number" minlength="3" maxlength="20"
                                        value="{{ old('phone', $landing->phone ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <small class="text-danger">*</small>
                                    <input type="email" name="email" id="email" class="form-control" required
                                        placeholder="Enter Email" value="{{ old('email', $landing->email ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="address" class="form-label">Address</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="text" name="address" id="address" class="form-control"
                                        placeholder="Enter Address" minlength="3" maxlength="250"
                                        value="{{ old('address', $landing->address ?? '') }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="map" class="form-label">Google Map Url</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="url" name="map" id="map" class="form-control"
                                        placeholder="Enter Google Map Url" value="{{ old('map', $landing->map ?? '') }}">
                                    <small class="text-muted">Get one by clicking:
                                        <a href="https://maps.google.com/" target="_blank"
                                            class="text-muted">https://maps.google.com/</a>
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="map" class="form-label">Free Editing Tool</label>
                                    <small>(Don't worry it won't save)</small>
                                    <div id="editor" class="quill-editor" style="min-height:150px;">
                                        Paste your Embeded Map link for editing
                                    </div>
                                    <small class="text-muted" style="word-break: break-all;">
                                        Example:
                                        https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.4356869097387!2d3.197725773503807!3d6.466360623827753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8696500590b1%3A0xf27b47e41fad6dab!2sLagos%20State%20University!5e0!3m2!1sen!2sng!4v1765370287969!5m2!1sen!2sng
                                    </small>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>

                    @if ($landing)
                        <p class="mt-3 float-right">
                            <strong>Last updated by:</strong> {{ $landing->user->name ?? 'Unknown' }} at
                            {{ $landing->updated_at->format('d, M, Y. h:i A') }}
                        </p>
                    @endif

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

        // Quill editor
        var quill = new Quill('#editor', {
            theme: 'snow',
            placeholder: 'Type your content here...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline'], // Basic text styles            
                    ['link'], // Links
                    ['clean'] // Remove formatting
                ]
            }
        });
    </script>
@endsection
