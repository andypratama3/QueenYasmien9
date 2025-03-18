@extends('layouts.dashboard')

@section('title', 'Pesanan')

@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
    select option[value="pending"] {
        background-color: yellow;
        color: black;
    }

    select option[value="settlement"] {
        background-color: green;
        color: white;
    }

    select option[value="expire"] {
        background-color: red;
        color: white;
    }

    select option[value="pengiriman"] {
        background-color: orange;
        color: white;
    }

    select option[value="proses"] {
        background-color: blue;
        color: white;
    }

    select option[value="selesai"] {
        background-color: green;
        color: white;
    }
</style>

@endpush

@section('content')
<h1 class="h3 mb-3"><strong>Data </strong> Pesanan</h1>

<div class="row">
    <div class="col-xl-12 col-xxl-8 d-flex">
        <div class="w-100">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h6 class="">Data  Pesanan

                            </h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="filter">Filter</label>
                                        <input type="text" name="date" id="date_range" class="form-control" placeholder="Pilih Tanggal">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="">Status Pembayaran</label>
                                        <select name="status_pembayaran" id="status_pembayaran" class="form-control">
                                            <option value="">Semua</option>
                                            <option value="pending">Pending</option>
                                            <option value="settlement">Berhasil</option>
                                            <option value="expire">Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="">Status Pesanan</label>
                                        <select name="status_pesanan" id="status_pesanan" class="form-control">
                                            <option value="">Semua</option>
                                            <option value="pending">Pending</option>
                                            <option value="proses">Proses</option>
                                            <option value="pengiriman">Dalam Pengiriman</option>
                                            <option value="selesai">Selesai</option>
                                            <option value="cancel">Batal</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped justify-content-center" id="pemesanan">
                                    <thead>
                                        <tr>
                                            <td>No</td>
                                            <th>OrderID</th>
                                            <td>Nama</td>
                                            <td>Status Pesanan</td>
                                            <td>Status Pembayaran</td>
                                            <td>Total</td>
                                            {{-- <td></td> --}}
                                            <td>Aksi</td>
                                        </tr>
                                    </thead>
                                    <tbody>

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

@push('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script>
        $(document).ready(function () {
            $('input[name="date"]').daterangepicker({
                timePicker: true,
                autoUpdateInput: false,  // This prevents automatic updating of the input value
                locale: {
                    format: 'DD-MM-YYYY',
                }
            });
             // Listen for the apply event to manually set the input value when a date range is selected
             $('input[name="date"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' : ' + picker.endDate.format('DD-MM-YYYY'));
            });

            // Clear the input value on cancel if needed
            $('input[name="date"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
            $('#pemesanan').DataTable({
                    ordering: true,
                    pagination: true,
                    deferRender: true,
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    stateSave: true,
                    pageLength: 50,
                    ajax: {
                        'url': '{{ route("dashboard.pemesanan.data_table") }}',
                        'data': function (d) {
                            d.date = $('#date_range').val();
                            d.status_pemesanan = $('#status_pesanan').val();
                            d.status_pembayaran = $('#status_pembayaran').val();
                        },
                    },
                    columns: [
                        { data: 'DT_RowIndex',name: 'DT_RowIndex',orderable: false,searchable: false},
                        { data: 'order_id', name: 'order_id'},
                        { data: 'user', name: 'user'},
                        { data: 'status_pemesanan', name: 'status_pemesanan'},
                        { data: 'status_pembayaran', name: 'status_pembayaran'},
                        { data: 'gross_amount', name: 'gross_amount'},
                        { data: 'action', name: 'action', orderable: false,searchable: false},
                    ],
                });
                $('#pemesanan').on('click', '.btn-delete', function () {
                    var slug = $(this).data('id');
                    var url = '{{ route("dashboard.pesanan.destroy", ":slug") }}';
                    url = url.replace(':slug', slug);
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: 'Data yang sudah dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        dangerMode: true,
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                url: url,
                                type: 'DELETE',
                                success: function (data) {
                                    if (data.status === 'success') {
                                        Swal.fire('Berhasil', data.message, 'success').then(() => {
                                            reloadTable('#pemesanan');
                                        });
                                    } else {
                                        Swal.fire('Error', data.message, 'error');
                                    }
                                },
                            });
                        }
                    });
                });
            $('#date_range').on('apply.daterangepicker', function () {
                let range = $('#date_range').val();
                $('#date_range').val(range);
                reloadTable('#pemesanan');
            });
            $('#status_pesanan').on('change', function () {
                let status_pesanan = $('#status_pesanan').val();
                $('#status_pesanan').val(status_pesanan);
                reloadTable('#pemesanan');
            });
            $('#status_pembayaran').on('change', function () {
                let status_pembayaran = $('#status_pembayaran').val();
                $('#status_pembayaran').val(status_pembayaran);
                reloadTable('#pemesanan');
            });
        });
    </script>
@endpush
@endsection
