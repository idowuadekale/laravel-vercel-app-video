@extends('layouts.default')
@section('title', 'Faqs - Lasu C&S Chapter')
@section('TopSectionName', 'Edit Faq')
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
                        Edit Record
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
                    <form class="form-contact contact_form" id="faqsForm" action="{{ route('faqs.saveEntry', $faq) }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="title" class="form-label">Title</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="title" id="title" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Title (ex: Sunday Service)"
                                        value="{{ $faq->title }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="body" class="form-label">Faq Information</label>
                                    <span class="text-danger">*</span>
                                    <input type="hidden" name="body" id="body" required
                                        value="{{ old('body', $faq->body ?? '') }}">
                                    <div id="editor" class="quill-editor" style="min-height:150px;">
                                        {!! old('body', $faq->body ?? '') !!}
                                    </div>
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
