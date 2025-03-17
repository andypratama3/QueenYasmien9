@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<h1 class="h3 mb-3"><strong>Tambah Role</strong></h1>

<div class="row">
    <div class="col-xl-12 col-xxl-5 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-body py-4">
                <form action="{{ route('dashboard.settings.roles.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Role <code>*</code></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama Role" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-2">
                                <label for="">Hak Akses <code>*</code></label>
                                <div class="row mt-2">
                                    @foreach ($permissions as $permission)
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="{{ $permission->name }}">
                                                <label class="form-check-label" for="{{ $permission->name }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('permissions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <a href="{{ route('dashboard.settings.roles.index') }}" class="btn btn-danger">Kembali</a>
                            <button class="btn btn-primary float-end" type="submit">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
@endpush
@endsection
