@extends("layouts.default")
@section("title", "Administration Year - Lasu C&S Chapter")
@section("TopSectionName", "Manage Administration Year")
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
                    {{ $adminYear ? 'Edit Administration Year' : 'Set Administration Year' }}
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
                <form class="form-contact contact_form" action="{{ route('admin-year.storeOrUpdate') }}" method="POST"
                    autocomplete="off">
                    @csrf

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="year1" class="form-label">Year 1</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="year1" id="year1" class="form-control" minlength="4"
                                    maxlength="4" value="{{ old('year1', $adminYear->year1 ?? '') }}" required
                                    placeholder="Enter First Year">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="year2" class="form-label">Year 2</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="year2" id="year2" class="form-control" minlength="4"
                                    maxlength="4" value="{{ old('year2', $adminYear->year2 ?? '') }}" required
                                    placeholder="Enter Second Year">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>

                @if($adminYear)
                <p class="mt-3 float-right">
                    <strong>Last updated by:</strong> {{ $adminYear->user->name ?? 'Unknown' }} at
                    {{ $adminYear->updated_at->format('d, M, Y. h:i A') }}
                </p>
                @endif

                <!--================ Pagination Area =================-->
                @include("includes.Dashpagination")
            </div>
        </div>
    </div>
</section>

@endsection
@section("script")
<script>

</script>
@endsection