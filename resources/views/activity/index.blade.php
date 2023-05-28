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
                    <input type="hidden" name="uuid_schedule" id="uuid_schedule" value="{{ $schedule->id }}">
                    <table class="mt-3">
                        <tr>
                            <td><b>Project</b></td>
                            <td>&emsp;:</td>
                            <td>{{ $schedule->project->project }}</td>
                        </tr>
                        <tr>
                            <td><b>Tanggal Mulai</b></td>
                            <td>&emsp;:</td>
                            <td>{{ $schedule->start_date}}</td>
                        </tr>
                        <tr>
                            <td><b>Deadline</b></td>
                            <td>&emsp;:</td>
                            <td>{{ $schedule->due_date}}</td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-primary mt-4 mb-4" id="add"><i class="bi bi-plus"></i> Tambah Aktivitas Progress</button>
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Aktivitas Progres</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('activity.form')
</section>
@endsection

@push('script')
<script>
    $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: '/list-activity/{{ $schedule->id }}',
        },
        columns: [
            { data: 'DT_RowIndex', class: 'text-center'},
            { data: 'tgl'},
            { data: 'activity'},
        ]
    });

    $(document).ready(function() {
        $('#add').click(function(){
            $('#form-activity').find('input').val('');
            $('#modal-activity').modal('show');
            $('.modal-title').html('Form Tambah Progres');
            $('#schedule_id').val($('#uuid_schedule').val());
            $('#sv').html('Simpan');
        });
    }).on('click','#sv', function(){
        var id = $('#id').val(),
            url = '',
            method = '';

        var form = $('#form-activity'),
            data = form.serializeArray();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('activity.store')}}",
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
                    $('#modal-activity').modal('hide');
                    $('#form-activity').find('input').val('');
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
</script>
@endpush