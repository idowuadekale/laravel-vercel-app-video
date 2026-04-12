@extends("layouts.default")
@section("title", "Announcements - Lasu C&S Chapter")
@section("TopSectionName", "Manage Announcements")
@section("style")
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
#image_url{
    padding-right: 50px;
}
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
                    Add Record
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

            <div class="col-lg-12">                  
                <form class="form-contact contact_form" id="announcementForm" action="{{route("announcements.store")}}"
                    enctype="multipart/form-data" method="POST" autocomplete="off">
                    @csrf

                    <div class="row">                         
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title" class="form-label">Title</label>
                                <span class="text-danger">*</span>
                                <input type="text" name="title" id="title" class="form-control" minlength="5"
                                    maxlength="100" required placeholder="Enter Title (ex: Fellowship Meeting)">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tag" class="form-label">Tag</label>
                                <span class="text-danger">*</span>
                                <div class="input-group-icon mt-10">
                                    <div class="icon">
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                    </div>
                                    <div class="form-select" id="default-select">
                                        <select name="tag" id="tag" required>
                                            <option value="" selected>Select Tag</option>
                                            <option value="General">General</option>
                                            <option value="Event">Event</option>
                                            <option value="Reminder">Reminder</option>
                                            <option value="Support">Support</option>
                                            <option value="Update">Update</option>
                                            <option value="Notice">Notice</option>
                                            <option value="Meeting">Meeting</option>
                                            <option value="Appreciation">Appreciation</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="body" class="form-label">Body</label>
                                <span class="text-danger">*</span>
                                <input type="hidden" name="body" id="body" required>
                                <div id="editor" class="quill-editor" style="min-height:150px;"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">                                 
                                <label for="image_url" class="form-label">Add Image</label>
                                <small class="text-warning">(optional)</small>
                                <div class="input-group mb-2 position-relative">
                                    <input type="url" name="image_url" id="image_url" class="form-control"
                                    placeholder="Search to add Image" readonly>

                                    <!-- Clear Button (always visible) -->
                                    <span id="clear-image-url" title="Clear field">
                                        <i class="fa fa-times"></i>
                                    </span>

                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                        data-bs-target="#unsplashModal" style="padding: 20px 25px;">
                                        Search Image
                                    </button>
                                </div>
                                <img src="{{ old('image_url', $announcement->image_url ?? '') }}"
                                    id="selected-image-preview" class="img-fluid mt-2"
                                    style="max-height:200px; display: {{ old('image_url', $announcement->image_url ?? false) ? 'block' : 'none' }}">
                            </div>
                        </div>
                    </div>
                     <button type="submit" class="btn btn-primary">Add New</button>
                </form>               
                @if($announcementsAuth)
                <p class="mt-3 float-right">
                    <strong>Last updated by:</strong> {{ $announcementsAuth->user->name ?? 'Unknown' }} at
                    {{ $announcementsAuth->updated_at->format('d, M, Y. h:i A') }}
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
                        <div class="serial" style="width: 300px;">Images</div>
                        <div class="percentage">Title</div>
                         <div class="serial" style="width: 500px;">Body</div>
                        <div class="serial" style="width: 300px;">Tag</div>
                        <div class="percentage">Actions</div>
                    </div>
                    @foreach ($announcements as $announcement)
                    <div class="table-row">
                        <div class="serial" style="width: 300px;">                             
                            @if($announcement->image_url)
                            <img src="{{$announcement->image_url}}" class="rounded" style="width: auto; height: 30px;"
                                alt="Image">
                            @else
                            N/A
                            @endif                           
                        </div>
                        <div class="percentage">
                            {{ Str::limit($announcement->title, 50, '...') }}
                        </div>
                        <div class="serial" style="width: 500px;">
                            {{ Str::limit(strip_tags(html_entity_decode($announcement->body)), 100, '...') }}
                        </div>
                        <div class="serial" style="width: 300px;">
                            {{$announcement->tag}}
                        </div>
                        <div class="percentage">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('announcements.edit', $announcement) }}" class="btn bg-info">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('announcements.delete', $announcement) }}" method="POST"
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
                    {{ $announcements->links('pagination::bootstrap-5') }}                     
                </nav>
            </div>

            <!-- Unsplash Modal -->
            <div class="modal fade" id="unsplashModal" tabindex="3" aria-hidden="true" style="z-index: 999999;">
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
        </div>
    </div>
</section>

@endsection
@section("script")
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
    document.querySelector('#body').value = quill.root.innerHTML;
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
                col.innerHTML = `<img src="${img.urls.small}" class="img-fluid unsplash-image">`;
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
                '<p class="text-danger mx-auto">Error fetching images. Check your Internet Connection.</p>';
        });
});

$(function () {

    $("#announcementForm").on("submit", function (e) {

        // 1. Check ALL normal required inputs
        let emptyField = false;
        $(this).find("input[required], textarea[required], select[required]").each(function () {
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
</script>
@endsection