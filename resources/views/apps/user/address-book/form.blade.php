@php
    $route = 'user.saved-address.';
@endphp

<form action="{{ isset($addressBook) ? route( $route . 'update', $addressBook->id) : route( $route . 'store') }}" enctype="multipart/form-data" class="mb-0" method="POST">
    @csrf
    <div class="row g-sm-4 g-2">
        <div class="col-12">
            <div class="form-box">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Enter Title" value="{!! old('title', $addressBook->title ?? '') !!}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-box">
                <label for="recipient_name" class="form-label">Recipient Name</label>
                <input type="text" class="form-control" name="recipient_name" placeholder="Enter Recipient Name" value="{!! old('title', $addressBook->recipient_name ?? '') !!}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-box">
                <label for="number" class="form-label">Phone Number</label>
                <input type="number" class="form-control" name="phone" placeholder="Enter Your Phone Number" value="{!! old('phone', $addressBook->phone ?? '') !!}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-box">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" placeholder="Enter Address" value="{!! old('address', $addressBook->address ?? '') !!}">
            </div>
        </div>
        <div class="col-6">
            <div class="form-box">
                <label class="form-label">Country</label>
                <select name="country" class="form-select" disabled>
                    <option value="MY">Malaysia</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-box">
                <label class="form-label">State</label>
                <select name="state" class="form-select">
                    <option value="1">Argentina/Ch</option>
                    <option value="2">Argentina/UK</option>
                    <option value="3">Australia</option>
                    <option value="4">France</option>
                    <option value="5">New Zealand</option>
                    <option value="6">Norway</option>
                    <option value="7">Unclaimed Sector</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-box">
                <label for="city" class="form-label">City</label>
                <select name="city" class="form-select">
                    <option value="1">Argentina/Ch</option>
                    <option value="2">Argentina/UK</option>
                    <option value="3">Australia</option>
                    <option value="4">France</option>
                    <option value="5">New Zealand</option>
                    <option value="6">Norway</option>
                    <option value="7">Unclaimed Sector</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <div class="form-box">
                <label for="street" class="form-label">Street</label>
                <select name="street" class="form-select">
                    <option value="1">Argentina/Ch</option>
                    <option value="2">Argentina/UK</option>
                    <option value="3">Australia</option>
                    <option value="4">France</option>
                    <option value="5">New Zealand</option>
                    <option value="6">Norway</option>
                    <option value="7">Unclaimed Sector</option>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-box">
                <label for="postcode" class="form-label">Postcode</label>
                <select name="postcode" class="form-select">
                    <option value="1">Argentina/Ch</option>
                    <option value="2">Argentina/UK</option>
                    <option value="3">Australia</option>
                    <option value="4">France</option>
                    <option value="5">New Zealand</option>
                    <option value="6">Norway</option>
                    <option value="7">Unclaimed Sector</option>
                </select>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-solid w-auto">{{ isset($addressBook) ? 'Update' : 'Create' }} Address</button>
        </div>
    </div>

</form>
