@extends('layouts.dashboard')
@section('title','Dashboard')
@section('content')
<h1 class="h3 mb-3"><strong>List Role</strong>
    <a href="{{ route('dashboard.settings.roles.create') }}" class="btn btn-primary btn-sm float-end">
        <i class="bx bx-plus"></i>
        Tambah
    </a>
</h1>

<div class="row">
    <div class="col-md-12">
        <div class="card flex-fill w-100">

            <div class="card-body py-4">
                <div class="table-responsive">
                    <table class="table table-hover" id="role_table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Guard</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#role_table').DataTable({
                    ordering: true,
                    pagination: true,
                    deferRender: true,
                    serverSide: true,
                    responsive: true,
                    processing: true,
                    stateSave: true,
                    pageLength: 50,
                    ajax: {
                        'url': '{{ route("dashboard.settings.roles.data_table") }}',
                    },
                    columns: [
                        { data: 'DT_RowIndex',name: 'DT_RowIndex',orderable: false,searchable: false},
                        { data: 'name', name: 'name'},
                        { data: 'guard_name', name: 'guard_name'},
                        { data: 'action', name: 'action', orderable: false,searchable: false},
                    ],
                });
                $('#role_table').on('click', '.btn-delete', function () {
                    var id = $(this).data('id');
                    var url = '{{ route("dashboard.settings.roles.destroy", ":id") }}';
                    url = url.replace(':id', id);
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
                                            reloadTable('#role_table');
                                        });
                                    } else {
                                        Swal.fire('Error', data.message, 'error');
                                    }
                                },
                            });
                        }
                    });
                });
        });
    </script>
@endpush
@endsection
