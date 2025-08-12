<div class="card shadow-none border-1 border-solid">
    <x-show-header
        title="Customer Details"
        :editRoute="route('admin.registered-user.users.edit', $user->id)"
        :indexRoute="route('admin.registered-user.users.index')"
    />
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-6">
                <dl class="row mb-0">
                    @isset($user->id)
                        <dt class="col-sm-4">ID</dt>
                        <dd class="col-sm-8">{{ $user->id }}</dd>
                    @endisset

                    @isset($user->name)
                        <dt class="col-sm-4">Full Name</dt>
                        <dd class="col-sm-8">{{ $user->name }}</dd>
                    @endisset

                    @isset($user->email)
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                {{ $user->email }}
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 copy-text" data-copy="{{ $user->email }}" title="Copy Email">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset

                    @isset($user->phone)
                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8">
                            <div class="d-flex align-items-center">
                                {{ $user->phone }}
                                <button type="button" class="btn btn-sm btn-icon btn-outline-secondary ms-2 copy-text" data-copy="{{ $user->phone }}" title="Copy Phone">
                                    <i class="ti ti-copy"></i>
                                </button>
                            </div>
                        </dd>
                    @endisset

                    @isset($user->date_of_birth)
                        <dt class="col-sm-4">Date of Birth</dt>
                        <dd class="col-sm-8">{{ $user->date_of_birth }}</dd>
                    @endisset

                    @isset($user->gender)
                        <dt class="col-sm-4">Gender</dt>
                        <dd class="col-sm-8">{{ ucfirst($user->gender) }}</dd>
                    @endisset

                    @isset($user->nationality)
                        <dt class="col-sm-4">Nationality</dt>
                        <dd class="col-sm-8 nationality" data-nationality="{{ $user->nationality }}">{{ $user->nationality }}</dd>
                    @endisset

                    @isset($user->identification_number)
                        <dt class="col-sm-4">Identification Number</dt>
                        <dd class="col-sm-8">{{ $user->identification_number }}</dd>
                    @endisset

                    @isset($user->upload_documents)
                        <dt class="col-sm-4">Documents</dt>
                        <dd class="col-sm-8">
                            <a href="{{ asset($user->upload_documents) }}" target="_blank">View Document</a>
                        </dd>
                    @endisset

                    @isset($user->created_at)
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $user->created_at }}</dd>
                    @endisset

                    @isset($user->updated_at)
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $user->updated_at }}</dd>
                    @endisset
                </dl>
            </div>

            @if($user->addressBooks && $user->addressBooks->isNotEmpty())
                <div class="col-md-6">
                    @foreach($user->addressBooks as $address)
                        <dl class="row mb-4">
                            <dt class="col-sm-4">Address</dt>
                            <dd class="col-sm-8">{{ $address->address }}</dd>

                            <dt class="col-sm-4">State</dt>
                            <dd class="col-sm-8">{{ $address->state }}</dd>

                            <dt class="col-sm-4">City</dt>
                            <dd class="col-sm-8">{{ $address->city }}</dd>

                            <dt class="col-sm-4">Street</dt>
                            <dd class="col-sm-8">{{ $address->street_address }}</dd>

                            <dt class="col-sm-4">Postcode</dt>
                            <dd class="col-sm-8">{{ $address->postcode }}</dd>
                        </dl>
                    @endforeach
                </div>
            @endif
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

    const nationalityEl = document.querySelector('.nationality');
    if (nationalityEl && nationalityEl.dataset.nationality) {
        fetch('/user/countries')
            .then(response => response.json())
            .then(countries => {
                const match = countries.find(country => country.alpha_2_code === nationalityEl.dataset.nationality);
                if (match) {
                    nationalityEl.textContent = match.en_short_name;
                }
            })
            .catch(err => console.error('Error fetching countries:', err));
    }
</script>
@endpush
