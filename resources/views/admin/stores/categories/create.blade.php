@extends('admin.layouts.master')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <x-form :action="route('admin.store.category.store')" type="post" :validate="true">
                <div class="row justify-content-center">
                    @include('admin.stores.categories.forms.create-left')
                    @include('admin.stores.categories.forms.create-right')
                </div>
                @include('admin.forms.actions-fixed')
            </x-form>
        </div>
    </div>
@endsection

@push('libs-js')

@endpush

@push('custom-js')

@endpush
