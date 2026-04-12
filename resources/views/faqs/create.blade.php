@extends('layouts.default')
@section('title', 'Faqs - Lasu C&S Chapter')
@section('TopSectionName', 'Manage Faqs')
@section('style')
    <style>
    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <!-- Start Button -->
    <section class="button-area">
        <div class="container box_1170 border-top-generic">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">
                        Add Record
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

                <div class="col-lg-12">
                    <form class="form-contact contact_form" id="faqsForm" action="{{ route('faqs.addEntry') }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="title" id="title" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Title (ex: Family Song)">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="body" class="form-label">Faq Information</label>
                                    <span class="text-danger">*</span>
                                    <input type="hidden" name="body" id="body" required>
                                    <div id="editor" class="quill-editor" style="min-height:150px;"></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </form>
                    @if ($faqsAuth)
                        <p class="mt-3 float-right">
                            <strong>Last updated by:</strong> {{ $faqsAuth->user->name ?? 'Unknown' }} at
                            {{ $faqsAuth->updated_at->format('d, M, Y. h:i A') }}
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
                            <div class="serial" style="width: 300px;">Title</div>
                            <div class="serial" style="width: 500px;">Body</div>
                            <div class="percentage">Actions</div>
                        </div>
                        @foreach ($faqs as $faq)
                            <div class="table-row">
                                <div class="serial" style="width: 300px;">
                                    {{ $faq->title }}
                                </div>
                                <div class="serial" style="width: 500px;">
                                    {{ Str::limit(strip_tags(html_entity_decode($faq->body)), 100, '...') }}
                                </div>
                                <div class="percentage">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('faqs.edit', $faq) }}" class="btn bg-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('faqs.destroy', $faq) }}" method="POST"
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
                    <nav class="blog-pagination justify-content-center mt-4">
                        {{ $faqs->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script>
        $(document).ready(function() {

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
                document.querySelector('#body').value = quill.root.innerHTML;
            };

            $(function() {

                $("#faqsForm").on("submit", function(e) {

                    // 1. Check ALL normal required inputs
                    let emptyField = false;
                    $(this).find("input[required], textarea[required], select[required]").each(
                        function() {
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
                    $("#body").val(quillContent);
                });

            });

        });
    </script>
@endsection
