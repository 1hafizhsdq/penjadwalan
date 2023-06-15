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
                    <table class="mt-3 mb-3">
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
                        @if ($schedule->status == null)
                            <tr>
                                <td><b>Tanggal Selesai</b></td>
                                <td>&emsp;:</td>
                                <td>{{ $schedule->end_date}}</td>
                            </tr>
                        @endif
                    </table>
                    @if ($schedule->status == null)
                        <button type="button" class="btn btn-primary mt-4 mb-4" id="add"><i class="bi bi-plus"></i> Tambah Aktivitas Progress</button>
                    @endif
                    <table class="table" id="datatable">
                        <thead>
                            <tr>
                                <th scope="col" width="10%">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Aktivitas Progres</th>
                                <th scope="col">Prosentase</th>
                                <th scope="col">Foto</th>
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
            { data: 'progres'},
            { data: 'foto'},
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
        var i = 0;
        $('#addFoto').click(function(){
            ++i;
            $('#dynamicFile').append(`
                <div class="input-group mb-3">
                    <input class="form-control imgFile" type="file" id="file" accept="jpg,jpeg,png" name="files[`+i+`]">
                    <span class="input-group-text" id="basic-addon1">
                        <a class="rmvFoto"><i class="bi bi-trash-fill text-danger"></i></a>
                    </span>
                </div>
            `)
        });

    }).on('click','#sv', function(){
        var formData = new FormData($('#form-activity')[0]);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('activity.store')}}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
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
            }
        });
    }).on('click','.rmvFoto', function(){
        $(this).closest('.input-group').remove();
    });

    const textInput = document.getElementById('progres');
    textInput.addEventListener('input', (event) => {
        const inputValue = event.target.value;
        const numericValue = inputValue.replace(/\D/g, ''); // Hanya menyisakan angka

        if (inputValue !== numericValue) {
        textInput.value = numericValue;
        }
    });
</script>
@endpush