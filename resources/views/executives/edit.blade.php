@extends("layouts.default")
@section("title", "Executives - Lasu C&S Chapter")
@section("TopSectionName", "Edit Ojo Executives")
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
                    Edit Executives Record
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
                <form class="form-contact contact_form" action="{{ route('executives.update', $executive) }}"
                    enctype="multipart/form-data" method="POST" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="form-label">FullName</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="name" id="name" class="form-control" minlength="5"
                                    maxlength="150" required
                                    placeholder="Enter FullName (ex: Bro Adekale Idowu Solomon)"
                                    value="{{ old('name', $executive->name) }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="position" class="form-label">Position</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="position" id="position" class="form-control" minlength="5"
                                    maxlength="150" required autocomplete="on"
                                    placeholder="Enter Position (ex: Vice President)"
                                    value="{{ old('position', $executive->position) }}">
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
                                @if ($executive->image)
                                <img src="{{ asset('storage/' . $executive->image) }}" class="rounded border"
                                    width="150" height="150" alt="Leader Image">
                                @endif
                                <img src="" id="previewUploadImg" class="rounded border" style="display: none;"
                                    width="150" height="150" alt="Leaders Image">
                                <!-- Clear icon -->
                                <span id="clearPreview" class="text-danger" style="display: none; cursor:pointer;"
                                    title="Remove Upload">
                                    <small><i class="fa fa-times"></i> Remove</small>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="instagram" class="form-label">Social Link</label>
                                <small class="text-warning">(optional)</small>
                                <input type="url" name="instagram" id="instagram" class="form-control"
                                    placeholder="Enter Social Link (ex:https://www.instagram.com)"
                                    value="{{ old('instagram', $executive->instagram) }}">
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
</script>
@endsection