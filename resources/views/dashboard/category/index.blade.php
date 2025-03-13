@extends('layouts.dashboard')

@section('title', 'Kategori')

@section('content')
<h1 class="h3 mb-3"><strong>Kategori </strong> Produk</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="">Data Kategori Produk
                                <a href="{{ route('dashboard.category.create') }}" class="btn btn-primary btn-sm float-end"><i class="bx bx-plus "></i> Tambah</a>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="category">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <td>Nama</td>
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($category as $cat)
                                        <tr>
                                            <td>{{ ++$no }}</td>
                                            <td>{{ $cat->name }}</td>
                                            <td>
                                                <a href="{{ route('dashboard.category.edit', $cat->id) }}" class="btn btn-primary btn-sm"><i class="bx bx-pen"></i></a>
                                                <a href="#" data-id="{{ $cat->name }}" class="btn btn-danger btn-sm delete"
                                                    title="Hapus">
                                                    <form action="{{ route('dashboard.category.destroy', $cat->id) }}"
                                                        id="delete-{{ $cat->name }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                <i class="bx bx-trash"></i>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
