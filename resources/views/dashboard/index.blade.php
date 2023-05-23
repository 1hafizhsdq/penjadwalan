@extends('layouts.layout')

@section('title', $title)

@section('content')
<div class="pagetitle">
    <h1>{{ $title }}</h1>
</div><!-- End Page Title -->
<section class="section dashboard">
    <div class="row"></div>
</section>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        
    });
</script>
@endpush