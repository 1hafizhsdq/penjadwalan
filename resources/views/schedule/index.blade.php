@extends('layouts.layout')

@section('title', $title)

@section('content')
<div class="pagetitle">
    <h1>{{ $title }}</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary mt-4 mb-4" id="add"><i class="bi bi-plus"></i> Tambah Schedule</button>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">#</th>
                                <th scope="col">Project</th>
                                <th scope="col">Tanggal Mulai</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Tanggal Selesai</th>
                                <th scope="col">Status</th>
                                <th scope="col">Engineer</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
    @includeIf('schedule.form')
</section>
@endsection

@push('script')
<script>
    $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("list-schedule") }}',
        },
        columns: [
            { data: 'DT_RowIndex', class: 'text-center'},
            { data: 'project_id'},
            { data: 'start_date'},
            { data: 'due_date'},
            { data: 'end_date'},
            { data: 'status'},
            { data: 'user_id'},
            { data: 'information'},
            { data: 'aksi', class: 'text-center'}
        ]
    });

    $(document).ready(function() {
        $('#add').click(function(){
            $('#form-schedule').find('input').val('');
            $('#modal-schedule').modal('show');
            $('.modal-title').html('Form Tambah Jadwal Pekerjaan');
            $('#sv').html('Simpan');
        });
    }).on('click','#sv', function(){
        var id = $('#id').val(),
            url = '',
            method = '';

        var form = $('#form-schedule'),
            data = form.serializeArray();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('schedule.store')}}",
            method: "POST",
            data: data,
            beforeSend: function() {
                $("#sv").replaceWith(`
                    <button class="btn btn-primary" type="button" id="loading" disabled="">
                        <span class="spinner-border spinner-border-sm" schedule="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                `)
            },
            success: function(result) {
                if (result.success) {
                    successMsg(result.success)
                    $('#modal-schedule').modal('hide');
                    $('#form-schedule').find('input').val('');
                    $('#datatable').DataTable().ajax.reload();
                    $("#loading").replaceWith(`
                        <button type="submit" id="sv" class="btn btn-primary">Simpan</button>
                    `);
                } else {
                    errorMsg(result.errors)
                    $("#loading").replaceWith(`
                        <button type="submit" id="sv" class="btn btn-primary">Simpan</button>
                    `);
                }

            },
        });
    });

    function editData(id) {
        var form = $('#form-schedule');
        $.ajax({
            url : 'schedule/' + id + '/edit',
            type: 'GET',
            success:function(result){
                form.find('#id').val(result[0].id)
                form.find('#schedule').val(result[0].schedule)
                $('#modal-schedule').modal('show');
                $('.modal-title').html('Form Edit Menu');
                $('#sv').html('Update');
            }
        });
    }

    function deleteData(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Apakah anda yakin akan menghapus data ini?',
            showCancelButton: true,
            confirmButtonText: 'Hapus',
            confirmButtonColor: '#d3455b',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "schedule/" + id,
                    method: 'DELETE',
                    success: function(result) {
                        if (result.success) {
                            successMsg(result.success)
                            $('#datatable').DataTable().ajax.reload();
                        } else {
                            errorMsg(result.errors)
                        }
                    }
                });
            }
        });
    }
</script>
@endpush