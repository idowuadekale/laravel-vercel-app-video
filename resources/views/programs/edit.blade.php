@extends('layouts.default')
@section('title', 'Programs - Lasu C&S Chapter')
@section('TopSectionName', 'Edit Programs')
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
                    <form class="form-contact contact_form" id="programsForm"
                        action="{{ route('programs.saveEntry', $program) }}" enctype="multipart/form-data" method="POST"
                        autocomplete="off">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name of Program</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="name" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Program (ex: Freshers day)"
                                        value="{{ $program->name }}">
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <!-- Date-only picker -->
                                <div class="form-group">
                                    <label class="form-label">Date</label>
                                    <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" name="date" class="form-control" id="datePicker"
                                            placeholder="Select Date" readonly required minlength="5"
                                            value="{{ old('date', $program->date) }}">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <!-- Time-only picker -->
                                <div class="form-group">
                                    <label class="form-label">Time</label>
                                    <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" name="time" class="form-control" id="timePicker"
                                            placeholder="Select Time" readonly required
                                            value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $program->time)->format('g:i A') }}">
                                        <span class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Flyer</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="file" name="image" id="imageUrl" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                                <div class="my-2">
                                    @if ($program->image)
                                        <img src="{{ $program->image }}" class="rounded border" width="150"
                                            height="150" alt="Program Image">
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
                            <div class="col-md-4 col-sm-6">
                                <label for="semester" class="form-label">Select Semester</label>
                                <span class="text-danger">*</span>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-globe"></i>
                                    </span>
                                    <select name="semester" class="form-control" required>
                                        <option value="">Select Semester</option>
                                        <option value="1st Semester"
                                            {{ $program->semester == '1st Semester' ? 'selected' : '' }}>1st Semester
                                        </option>
                                        <option value="2nd Semester"
                                            {{ $program->semester == '2nd Semester' ? 'selected' : '' }}>2nd Semester
                                        </option>
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
                                        placeholder="Enter Registration Link (ex: Google Form)"
                                        value="{{ $program->rsvp }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="details" class="form-label">Program Information</label>
                                    <span class="text-danger">*</span>
                                    <input type="hidden" name="details" id="details" required
                                        value="{{ old('details', $program->details ?? '') }}">
                                    <div id="editor" class="quill-editor" style="min-height:150px;">
                                        {!! old('details', $program->details ?? '') !!}
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

                $("#programsForm").on("submit", function(e) {

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
