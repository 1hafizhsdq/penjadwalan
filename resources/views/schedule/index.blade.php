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
                <div class="card-body p-3">
                    @if (Auth::user()->role_id == 1)
                        <button type="button" class="btn btn-primary mt-4 mb-4" id="add"><i class="bi bi-plus"></i> Tambah Schedule</button>
                    @endif
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">#</th>
                                <th scope="col">Project</th>
                                <th scope="col">Status Urgent</th>
                                <th scope="col">Tanggal Mulai</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Tanggal Selesai</th>
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
    @includeIf('schedule.form-done')
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
            { data: 'project'},
            { data: 'status_urgent'},
            { data: 'start_date'},
            { data: 'due_date'},
            { data: 'end_date'},
            { data: 'user.name'},
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
    }).on('click','#btn-edit', function(){
        var form = $('#form-schedule');
        var id = $(this).data('id');
        $.ajax({
            url : 'schedule/edit',
            type: 'GET',
            data: {id:id},
            success:function(result){
                form.find('#id').val(result.id)
                $("div.selectIngProject select").val(result.project_id).change();
                $("div.selectIngUser select").val(result.user_id).change();
                $("div.selectIngStatusUrgent select").val(result.status_urgent).change();
                form.find('#start_date').val(result.start_date)
                form.find('#due_date').val(result.due_date)
                $('#modal-schedule').modal('show');
                $('.modal-title').html('Form Edit Jadwal Pekerjaan');
                $('#sv').html('Update');
            }
        });
    }).on('click','#btn-done', function(){
        $('#form-done').find('input').val('');
        $('#uuid').val($(this).data('id'));
        $('#modal-done').modal('show');
        $('.modal-title').html('Pekerjaan Selesai');
        $('#sv-done').html('Simpan');
    }).on('click','#sv-done', function(){
        var url = '',
            method = '';

        var form = $('#form-done'),
            data = form.serializeArray();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('schedule.done')}}",
            method: "POST",
            data: data,
            beforeSend: function() {
                $("#sv-done").replaceWith(`
                    <button class="btn btn-primary" type="button" id="loading-done" disabled="">
                        <span class="spinner-border spinner-border-sm" schedule="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                `)
            },
            success: function(result) {
                if (result.success) {
                    successMsg(result.success)
                    $('#modal-done').modal('hide');
                    $('#form-done').find('input').val('');
                    $('#datatable').DataTable().ajax.reload();
                    $("#loading-done").replaceWith(`
                        <button type="submit" id="sv-done" class="btn btn-primary">Simpan</button>
                    `);
                } else {
                    errorMsg(result.errors)
                    $("#loading-done").replaceWith(`
                        <button type="submit" id="sv-done" class="btn btn-primary">Simpan</button>
                    `);
                }

            },
        });
    });
</script>
@endpush