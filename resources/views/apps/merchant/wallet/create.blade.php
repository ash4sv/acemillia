<form method="POST" action="{{ route('merchant.wallet-request.store') }}">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label>Amount</label>
                <input type="number" name="amount" step="0.01" max="{{ $merchant->wallet->balance }}" required class="form-control" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Bank Name</label>
                <input type="text" name="bank_name" required class="form-control" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Account Name</label>
                <input type="text" name="bank_account_name" required class="form-control" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Account Number</label>
                <input type="text" name="bank_account_number" required class="form-control" />
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Request Withdrawal</button>
</form>
