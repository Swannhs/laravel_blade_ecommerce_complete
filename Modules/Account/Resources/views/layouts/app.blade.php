@extends('backEnd.master', ['title' => $title ?? ''])
@push('scripts')
    <script src="{{asset(asset_path('backend/js/account.js'))}}"></script>
@endpush

