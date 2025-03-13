@extends('layouts.dashboard')

@section('title', 'Edit Kategori')

@section('content')
<h1 class="h3 mb-3"><strong>Edit </strong> Kategori</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.category.update', $category->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <a href="{{ route('dashboard.category.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                                        <button type="submit" class="btn-sm btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

