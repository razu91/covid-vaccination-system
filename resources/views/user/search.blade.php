@extends('layouts.master')
@section('title','Search Vaccination Status')
@section('content')
<div class="row justify-content-center">
    <form class="mb-5">
        <!-- NID -->
        <div class="mb-3">
            <label for="nid" class="form-label">NID</label>
            <input type="text" name="nid" class="form-control" id="nid" value="{{ request()->query('nid') }}" placeholder="National Identification Number">
        </div>
        <!-- Submit Button -->
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Check Status</button>
        </div>
        <div class="mb-3 text-end mt-3">
            <a href="{{route('register')}}" >Register for Covid Vaccination Service</a>
        </div>
    </form>
    <br>
    @if(request()->has('nid'))
    <h3>NID Number : <span class="text-success">{{ request()->query('nid') }}</span></h3>
    <h3>Status : <b class="text-danger">{{ $status }}</b></h3>
    @endif
</div>
@endsection
