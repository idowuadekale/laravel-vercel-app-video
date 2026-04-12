@extends('layouts.default')
@section('title', 'Gallery - Lasu C&S Chapter')
@section('TopSectionName', 'Manage Gallery')
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
                        Add Gallery Record
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
                    <form class="form-contact contact_form" action="{{ route('galleries.store') }}"
                        enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name of Program</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="name" class="form-control" minlength="3"
                                        maxlength="150" required placeholder="Enter Name of Program (ex: Freshers day)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Date-only picker -->
                                <div class="form-group">
                                    <label for="date" class="form-label">Date</label>
                                    <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" name="date" class="form-control" id="datePicker"
                                            placeholder="Select Program Date" readonly required>
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                </div>
                                <!-- Date-time picker -->
                                <!-- <div class="mb-3">
                                        <label for="datetimePicker" class="form-label">Date & Time</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datetimePicker"
                                                placeholder="Select date and time" readonly>
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                    </div> -->
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="live" class="form-label">Live Session</label>
                                    <small class="text-warning">(optional)</small>
                                    <input type="url" name="live" id="live" class="form-control"
                                        placeholder="Enter Live Session link (ex: https://facebook ...)">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="link" class="form-label">
                                        Gallery Link
                                        <small>(Google Drive)</small>
                                    </label>
                                    <span class="text-danger">*</span>
                                    <input type="url" name="link" id="link" class="form-control" required
                                        placeholder="Paste any image URL (Google Drive...)">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add New</button>
                    </form>

                    @if ($galleriesAuth)
                        <p class="mt-3 float-right">
                            <strong>Last updated by:</strong> {{ $galleriesAuth->user->name ?? 'Unknown' }} at
                            {{ $galleriesAuth->updated_at->format('d, M, Y. h:i A') }}
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
                            <div class="serial" style="width: 300px;">Date</div>
                            <div class="percentage">Name</div>
                            <div class="serial" style="width: 300px;">Live</div>
                            <div class="serial" style="width: 300px;">Link</div>
                            <div class="percentage">Action</div>
                        </div>
                        @foreach ($galleries as $gallery)
                            <div class="table-row">
                                <div class="serial" style="width: 300px;">
                                    {{ \Carbon\Carbon::parse($gallery->date)->format('Y M d') }}
                                </div>
                                <div class="percentage">{{ $gallery->name }}</div>
                                <div class="serial" style="width: 300px;">
                                    @if ($gallery->live)
                                        <a href="{{ $gallery->live }}" target="_blank" class="text-muted">View Live</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="serial" style="width: 300px;">
                                    @if ($gallery->link)
                                        <a href="{{ $gallery->link }}" target="_blank" class="text-muted">View Link</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                                <div class="percentage">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('galleries.edit', $gallery) }}" class="btn bg-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('galleries.delete', $gallery->id) }}" method="POST"
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
                        {{ $galleries->links('pagination::bootstrap-5') }}
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

            // Date-time picker (no future dates/times)
            flatpickr("#datetimePicker", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: false,
                maxDate: now, // Disable future dates
                allowInput: true,
                clickOpens: true,
                minuteIncrement: 1,
                onOpen: function(selectedDates, dateStr, instance) {
                    instance.setDate(instance.input.value, false);
                }
            });

        });
    </script>
@endsection
