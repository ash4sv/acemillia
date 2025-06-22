@extends('apps.layouts.shop-user-layout')

@section('user-apps-content')

    <div class="dashboard-box">
        <div class="dashboard-title justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-0">Wallet Balance</h5>
                <h2 class="text-success mb-0">RM{{ number_format($wallet->balance, 2) }}</h2>
            </div>
            <div>
                <button class="btn btn-primary"
                        tabindex="0"
                        aria-controls="product-admin-table"
                        type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#basicModal"
                        data-modal-dialog-scrollable="false"
                        data-modal-dialog-centered="true"
                        data-modal-optional-size="modal-xl"
                        data-modal-fullscreen-mode=""
                        data-create-url="{{ route('merchant.wallet-request.create') }}"
                        data-create-title="Request Withdrawal">
                    <i class="fa fa-university me-1"></i> Request Withdrawal
                </button>
            </div>
        </div>
        <div class="dashboard-detail">

            {{ $dataTable->table() }}

        </div>
    </div>

@endsection

@push('script')

    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

@endpush
