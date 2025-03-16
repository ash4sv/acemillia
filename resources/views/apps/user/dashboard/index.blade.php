@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel">
        <div class="counter-section">
            <div class="welcome-msg">
                <h4>Hello, {!! $authUser->name !!} !</h4>
                <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</p>
            </div>
            {{--<div class="row">
                <div class="col-md-4">
                    <div class="counter-box">
                        <img src="{{ asset('assets/images/dashboard/balance.png') }}" alt="" class="img-fluid">
                        <div>
                            <h3>$12.46</h3>
                            <h5>Total Order</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-box">
                        <img src="{{ asset('assets/images/dashboard/points.png') }}" alt="" class="img-fluid">
                        <div>
                            <h3>2530</h3>
                            <h5>Total Points</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="counter-box">
                        <img src="{{ asset('assets/images/dashboard/order.png') }}" alt="" class="img-fluid">
                        <div>
                            <h3>15</h3>
                            <h5>Total Orders</h5>
                        </div>
                    </div>
                </div>
            </div>--}}
            <div class="box-account box-info">
                <div class="box-head">
                    <h4>Account Information</h4>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">
                            <ul class="box-content">
                                @isset($authUser->name)
                                    <li class="w-100">
                                        <h6>{{ 'Name: ' . $authUser->name }}</h6>
                                    </li>
                                @endisset
                                @isset($authUser->phone)
                                    <li class="w-100">
                                        <h6>{{ 'Phone: ' . $authUser->phone }}</h6>
                                    </li>
                                @endisset
                                @isset($authUser->gender)
                                    <li class="w-100">
                                        <h6>{{ 'Gender: ' . ucfirst($authUser->gender) }}</h6>
                                    </li>
                                @endisset
                                @isset($authUser->date_of_birth)
                                    <li class="w-100">
                                        <h6>{{ 'Date of Birth: ' . $authUser->date_of_birth }}</h6>
                                    </li>
                                @endisset
                                @isset($authUser->nationality)
                                    <li class="w-100">
                                        <h6>{{ 'Nationality: ' . $authUser->nationality }}</h6>
                                    </li>
                                @endisset
                                @isset($authUser->identification_number)
                                    <li class="w-100">
                                        <h6>{{ 'Identification Number: ' . $authUser->identification_number }}</h6>
                                    </li>
                                @endisset
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box mt-3">
                    <div class="box-head">
                        <h4>Login Details</h4>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <h6 class="mb-1">Email : {{ $authUser->email }}</h6>
                            <a data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.profile.edit') }}" data-create-title="Edit Profile" href="#!">Edit</a>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="mb-1">Password : ●●●●●●</h6>
                            <a data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.password.edit') }}" data-create-title="Edit Password" href="#!">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
