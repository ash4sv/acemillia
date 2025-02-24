@extends('apps.layouts.apps')

@section('title', 'Tag')
@section('description', '')
@section('keywords', '')

@push('style')

@endpush

@push('script')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

@section('content')

    <div class="card">
        <h4 class="card-header">@yield('title')</h4>
        <div class="card-datatable table-responsive">

            {{ $dataTable->table() }}

        </div>
    </div>

@endsection
