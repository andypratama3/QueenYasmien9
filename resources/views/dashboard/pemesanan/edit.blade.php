@extends('layouts.dashboard')

@section('title', 'Edit Pesanan')

@push('css')
    <link href="https://cdn.bootcdn.net/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet" />
@endpush

@section('content')
<h1 class="h3 mb-3"><strong>Edit </strong> Pesanan</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.pesanan.update', $pemesanan->slug) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $pemesanan->user->name) }}" readonly>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="name">Order ID</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $pemesanan->order_id) }}" readonly>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label" for="gross_amount">Total Pembayaran</label>
                                        <input type="text" class="form-control @error('gross_amount') is-invalid @enderror"
                                               id="gross_amount" name="gross_amount" value="{{ old('gross_amount', 'Rp. ' . number_format((float) ($pemesanan->gross_amount ?? 0), 0, ',', '.')) }}" readonly>
                                        @error('gross_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="form-label" for="pengiriman">Pengiriman</label>
                                        <input type="text" class="form-control @error('pengiriman') is-invalid @enderror"
                                               id="pengiriman" name="pengiriman" value="{{ old('pengiriman', $pemesanan->pengiriman) }}" readonly>
                                        @error('pengiriman')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="form-label" for="pengiriman">Alamat</label>
                                        <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                  id="alamat" name="alamat" readonly>{{ old('alamat', $pemesanan->alamat) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="form-label" for="status_pemesanan">Status Pemesanan</label>
                                        <select class="form-control @error('status_pemesanan') is-invalid @enderror"
                                                id="status_pemesanan" name="status_pemesanan">
                                            <option value="pending" {{ $pemesanan->status_pemesanan == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="proses" {{ $pemesanan->status_pemesanan == 'proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="pengiriman" {{ $pemesanan->status_pemesanan == 'pengiriman' ? 'selected' : '' }}>Pengiriman</option>
                                            <option value="selesai" {{ $pemesanan->status_pemesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="batal" {{ $pemesanan->status_pemesanan == 'batal' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                        @error('status_pemesanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label class="form-label" for="status_pembayaran">Status Pembayaran</label>
                                        <select class="form-control @error('status_pembayaran') is-invalid @enderror" disabled
                                                id="status_pembayaran" name="status_pembayaran">
                                            <option value="pending" {{ $pemesanan->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="capture" {{ in_array($pemesanan->status_pembayaran, ['capture', 'settlement']) ? 'selected' : '' }}>Selesai</option>
                                            <option value="batal" {{ in_array($pemesanan->status_pembayaran, ['batal', 'expire', 'cancel', 'deny']) ? 'selected' : '' }}>Batal</option>
                                        </select>
                                        @error('status_pembayaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <label class="form-label" for="created_at">Tanggal Pemesanan</label>
                                        <input type="text" class="form-control @error('created_at') is-invalid @enderror"
                                                id="created_at" name="created_at" value="{{ old('created_at', \Carbon\Carbon::parse($pemesanan->created_at)->format('d F Y')) }}" readonly>
                                        @error('created_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <td>Nama Produk</td>
                                                    <td>Paket Reseller</td>
                                                    <td>Jumlah</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($pemesanan->products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->product_reseller->first()->name ?? '-' }}</td>
                                                    <td>{{ $product->pivot->qty ?? 1 }}</td>
                                                </tr>
                                                @empty
                                                    <tr ></tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                    </div>



                                    <div class="col-md-12 mt-6">
                                        <a href="{{ route('dashboard.pesanan.index') }}" class="btn btn-sm btn-danger">Kembali</a>
                                        <button type="submit" class="btn-sm btn btn-primary">Simpan Perubahan</button>
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

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="https://cdn.bootcdn.net/ajax/libs/quill/1.3.7/quill.min.js"></script>
    <script defer src="https://unpkg.com/quill-resize-image@1.0.5/dist/quill-resize-image.min.js"></script>
    <script type="text/javascript">

        function previewImage(event) {
            const output = document.getElementById('output');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    output.src = e.target.result;
                    output.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                output.src = '';
                output.style.display = 'none';
            }
        }

        $(document).ready(function () {
            $('.select2').select2();

            Quill.register("modules/resize", window.QuillResizeImage);

            const toolbarOptions = [
                ['bold', 'italic', 'underline', 'strike'],
                ['blockquote', 'code-block'],
                [{ 'header': 1 }, { 'header': 2 }],
                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                [{ 'script': 'sub' }, { 'script': 'super' }],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'size': ['small', false, 'large', 'huge'] }],
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'font': [] }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ];

            var quill = new Quill('#editor', {
                modules: {
                    toolbar: {
                        container: toolbarOptions,
                        handlers: {
                            image: function () {
                                selectLocalImage();
                            }
                        }
                    },
                    resize: { locale: {} },
                },
                theme: 'snow'
            });

            quill.on('text-change', function () {
                $('#content-editor').text($('.ql-editor').html());
            });

            function selectLocalImage() {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();

                input.onchange = async () => {
                    const file = input.files[0];
                    if (file) {
                        const formData = new FormData();
                        formData.append('gambar_upload', file);

                        try {
                            const response = await fetch('{{ route('dashboard.post.upload.image') }}', {
                                method: 'POST',
                                body: formData,
                                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            });

                            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

                            const data = await response.json();
                            if (data.status === 'success') {
                                const range = quill.getSelection();
                                quill.insertEmbed(range.index, 'image', data.url);
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, showConfirmButton: false, timer: 1500 });
                            } else {
                                alert(data.message || 'Gagal mengunggah gambar');
                            }
                        } catch (error) {
                            console.error('Error uploading image:', error);
                            alert('Terjadi kesalahan saat mengunggah gambar.');
                        }
                    }
                };
            }
        });
    </script>
@endpush

@endsection
