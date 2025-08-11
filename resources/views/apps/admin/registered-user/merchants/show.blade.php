<div class="card shadow-none border-1 border-solid">
    <x-show-header
        title="Merchant Details"
        :editRoute="route('admin.registered-user.merchants.edit', $merchant->id)"
        :indexRoute="route('admin.registered-user.merchants.index')"
    />
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($merchant->id)
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $merchant->id }}</dd>
                    @endisset

                    @isset($merchant->company_name)
                        <dt class="col-sm-4">Company</dt>
                        <dd class="col-sm-8">{{ $merchant->company_name }}</dd>
                    @endisset

                    @isset($merchant->company_registration_number)
                        <dt class="col-sm-4">Reg. Number</dt>
                        <dd class="col-sm-8">{{ $merchant->company_registration_number }}</dd>
                    @endisset

                    @isset($merchant->tax_id)
                        <dt class="col-sm-4">Tax ID</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                {{ $merchant->tax_id }}
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 copy-text" data-copy="{{ $merchant->tax_id }}" title="Copy Tax ID">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset

                    @isset($merchant->business_license_document)
                        <dt class="col-sm-4">Business License</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                <a href="{{ asset($merchant->business_license_document) }}" target="_blank">View Document</a>
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 copy-text" data-copy="{{ asset($merchant->business_license_document) }}" title="Copy URL">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset

                    @isset($merchant->name)
                        <dt class="col-sm-4">Contact Name</dt>
                        <dd class="col-sm-8">{{ $merchant->name }}</dd>
                    @endisset

                    @isset($merchant->email)
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                {{ $merchant->email }}
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 copy-text" data-copy="{{ $merchant->email }}" title="Copy Email">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset

                    @isset($merchant->phone)
                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                {{ $merchant->phone }}
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 copy-text" data-copy="{{ $merchant->phone }}" title="Copy Phone">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset
                </dl>
            </div>

            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($merchant->bank_name_account)
                        <dt class="col-sm-4">Bank Name</dt>
                        <dd class="col-sm-8">{{ $merchant->bank_name_account }}</dd>
                    @endisset

                    @isset($merchant->bank_account_details)
                        <dt class="col-sm-4">Bank Account</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                {{ $merchant->bank_account_details }}
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 copy-text" data-copy="{{ $merchant->bank_account_details }}" title="Copy Account">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset

                    @isset($merchant->menuSetup->name)
                        <dt class="col-sm-4">Category</dt>
                        <dd class="col-sm-8">{{ $merchant->menuSetup->name }}</dd>
                    @endisset

                    @isset($merchant->status_submission)
                        <dt class="col-sm-4">Submission</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ strtolower($merchant->status_submission) === 'approved' ? 'bg-success' : 'bg-label-secondary' }}">
                                {{ ucfirst($merchant->status_submission) }}
                            </span>
                        </dd>
                    @endisset

                    @isset($merchant->address->country)
                        <dt class="col-sm-4">Country</dt>
                        <dd class="col-sm-8">{{ $merchant->address->country }}</dd>
                    @endisset

                    @isset($merchant->address->state)
                        <dt class="col-sm-4">State</dt>
                        <dd class="col-sm-8">{{ $merchant->address->state }}</dd>
                    @endisset

                    @isset($merchant->address->city)
                        <dt class="col-sm-4">City</dt>
                        <dd class="col-sm-8">{{ $merchant->address->city }}</dd>
                    @endisset

                    @isset($merchant->address->postcode)
                        <dt class="col-sm-4">Postcode</dt>
                        <dd class="col-sm-8">{{ $merchant->address->postcode }}</dd>
                    @endisset

                    @isset($merchant->address->street_address)
                        <dt class="col-sm-4">Street</dt>
                        <dd class="col-sm-8">{{ $merchant->address->street_address }}</dd>
                    @endisset

                    @isset($merchant->address->business_address)
                        <dt class="col-sm-4">Business Addr.</dt>
                        <dd class="col-sm-8">{{ $merchant->address->business_address }}</dd>
                    @endisset

                    @isset($merchant->created_at)
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $merchant->created_at }}</dd>
                    @endisset

                    @isset($merchant->updated_at)
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $merchant->updated_at }}</dd>
                    @endisset
                </dl>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    document.querySelectorAll('.copy-text').forEach(button => {
        button.addEventListener('click', function () {
            navigator.clipboard.writeText(this.dataset.copy);
            this.innerHTML = '<i class="bx bx-check"></i>';
            setTimeout(() => this.innerHTML = '<i class="ti ti-copy"></i>', 2000);
        });
    });
</script>
@endpush

