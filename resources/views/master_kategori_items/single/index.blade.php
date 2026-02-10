@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('master-kategori-items')}}" class="btn btn-secondary">Kembali ke Daftar Kategori Item</a>
            </div>
            <div class="card">
                <div class="card-header">Master Kategori Item</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                    </table>

                    Daftar Items

                    <table id="table" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($item_list as $row)
                            <tr>
                                <td>{{ $row->kode }}</td>
                                <td>{{ $row->nama }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a class="btn btn-success"
                        href="{{ url('master-kategori-items/cetak-pdf/'.$data->id) }}"
                        target="_blank">
                        Cetak PDF
                    </a>

                    <a class="btn btn-info" href="{{url('master-kategori-items/form/edit')}}/{{$data->id}}">Edit</a>
                    <a class="btn btn-danger" href="{{url('master-kategori-items/delete')}}/{{$data->id}}" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection