@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

<div class="tab-pane fade show active" id="address-tab-pane" role="tabpanel">
    <div class="row">
        <div class="col-12">
            <div class="card mb-0 mt-0">
                <div class="card-body">
                    <div class="top-sec">
                        <h3>Address Book</h3>
                        <button data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.create') }}" data-create-title="Address" class="btn btn-sm btn-solid">+ Add New</button>
                    </div>
                    <div class="address-book-section">
                        <div class="row g-4">
                            @forelse(auth()->guard('web')->user()->addressBooks as $key => $address)
                                <div class="select-box active col-xl-4 col-md-6">
                                    <div class="address-box">
                                        <div class="top">
                                            <h6>John Due {{--<span>New Home</span>--}}</h6>
                                        </div>
                                        <div class="middle">
                                            <div class="address">
                                                <p>{!! $address->address !!}</p>
                                                <p>{!! $address->state !!}, {!! $address->country !!}</p>
                                                <p>{!! $address->postcode !!}, {!! $address->city !!}</p>
                                            </div>
                                            <div class="number">
                                                <p>Phone: <span>+1 5551855359</span></p>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            <a href="#!" data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.edit', $address->id) }}" data-create-title="Edit Address" class="bottom_btn">Edit</a>
                                            <a href="#!" class="bottom_btn">Remove</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="select-box active col-xl-12 col-md-12">
                                    <div class="address-box">
                                        <h4 class="mb-0 p-4">have no registered address</h4>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
