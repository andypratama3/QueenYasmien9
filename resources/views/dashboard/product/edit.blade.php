@extends('layouts.dashboard')

@section('title', 'Edit Produk')

@push('css')
    <link href="https://cdn.bootcdn.net/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet" />
@endpush

@section('content')
<h1 class="h3 mb-3"><strong>Edit </strong> Produk</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.product.update', $product->slug) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name', $product->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label class="form-label" for="category">Kategori Produk</label>
                                        <select name="category_id" id="category" class="form-control">
                                            <option value="" selected>Pilih Kategori</option>
                                            @foreach ($categorys as $category)
                                                <option value="{{ $category->id }}" data-name="{{ $category->name }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-2" id="price_container">
                                        <label class="form-label" for="price">Harga</label>
                                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}">
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-2 {{ $product->category->name === 'Paket Reseller' ? '' : 'd-none' }}" id="category_reseller">
                                        <table class="table table-bordered" id="table_packet">
                                            <tr>
                                                <th class="w-25">Nama Paket</th>
                                                <th class="w-25">Jumlah</th>
                                                <th class="w-25">Harga</th>
                                                <th class="w-25"><button type="button" class="btn btn-primary btn-sm btn-add">+</button></th>
                                            </tr>

                                            @foreach($resellerPackages as $package)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="name_packet[]" value="{{ $package->name }}">
                                                </td>
                                                <td style="width: 20%;">
                                                    <input type="number" class="form-control" name="jumlah[]" value="{{ $package->jumlah }}">
                                                </td>
                                                <td style="width: 20%;">
                                                    <input type="text" class="form-control price-input" name="price_reseller[]" value="Rp {{ $package->price_reseller }}">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete">-</button>
                                                    <button type="button" class="btn btn-primary btn-sm btn-add">+</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>


                                    <div class="col-md-12 mt-2">
                                        <label class="form-label" for="stock">Stok</label>
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                               id="stock" name="stock" value="{{ old('stock', $product->stock) }}">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <label for="foto" class="form-label">Gambar</label>
                                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                               id="foto" name="foto" accept="image/*" onchange="previewImage(event)">
                                        @error('foto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="col-md-12 mt-2">
                                            <h6 class="text-center">Preview Gambar</h6>
                                            <img src="{{ $product->foto ? asset('storage/product/' . $product->foto) : '' }}"
                                                 id="output" class="img-preview img-fluid mb-3"
                                                 style="border-radius: 10px; max-width: 100%; height: auto;
                                                        display: {{ $product->foto ? 'block' : 'none' }};">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-2 mb-6">
                                        <label class="form-label" for="desc">Deskripsi</label>
                                        <div id="editor">{!! old('desc', $product->desc) !!}</div>
                                        <textarea name="desc" id="content-editor" style="display: none;">{{ old('desc', $product->desc) }}</textarea>
                                        @error('desc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-6">
                                        <a href="{{ route('dashboard.product.index') }}" class="btn btn-sm btn-danger">Kembali</a>
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
        $(document).ready(function () {
            let selectedCategory = $('#category option:selected').data('name');

            if (selectedCategory === 'Paket Reseller') {
                $('#category_reseller').removeClass('d-none');
                $('#price_container').addClass('d-none');
            }

            $('#category').on('change', function () {
                let categoryName = $(this).find(':selected').data('name');

                if (categoryName === 'Paket Reseller') {
                    $('#category_reseller').removeClass('d-none');
                    $('#price_container').addClass('d-none');
                } else {
                    $('#category_reseller').addClass('d-none');
                    $('#price_container').removeClass('d-none');
                }
            });
        // Fungsi format Rupiah
        function formatRupiah(angka) {
            let numberString = angka.replace(/[^,\d]/g, '').toString(),
                split = numberString.split('.'),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp ' + rupiah;
        }

        // Fungsi untuk menangani input harga
        function handlePriceInput(input) {
            let price = input.val();
            price = price.replace(/[^0-9]/g, ''); // Hanya angka
            if (price) {
                price = formatRupiah(price);
            }
            input.val(price);
        }

        // Inisialisasi semua input harga yang sudah ada saat halaman dimuat
        $('.price-input').each(function () {
            handlePriceInput($(this));
        });

        // Event listener untuk input harga yang sudah ada dan yang baru ditambahkan
        $('#table_packet').on('input', '.price-input', function () {
            handlePriceInput($(this));
        });

        // Fungsi untuk menambahkan baris baru ke tabel
        $('#table_packet').on('click', '.btn-add', function () {
            let newRow = `<tr>
                <td>
                    <input type="text" class="form-control" name="name_packet[]">
                </td>
                <td style="width: 20%;">
                    <input type="number" class="form-control" name="jumlah[]" placeholder="Jumlah Paket">
                </td>
                <td style="width: 20%;">
                    <input type="text" class="form-control price-input" name="price_reseller[]" placeholder="Harga Paket">
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm btn-delete">-</button>
                    <button type="button" class="btn btn-primary btn-sm btn-add">+</button>
                </td>
            </tr>`;

            $('#table_packet').append(newRow);

            // Inisialisasi input harga yang baru ditambahkan
            $('#table_packet tr:last .price-input').each(function () {
                handlePriceInput($(this));
            });
        });

        // Event delegation untuk hapus baris
        $('#table_packet').on('click', '.btn-delete', function () {
            $(this).closest('tr').remove();
        });
    });
</script>
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

            $('#price, #price_reseller').on('input', function () {
                let price = $(this).val();
                price = price.replace(/[^0-9.]/g, '');
                price = formatRupiah(price);
                $(this).val(price);
            });

            $('#price, #price_reseller').val(formatRupiah($('#price, #price_reseller').val()))

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
