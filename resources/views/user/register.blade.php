@extends('layouts.master')

@section('title','Vaccine Registration Form')

@section('content')
<div class="row justify-content-center">
    <h2 class="text-center mb-4">User Registration For Covid Vaccination</h2>
    <div class="mb-3 text-center">
        <a class="btn btn-info" href="{{route('search.vaccination-status')}}" >Check Vaccination Status</a>
    </div>
    @include('layouts.errors')
    <form action="{{route('register.store')}}" method="POST">
        @csrf
        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name">
        </div>

        <!-- NID -->
        <div class="mb-3">
            <label for="nid" class="form-label">NID</label>
            <input type="text" name="nid" class="form-control" id="nid" placeholder="National Identification Number">
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email">
        </div>

        <!-- Phone -->
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter your phone number">
        </div>

        <!-- Vaccine Center (Select Input) -->
        <div class="mb-3">
            <label for="vaccine_center" class="form-label">Select Vaccine Center</label>
            <select class="form-control" name="vaccine_center" id="vaccine_center">
                <option value="">Choose a center</option>
                @foreach($vaccine_centers as $vaccine_center)
                    <option value="{{ $vaccine_center->id }}">{{ $vaccine_center->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="d-grid mb-5">
            <button type="submit" class="btn btn-primary">Register</button>
        </div>
    </form>
</div>
@endsection
