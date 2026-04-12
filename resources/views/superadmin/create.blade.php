@extends('layouts.default')
@section('title', 'Super Admin - Lasu C&S Chapter')
@section('TopSectionName', 'Create Admins')
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
                        Add Admin
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
                    <form class="form-contact contact_form" action="{{ route('superadmin.store') }}" method="POST"
                        autocomplete="off">
                        @csrf

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name</label>
                                    <span class="text-danger">*</span>
                                    <input type="text" name="name" id="name" class="form-control" minlength="4"
                                        maxlength="50" required placeholder="Enter Full Name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <span class="text-danger">*</span>
                                    <input type="email" name="email" id="email" class="form-control" required
                                        placeholder="Enter Email Address">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <span class="text-danger">*</span>
                                    <input type="password" name="password" id="password" class="form-control" required
                                        placeholder="Enter Password">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <span class="text-danger">*</span>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control" required placeholder="Enter Confirm Password">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Add New</button>
                    </form>

                    <!--================ Pagination Area =================-->
                    @include('includes.Dashpagination')
                </div>
            </div>
        </div>
    </section>

@endsection
@section('script')
    <script></script>
@endsection
