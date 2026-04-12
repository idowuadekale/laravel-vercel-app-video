@extends('layouts.default')
@section('title', 'Developer Dashboard - Lasu C&S Chapter')
@section('TopSectionName', ' Welcome back, Developer')
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
                        <a href="{{ route('superadmin.create') }}" class="btn">Create Admin</a> |
                        <a href="{{ route('developer.createSuper') }}" class="btn">Create Super Admin</a>
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
                    <div class="pb-5 mb-5">
                        <h2>Admins</h2>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            @forelse($admins as $admin)
                                <tr>
                                    <td>{{ $admin->id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->role }}</td>
                                    <td>
                                        <form action="{{ route('superadmin.destroy', $admin->id) }}" method="POST"
                                            onsubmit="return confirm('Delete admin?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-muted">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No Record found.</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>

                    <div>
                        <h2>Super Admins</h2>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            @forelse($supers as $super)
                                <tr>
                                    <td>{{ $super->id }}</td>
                                    <td>{{ $super->name }}</td>
                                    <td>{{ $super->email }}</td>
                                    <td>{{ $super->role }}</td>
                                    <td>
                                        @if ($super->email !== auth()->user()->email)
                                            <form action="{{ route('developer.destroy-super', $super->id) }}"
                                                method="POST" onsubmit="return confirm('Delete super admin?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Delete</button>
                                            </form>
                                        @else
                                            <span>Cannot delete yourself</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">No Record found.</td>
                                </tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>

            <!--================ Pagination Area =================-->
            @include('includes.Dashpagination')
        </div>
    </section>

@endsection
@section('script')
    <script></script>
@endsection
