@extends('layouts.default')
@section('title', 'Mail Template - Lasu C&S Chapter')
@section('TopSectionName', 'Edit Template')
@section('style')
    <style>
        #unsplash-results {
            max-height: 60vh;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 6px;
            scroll-behavior: smooth;
        }

        /* Optional custom scrollbar for a cleaner UI */
        #unsplash-results::-webkit-scrollbar {
            width: 8px;
        }

        #unsplash-results::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 4px;
        }

        #unsplash-results::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.4);
        }

        #clear-image-url {
            position: absolute;
            right: 180px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 20px;
            cursor: pointer;
            z-index: 5;
            transition: color 0.2s ease;
        }

        #clear-image-url:hover {
            color: #dc3545;
        }

        #image_url {
            padding-right: 50px;
        }
    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <section class="button-area">
        <div class="container box_1170 border-top-generic">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="contact-title">
                            Edit Record
                        </h2>
                        <a href="{{ route('templates.index') }}" class="btn" style="padding: 10px">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
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
                    <form class="form-contact contact_form" action="{{ route('templates.update', $template) }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="subject" class="form-label">Subject</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="subject" id="subject" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Subject (ex: Something big is coming!)"
                                        value="{{ old('subject', $template->subject ?? '') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="content" class="form-label">Content</label>
                                    <span class="text-danger">*</span>
                                    <input type="hidden" name="content" id="content" required
                                        value="{{ old('content', $template->content ?? '') }}">
                                    <div id="editor" class="quill-editor" style="min-height:150px;">
                                        {!! old('content', $template->content ?? '') !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image_url" class="form-label">Add Image</label>
                                    <small class="text-warning">(optional)</small>
                                    <div class="input-group mb-2 position-relative">
                                        <input type="url" name="image_url" id="image_url" class="form-control"
                                            placeholder="Search to add Image" readonly
                                            value="{{ old('image_url', $template->image_url) }}">

                                        <!-- Clear Button (always visible) -->
                                        <span id="clear-image-url" title="Clear field">
                                            <i class="fa fa-times"></i>
                                        </span>

                                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                            data-bs-target="#unsplashModal" style="padding: 20px 25px;">
                                            Search Image
                                        </button>
                                    </div>
                                    <div class="d-flex">
                                        <img src="{{ old('image_url', $template->image_url ?? '') }}" class="img-fluid m-2"
                                            title="Existing Image"
                                            style="max-height:200px; display: {{ old('image_url', $template->image_url ?? false) ? 'block' : 'none' }}">
                                        <img src="" id="selected-image-preview" class="img-fluid m-2"
                                            style="max-height:200px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="image" class="form-label">Flyer</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="file" name="image" id="imageUrl2" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                                <div class="my-2">
                                    @if ($template->image)
                                        <img src="{{ asset('storage/' . $template->image) }}" class="rounded border"
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
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                    <!-- Unsplash Modal -->
                    <div class="modal fade" id="unsplashModal" tabindex="3" aria-hidden="true"
                        style="z-index: 999999;">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content p-3">
                                <div class="mb-3 d-flex">
                                    <input type="text" id="unsplash-search" class="form-control" autocomplete="off"
                                        placeholder="Search for images...">
                                    <button type="button" class="btn btn-primary" style="padding: 15px 20px;"
                                        id="unsplash-search-btn">Search</button>
                                </div>

                                <!-- Scrollable Search Results -->
                                <div class="row" id="unsplash-results"></div>

                                <div class="mt-3 text-end">
                                    <button type="button" class="btn btn-secondary" style="padding: 15px;"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--================ Pagination Area =================-->
                    @include('includes.Dashpagination')
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const clearBtn = document.getElementById('clear-image-url');
        const imageInput = document.getElementById('image_url');
        const imagePreview = document.getElementById('selected-image-preview');

        clearBtn.addEventListener('click', () => {
            imageInput.value = '';
            imagePreview.src = '';
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
        var form = document.querySelector('form');
        form.onsubmit = function() {
            document.querySelector('#content').value = quill.root.innerHTML;
        };

        document.getElementById('unsplash-search-btn').addEventListener('click', function() {
            const UNSPLASH_ACCESS_KEY = "jdNwT-Xu39mdi5HJukfztWUI4zBcEGt8Oo3RynNPmhY"; // Replace with your API key
            let query = document.getElementById('unsplash-search').value;
            if (!query) return;
            let results = document.getElementById('unsplash-results');
            results.innerHTML = '<p>Searching...</p>';

            axios.get(`https://api.unsplash.com/search/photos`, {
                    params: {
                        query: query,
                        per_page: 30,
                        client_id: UNSPLASH_ACCESS_KEY
                    }
                })
                .then(response => {
                    results.innerHTML = '';
                    response.data.results.forEach(img => {
                        let col = document.createElement('div');
                        col.classList.add('col-6', 'col-md-3', 'mb-3');
                        col.innerHTML =
                            `<img src="${img.urls.small}" class="img-fluid unsplash-image">`;
                        col.querySelector('img').addEventListener('click', function() {
                            document.getElementById('image_url').value = img.urls.full;
                            let preview = document.getElementById('selected-image-preview');
                            preview.src = img.urls.small;
                            preview.style.display = 'block';
                            let unsplashModalEl = document.getElementById('unsplashModal');
                            let modal = bootstrap.Modal.getInstance(unsplashModalEl);
                            modal.hide();
                        });
                        results.appendChild(col);
                    });
                })
                .catch(err => {
                    console.error(err);
                    results.innerHTML =
                        '<p class="text-danger">Error fetching images. Check your Unsplash API key.</p>';
                });
        });

        $(function() {

            $("#templateForm").on("submit", function(e) {

                // 1. Check ALL normal required inputs
                let emptyField = false;
                $(this).find("input[required], textarea[required], select[required]").each(function() {
                    if ($(this).val().trim() === "") {
                        emptyField = true;
                    }
                });

                // 2. Check Quill body (this is your quill editor)
                let quillContent = quill.root.innerHTML.trim();

                let quillEmpty =
                    quill.getText().trim().length === 0 ||
                    quillContent === "<p><br></p>" ||
                    quillContent === "<br>" ||
                    quillContent === "";

                if (emptyField || quillEmpty) {
                    e.preventDefault(); // stop form submission
                    alert("Please fill all required fields.");
                    return;
                }

                // 3. Put quill HTML into hidden input so Laravel receives it
                $("#content").val(quillContent);
            });

        });

        $("#imageUrl2").on("change", e => {
            let file = e.target.files[0];
            if (file) {
                $("#previewUploadImg").attr("src", URL.createObjectURL(file));
                $("#previewUploadImg").show();
                $("#clearPreview").show();
            }
        });
        $("#clearPreview").on("click", () => {
            $("#imageUrl2").val("");
            $("#previewUploadImg").hide();
            $("#clearPreview").hide();
        });
    </script>
@endsection
