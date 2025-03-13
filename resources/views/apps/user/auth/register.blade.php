@extends('apps.layouts.shop')

@section('description', '')
@section('keywords', '')
@section('author', '')
@section('title', 'Create account')

@push('style')

@endpush

@push('script')

@endpush

@section('webpage')

    <!-- breadcrumb start -->
    <div class="breadcrumb-section">
        <div class="container">
            <h2>@yield('title')</h2>
            <nav class="theme-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{!! url('/') !!}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">{!! strtoupper(__('Create account')) !!}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- breadcrumb end -->

    <!--section start-->
    <section class="login-page section-b-space">
        <div class="container">
            <h3>create account</h3>
            <div class="theme-card">
                <form class="theme-form" action="{{ route('auth.register') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Full Name</label>
                                <input type="text" class="form-control mb-0" id="" name="name" placeholder="Full Name" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Gender</label>
                                <select name="" id="" class="form-select">
                                    <option value="">Male</option>
                                    <option value="">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Date of Birth</label>
                                <input type="text" class="form-control mb-0" id="" name="name" placeholder="Date of Birth" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Nationality</label>
                                <select name="" id="" class="form-select">
                                    <option value="">Male</option>
                                    <option value="">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Identification Number</label>
                                <input type="text" class="form-control mb-0" id="" name="email" placeholder="Identification Number " required="">
                                <div class="form-text pt-1 text-secondary">
                                    (IC/Passport/Driving License)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Upload Documents</label>
                                <input type="file" class="form-control mb-0" id="" name="email" placeholder="Upload Documents" required="">
                                <div class="form-text pt-1 text-secondary">
                                    (IC/Passport/Driving License for verification)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-box">
                                <label for="" class="form-label">Address</label>
                                <input type="text" name="" id="" class="form-control mb-0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control mb-0" id="" name="email" placeholder="Email" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="email" class="form-label">Phone Number</label>
                                <input type="text" class="form-control mb-0" id="" name="email" placeholder="Phone Number" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="review" class="form-label">Password</label>
                                <input type="password" class="form-control mb-0" id="" name="password" placeholder="Enter your password" required="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-box">
                                <label for="review" class="form-label">Confirmation Password</label>
                                <input type="password" class="form-control mb-0" id="" name="password_confirmation" placeholder="Re-enter your password" required="">
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-solid w-auto">create Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--Section ends-->

@endsection
