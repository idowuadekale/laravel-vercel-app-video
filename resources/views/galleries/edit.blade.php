@extends("layouts.default")
@section("title", "Gallery - Lasu C&S Chapter")
@section("TopSectionName", "Edit Gallery")
@section("style")
<style>
</style>
@endsection
@section("content")

<!--================ Top section Area =================-->
@include("includes.topsection")

<section class="button-area">
    <div class="container box_1170 border-top-generic">
        <div class="row">
            <div class="col-12">
                <h2 class="contact-title">
                    Edit Gallery Record
                </h2>
                <hr>

                <div class="float-right">
                    @if (session()->has("success"))
                    <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                        {{session()->get("success")}}
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
                        <li class="text-danger m-2">{{$error}}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <form class="form-contact contact_form" action="{{ route('galleries.update', $gallery) }}"
                    enctype="multipart/form-data" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name of Program</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="name" id="name" class="form-control" minlength="3"
                                    maxlength="150" required placeholder="Enter Name of Program (ex: Freshers day)"
                                    value="{{ old('name', $gallery->name) }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <!-- Date-only picker -->
                            <div class="form-group">
                                <label for="date" class="form-label">Date</label>
                                <span class="text-danger">*</span>
                                <div class="input-group">
                                    <input type="text" name="date" class="form-control" id="datePicker"
                                        placeholder="Select Program Date" readonly required
                                        value="{{ old('date', $gallery->date) }}">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="live" class="form-label">Live Session</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="live" id="live" class="form-control"
                                    placeholder="Enter Live Session link (ex: https://facebook ...)"
                                    value="{{ old('live', $gallery->live) }}">
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
                                    placeholder="Paste any image URL (Google Drive...)"
                                    value="{{ old('link', $gallery->link) }}">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>

                <!--================ Pagination Area =================-->
                @include("includes.Dashpagination")
            </div>
        </div>
    </div>
</section>

@endsection
@section("script")
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