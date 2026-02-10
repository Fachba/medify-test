@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-kategori-items/form/new')}}" class="btn btn-secondary">+ Master Kategori Items Baru</a>
            </div>
            <div class="card">
                <div class="card-header">Daftar Master Kageori Items</div>

                <div class="card-body">
                    @include('master_kategori_items.index.filter')
                    @include('master_kategori_items.index.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@include('master_kategori_items.index.js')
@endsection