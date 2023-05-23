@extends('layouts.layout')

@section('title', $title)

@section('content')
<div class="pagetitle">
    <h1>{{ $title }}</h1>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                    <img src="{{asset('foto')}}/{{ $profile->foto ?? 'noprofile.png' }}" alt="Profile" class="rounded-circle">
                    <h2>{{$profile->name}}</h2>
                    <h3>{{$profile->role->role}}</h3>
                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                Profile</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#profile-change-password">Change Password</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade profile-edit pt-3 active show" id="profile-edit">

                            <!-- Profile Edit Form -->
                            <form id="form-profile">
                                @csrf
                                <div class="row mb-3">
                                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                        Image</label>
                                    <div class="col-md-8 col-lg-9">
                                        <img src="{{asset('foto')}}/{{ $profile->foto ?? 'noprofile.png' }}" alt="Profile">
                                        <div class="pt-2">
                                            <a id="add-foto" class="btn btn-primary btn-sm" title="Upload new profile image"><i class="bi bi-upload"></i></a>
                                            <a href="{{ route('del-foto') }}" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="id" value="{{$profile->id}}">
                                <div class="row mb-3">
                                    <label for="name" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text" class="form-control" id="name"
                                            value="{{$profile->name}}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email"
                                            value="{{$profile->email}}">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" id="sv-profile" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form><!-- End Profile Edit Form -->

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <!-- Change Password Form -->
                            <form id="form-password">
                                @csrf
                                <input type="hidden" name="id_password" value="{{$profile->id}}">
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control"
                                            id="currentPassword">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                        Password</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="renewpassword" type="password" class="form-control"
                                            id="renewPassword">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" id="sv-password" class="btn btn-primary">Change Password</button>
                                </div>
                            </form><!-- End Change Password Form -->

                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>
            @includeIf('profile.modal_foto')
        </div>
    </div>
</section>
@endsection

@push('script')
<script>
    $(document).ready(function () {
        $(document).on('click','#sv-profile',function(){
            var id = $('#id').val(),
            url = '',
            method = '';

            var form = $('#form-profile'),
                data = form.serializeArray();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('profile-store')}}",
                method: "POST",
                data: data,
                beforeSend: function() {
                    $("#sv-profile").replaceWith(`
                        <button class="btn btn-primary" type="button" id="loading" disabled="">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    `)
                },
                success: function(result) {
                    if (result.success) {
                        successMsg(result.success)
                        $("#loading").replaceWith(`
                            <button type="button" id="sv-profile" class="btn btn-primary">Save Changes</button>
                        `);
                    } else {
                        errorMsg(result.errors)
                        $("#loading").replaceWith(`
                            <button type="button" id="sv-profile" class="btn btn-primary">Save Changes</button>
                        `);
                    }

                },
            });
        }).on('click','#sv-password',function(){
            var id = $('#id').val(),
            url = '',
            method = '';

            var form = $('#form-password'),
                data = form.serializeArray();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('password-store')}}",
                method: "POST",
                data: data,
                beforeSend: function() {
                    $("#sv-password").replaceWith(`
                        <button class="btn btn-primary" type="button" id="loading" disabled="">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    `)
                },
                success: function(result) {
                    if (result.success) {
                        successMsg(result.success)
                        $("#loading").replaceWith(`
                            <button type="button" id="sv-password" class="btn btn-primary">Change Password</button>
                        `);
                    } else {
                        errorMsg(result.errors)
                        $("#loading").replaceWith(`
                            <button type="button" id="sv-password" class="btn btn-primary">Change Password</button>
                        `);
                    }

                },
            });
        }).on('click','#add-foto', function(){
            $('#form-foto').find('input').val('');
            $('#modal-foto').modal('show');
            $('#sv').html('Simpan');
        }).on('click','#sv',function(){
            // Get the selected file
            var files = $('#image_profile')[0].files;

            if(files.length > 0){
                var fd = new FormData();

                // Append data
                fd.append('file',files[0]);
                // fd.append('_token',CSRF_TOKEN);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // AJAX request
                $.ajax({
                    url: "{{route('foto-store')}}",
                    method: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(result){
                        successMsg(result.success)
                        $('#modal-foto').modal('hide');
                        $("#loading").replaceWith(`
                            <button type="submit" id="sv" class="btn btn-primary">Simpan</button>
                        `);
                        location.reload()
                    },
                    error: function(result){
                        errorMsg(result.errors)
                        $("#loading").replaceWith(`
                            <button type="submit" id="sv" class="btn btn-primary">Simpan</button>
                        `);
                    }
                });
            }else{
                errorMsg("Pilih foto terlebih dahulu")
            }
        });
    });

</script>
@endpush
