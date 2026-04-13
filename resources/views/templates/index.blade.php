@extends('layouts.default')
@section('title', 'Newsletters - Lasu C&S Chapter')
@section('TopSectionName', 'Newsletters Templates')
@section('style')
    <style>
        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .border-none {
            border: none;
        }
    </style>
@endsection
@section('content')

    <!--================ Top section Area =================-->
    @include('includes.topsection')

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Templates</h2>
            <a href="{{ route('templates.create') }}" class="btn" style="padding: 10px">
                <i class="fas fa-plus"></i> Create
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                {{ session('success') }}
            </div>
            <script>
                // Auto-dismiss after 4 seconds
                setTimeout(function() {
                    let alert = document.getElementById('success-alert');
                    if (alert) {
                        alert.classList.remove('show');
                        alert.classList.add('fade');
                        setTimeout(() => alert.remove(), 900); // Optional: remove element after fade
                    }
                }, 4000);
            </script>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th> <!-- Added number column header -->
                                <th>Flyer</th>
                                <th>Image</th>
                                <th>Subject</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($templates as $template)
                                <tr>
                                    <td>{{ ($templates->currentPage() - 1) * $templates->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        @if ($template->image)
                                            <img src="{{ $template->image }}" class="rounded"
                                                style="width: auto; height: 30px;" alt="Image">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($template->image_url)
                                            <img src="{{ $template->image_url }}" class="rounded"
                                                style="width: auto; height: 30px;" alt="Image">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $template->subject }}</td>
                                    <td>{{ $template->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('templates.show', $template) }}" class="btn bg-dark">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('templates.edit', $template) }}" class="btn bg-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('templates.send', $template) }}" method="POST"
                                                class="btn bg-success p-0">
                                                @csrf
                                                <button type="submit" class="bg-transparent border-none p-1 px-2">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('templates.destroy', $template) }}" method="POST"
                                                class="btn bg-danger p-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-transparent border-none p-1 px-2"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">No newsletter templates found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container">
                <nav class="blog-pagination justify-content-center d-flexo mt-4">
                    {{ $templates->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
        <!--================ Pagination Area =================-->
        @include('includes.Dashpagination')
    </div>

@endsection
@section('script')
    <script></script>
@endsection
