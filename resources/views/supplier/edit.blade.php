@extends('layouts.tamplate')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>
        
        <div class="card-body">
            @empty($supplier)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form method="POST" action="{{ url('/supplier/' . $supplier->supplier_id) }}" class="formhorizontal">
                    @csrf
                    {!! method_field('PUT') !!} <!-- tambahkan baris ini untuk proses edit yang butuh method PUT -->
                    
                    <!-- Supplier kode Field -->
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kode supplier</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="supplier_kode" name="supplier_kode"
                                value="{{ old('supplier_kode', $supplier->supplier_kode) }}" required>
                            @error('supplier_kode')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <!-- supplier nama Field -->
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama supplier</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="supplier_nama" name="supplier_nama"
                                value="{{ old('supplier_nama', $supplier->supplier_nama) }}" required>
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <!-- supplier alamat Field -->
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Alamat supplier</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="supplier_alamat" name="supplier_alamat"
                                value="{{ old('supplier_alamat', $supplier->supplier_alamat) }}" required>
                            @error('nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <!-- Submit and Back Buttons -->
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label"></label>
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a class="btn btn-sm btn-default ml-1" href="{{ url('supplier') }}">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection
@push('css')
@endpush
@push('js')