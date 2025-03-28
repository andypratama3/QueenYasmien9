@extends('layouts.dashboard')

@section('title', 'Tambah Katalog')
@push('css')
    <link href="https://cdn.bootcdn.net/ajax/libs/quill/1.3.7/quill.snow.min.css" rel="stylesheet" />
@endpush

@section('content')
<h1 class="h3 mb-3"><strong>Tambah </strong> Katalog</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('dashboard.catalog.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="name">Nama</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mt-2">
                                        <div class="col-md-12">
                                            <label for="foto" class="form-label">Gambar</label>
                                            <input type="file"
                                                   class="form-control @error('foto') is-invalid @enderror"
                                                   id="foto"
                                                   name="foto"
                                                   accept="image/*"
                                                   onchange="previewImage(event)">
                                            @error('foto')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <h6 class="text-center">Preview Gambar</h6>
                                            <img src=""
                                                 id="output"
                                                 class="img-preview img-fluid mb-3"
                                                 style="border-radius: 10px; max-width: 100%; height: auto; display: none;">
                                        </div>

                                    </div>

                                    <div class="col-md-12 mt-2 mb-6">
                                        <label class="form-label" for="name">Deskripsi</label>
                                        <div id="editor"></div>
                                        <textarea name="desc" id="content-editor" style="display: none;"></textarea>
                                        @error('stock')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>


                                    <div class="col-md-12 mt-6">
                                        <a href="{{ route('dashboard.catalog.index') }}" class="btn btn-sm btn-danger">Kembali</a>
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
                    output.src = e.target.result; // Set the Base64 encoded image data
                    output.style.display = 'block'; // Display the image
                };

                reader.readAsDataURL(file); // Read the file as a Data URL
            } else {
                output.src = ''; // Clear src if no file
                output.style.display = 'none'; // Hide the image
            }
        }


        $(document).ready(function () {
            $('.select2').select2();

            $('#price').on('input', function () {
                let price = $(this).val();
                price = price.replace(/[^0-9.]/g, '');
                price = formatRupiah(price);
                $(this).val(price);
            });


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
                        resize: {
                            locale: {},
                        },

                    },
                    theme: 'snow'
                });


                quill.on('text-change', function (delta, oldDelta, source) {
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
                            formData.append('gambar_upload', file); // Sesuaikan dengan key di backend

                            try {
                                const response = await fetch('{{ route('dashboard.catalog.upload.image') }}', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                });

                                if (!response.ok) {
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }

                                const data = await response.json();
                                if (data.status === 'success') {
                                    const range = quill.getSelection();
                                    quill.insertEmbed(range.index, 'image', data.url);
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message,
                                        showConfirmButton: false,
                                        timer: 1500,
                                    });
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
