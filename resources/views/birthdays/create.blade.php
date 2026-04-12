@extends('layouts.default')
@section('title', 'Members Birthday - Lasu C&S Chapter')
@section('TopSectionName', 'Manage Birthday')
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
                    <form class="form-contact contact_form" id="birthdayForm" action="{{ route('birthdays.store') }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="name" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Name (ex: Bro Adekale Solomon)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="class" class="form-label">Department</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="class" id="class" class="form-control" minlength="5"
                                        maxlength="100" required
                                        placeholder="Enter Department (ex: Computer Science Education)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="faculty" class="form-label">Faculty</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="faculty" id="faculty" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Faculty (ex: Education)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="unit" class="form-label">Unit</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="unit" id="unit" class="form-control" minlength="5"
                                        maxlength="100" required placeholder="Enter Unit (ex: Drama Unit, Choir Unit...)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Date-only picker -->
                                <div class="form-group">
                                    <label for="dob" class="form-label">DOB</label>
                                    <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" name="dob" class="form-control" id="datePicker"
                                            placeholder="Select DOB" readonly required minlength="5">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="image" class="form-label">Upload Image</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="file" name="image" id="imageUrl" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">Only JPG, JPEG, PNG, WEBP • Max 20MB</small>
                                </div>
                                <div class="my-2">
                                    <img src="" id="previewUploadImg" class="rounded border" style="display: none;"
                                        width="150" height="150" alt="birthdays Image">
                                    <!-- Clear icon -->
                                    <span id="clearPreview" class="text-danger" style="display: none; cursor:pointer;"
                                        title="Remove Upload">
                                        <small><i class="fa fa-times"></i> Remove</small>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add New</button>
                    </form>
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
                            <div class="serial" style="width: 300px;">Department</div>
                            <div class="serial" style="width: 500px;">Faculty</div>
                            <div class="serial" style="width: 500px;">Unit</div>
                            <div class="serial" style="width: 300px;">DOB</div>
                            <div class="percentage">Actions</div>
                        </div>
                        @foreach ($birthdays as $birthday)
                            <div class="table-row">
                                <div class="serial" style="width: 300px;">
                                    @if ($birthday->image)
                                        <img src="{{ asset('storage/' . $birthday->image) }}" class="rounded"
                                            style="width: auto; height: 30px;" alt="Flyer">
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">
                                    {{ Str::limit($birthday->name, 50, '...') }}
                                </div>
                                <div class="serial" style="width: 300px;">
                                    {{ $birthday->department }}
                                </div>
                                <div class="serial" style="width: 500px;">
                                    {{ $birthday->faculty }}
                                </div>
                                <div class="serial" style="width: 500px;">
                                    {{ $birthday->unit }}
                                </div>
                                <div class="serial" style="width: 300px;">
                                    {{ \Carbon\Carbon::parse($birthday->dob)->format('Y M d') }}
                                </div>
                                <div class="percentage">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('birthdays.edit', $birthday) }}" class="btn bg-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('birthdays.delete', $birthday) }}" method="POST"
                                            class="btn bg-danger p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-transparent border-none p-1 px-2"
                                                onclick="return confirm('Delete this announcement?')">
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
                        {{ $birthdays->links('pagination::bootstrap-5') }}
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
            // Get current date and time
            const now = new Date();

            // Date-only picker (no future dates)
            flatpickr("#datePicker", {
                dateFormat: "Y/m/d",
                maxDate: now, // Disable future dates
                allowInput: true,
                clickOpens: true,
                onOpen: function(selectedDates, dateStr, instance) {
                    instance.setDate(instance.input.value, false);
                }
            });

        });
    </script>
@endsection
