@extends('layouts.default')
@section('title', 'Programs - Lasu C&S Chapter')
@section('TopSectionName', 'Manage Programs')
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
                    <form class="form-contact contact_form" id="programForm" action="{{ route('programs.addEntry') }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name of Program</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="name" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Program (ex: Freshers day)">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <!-- Date-only picker -->
                                <div class="form-group">
                                    <label for="date" class="form-label">Date</label>
                                    <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" name="date" class="form-control" id="datePicker"
                                            placeholder="Select Date" readonly required minlength="5">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <!-- Time-only picker -->
                                <div class="form-group">
                                    <label for="time" class="form-label">Time</label>
                                    <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" name="time" class="form-control" id="timePicker"
                                            placeholder="Select Time" readonly required>
                                        <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Upload Flyer</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="file" name="image" id="imageUrl" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                                <div class="my-2">
                                    <img src="" id="previewUploadImg" class="rounded border" style="display: none;"
                                        width="150" height="150" alt="Leaders Image">
                                    <!-- Clear icon -->
                                    <span id="clearPreview" class="text-danger" style="display: none; cursor:pointer;"
                                        title="Remove Upload">
                                        <small><i class="fa fa-times"></i> Remove</small>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <label for="semester" class="form-label">Select Semester</label>
                                <span class="text-danger">*</span>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <select name="semester" class="form-control" required>
                                        <option value="">Select Semester</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="rsvp" class="form-label">
                                        RSVP
                                        <small>(Google Form)</small>
                                    </label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="url" name="rsvp" id="rsvp" class="form-control"
                                        placeholder="Enter Registration Link (ex: Google Form)">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="details" class="form-label">Program Information</label>
                                    <span class="text-danger">*</span>
                                    <input type="hidden" name="details" id="details" required>
                                    <div id="editor" class="quill-editor" style="min-height:150px;"></div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </form>
                    @if ($programsAuth)
                        <p class="mt-3 float-right">
                            <strong>Last updated by:</strong> {{ $programsAuth->user->name ?? 'Unknown' }} at
                            {{ $programsAuth->updated_at->format('d, M, Y. h:i A') }}
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
                            <div class="serial" style="width: 300px;">Image</div>
                            <div class="percentage">Name</div>
                            <div class="visit" style="width: 300px;">Date_Time</div>
                            <div class="serial" style="width: 500px;">Body</div>
                            <div class="serial" style="width: 300px;">Rsvp</div>
                            <div class="percentage">Actions</div>
                        </div>
                        @foreach ($programs as $program)
                            <div class="table-row">
                                <div class="serial" style="width: 300px;">
                                    @if ($program->image)
                                        <img src="{{ $program->image }}" class="rounded"
                                            style="width: auto; height: 30px;" alt="Flyer">
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">
                                    {{ $program->name }}
                                </div>
                                <div class="visit" style="width: 300px;">
                                    {{ \Carbon\Carbon::parse($program->date)->format('Y M d') }}
                                    - {{ \Carbon\Carbon::createFromFormat('H:i:s', $program->time)->format('g:i A') }}
                                    - {{ $program->semester }}
                                </div>
                                <div class="serial" style="width: 500px;">
                                    {{ Str::limit(strip_tags(html_entity_decode($program->details)), 100, '...') }}
                                </div>
                                <div class="serial" style="width: 300px;">
                                    @if ($program->rsvp)
                                        <a href="{{ $program->rsvp }}" target="_blank" class="text-muted">View Link</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('programs.edit', $program) }}" class="btn bg-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('programs.destroy', $program) }}" method="POST"
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
                        {{ $programs->links('pagination::bootstrap-5') }}
                    </nav>
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

        $(document).ready(function() {
            const now = new Date(); // Get current date and time   
            let currentYear = new Date().getFullYear(); // Get year values
            let minYear = currentYear - 2;
            let maxYear = currentYear + 1;
            let minDate = new Date(minYear, 0, 1); // Set min = Jan 1st two years ago    
            let maxDate = new Date(maxYear, 11, 31); // Set max = Dec 31st next year

            // Date-only picker (no future dates)
            flatpickr("#datePicker", {
                dateFormat: "Y/m/d",
                minDate: minDate,
                maxDate: maxDate,
                allowInput: true,
                clickOpens: true,
                onOpen: function(selectedDates, dateStr, instance) {
                    instance.setDate(instance.input.value, false);
                }
            });

            flatpickr("#timePicker", {
                enableTime: true,
                noCalendar: true, // Disable calendar
                dateFormat: "h:i K", //12hr format - "H:i" for 24hr format (e.g. 14:30)
                time_24hr: false // Set true if you don't prefer AM/PM
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
                document.querySelector('#details').value = quill.root.innerHTML;
            };

            $(function() {

                $("#programForm").on("submit", function(e) {

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
                    $("#details").val(quillContent);
                });

            });

        });
    </script>
@endsection
