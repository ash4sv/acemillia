@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

<div class="tab-pane fade show active" id="address-tab-pane" role="tabpanel">
    <div class="row">
        <div class="col-12">
            <div class="card mb-0 mt-0">
                <div class="card-body">
                    <div class="top-sec">
                        <h3>{!! __('Address Book') !!}</h3>
                        <button data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.create') }}" data-create-title="Address" class="btn btn-sm btn-solid">{!! __('+ Add New') !!}</button>
                    </div>
                    <div class="address-book-section">
                        <div class="row g-4">
                            @forelse(auth()->guard('web')->user()->addressBooks as $key => $address)
                                <div class="select-box active col-xl-6 col-md-6">
                                    <div class="address-box">
                                        <div class="top mb-2 position-relative">
                                            <h6 class="py-2">{!! __($address->recipient_name) !!} @isset($address->title)<span>{!! __($address->title) !!}</span>@endisset</h6>
                                        </div>
                                        <div class="middle">
                                            <div class="address">
                                                <p>{!! __($address->address) !!}</p>
                                                <p>{!! __($address->street_address) !!}</p>
                                                <p>{!! __($address->postcode) !!}, {!! __($address->city) !!}</p>
                                                <p>
                                                    <span class="state-name" data-state-code="{{ $address->state }}">
                                                        {!! __($address->state) !!}
                                                    </span>, {!! __($address->country) !!}
                                                </p>
                                            </div>
                                            <div class="number">
                                                <p>{!! __('Phone:') !!} <span>{!! __($address->phone) !!}</span></p>
                                            </div>
                                        </div>
                                        <div class="bottom">
                                            <a href="#!" data-bs-toggle="modal" data-bs-target="#basicModal" data-create-url="{{ route('user.saved-address.edit', $address->id) }}" data-create-title="Edit Address" class="bottom_btn">{!! __('Edit') !!}</a>
                                            <a href="#!" class="bottom_btn" onclick="Apps.deleteConfirm('remove-saved-address-{!! __($address->id) . '-' . __($key) !!}')">{!! __('Remove') !!}</a>
                                            <form id="remove-saved-address-{!! __($address->id) . '-' . __($key) !!}" action="{!! route('user.saved-address.destroy', $address->id) !!}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="select-box active col-xl-12 col-md-12">
                                    <div class="d-flex align-items-center justify-content-center bg-white" style="min-height:10rem;">
                                        <h3 class="m-0 text-center fw-lighter" style="font-size: 24px;">
                                            {{ __('No addresses saved yet—add one now and checkout will be a breeze!') }}
                                        </h3>
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

@push('script')
<script>
$(document).ready(function(){
    // Fetch the state mappings once
    $.ajax({
        url: '/user/states',
        method: 'GET',
        success: function(states) {
            // Create a mapping from state code to state name
            var stateMapping = {};
            $.each(states, function(index, state) {
                stateMapping[state.value] = state.name;
            });

            // Iterate over all elements with the "state-name" class and update the text
            $('.state-name').each(function(){
                var stateCode = $(this).data('state-code');
                if(stateMapping[stateCode]) {
                    $(this).text(stateMapping[stateCode]);
                }
            });
        },
        error: function(err) {
            console.log('Error fetching state data:', err);
        }
    });
});
</script>
@endpush
