@extends('layouts.layout')

@section('title', $title)

@section('content')
<div class="pagetitle">
    <h1>{{ $title }}</h1>
</div><!-- End Page Title -->
<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-6 col-md-6">
            <div class="card info-card sales-card alert-warning">
                <div class="card-body">
                    <h5 class="card-title">PROJECT BERJALAN</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-alarm"></i>
                        </div>
                        <div class="ps-3">
                            <h2>{{ $jmlPekerjaan->berjalan }} Project</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-md-6">
            <div class="card info-card sales-card alert-success">
                <div class="card-body">
                    <h5 class="card-title">PROJECT SELESAI</h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-check2-circle"></i>
                        </div>
                        <div class="ps-3">
                            <h2>{{ $jmlPekerjaan->selesai }} Project</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="mt-5" id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('script')
{{-- <script src="{{asset('fullcalendar/')}}/fullcalendar.js"></script> --}}
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery.min.js'></script>
<script src="http://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='http://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            timeZone: 'local',
            defaultDate: new Date(),
            editable: true,
            eventLimit: true,
        });
    });
</script>
@endpush