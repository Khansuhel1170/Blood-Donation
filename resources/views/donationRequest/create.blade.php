@extends('layouts.main')

@section('head')
@include('layouts.head', ['title' => "Donation Request"])
@endsection

@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('header')
@include('layouts.header')
@endsection

@section('footer')
@include('layouts.footer')
@endsection

@section('success-error')

@if(Session::has('error'))
<div id="message" class="message">
    <span id="message-error"><b>{{ Session::get('error') }}</b></span>
    <button id="close-message">&times;</button>
</div>
@endif

@if(Session::has('success'))
<div id="message" class="message">
    <span id="message-success"><b>{{ Session::get('success') }}</b></span>
    <button id="close-message">&times;</button>
</div>
@endif

@endsection

@section('main-content')
<div class="content-wrapper">

    <div class="container-fluid">

        <div class="heading-area">
            <h1 class="page-title">Donation Request</h1>
            <div class="action-area"></div>
        </div>

        <div class="container px-0">
            <div class="card">
                <div class="card-body">
                    <form id="donation_request" method="POST" action="{{url('donation_requests')}}">
                        @csrf
                        <div class="container form-container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" value="@if(old('name')!=''){{old('name')}}@else{{trim($donor->donor_name)}}@endif" data-rule-requiredMin2Max60NoSpecial="true">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" value="@if(old('mobile')!=''){{old('mobile')}}@else{{trim($donor->mobile)}}@endif" data-rule-mobile="true">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" data-rule-email="true" value="@if(old('email')!=''){{old('email')}}@else{{trim($donor->email)}}@endif">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select name="state" id="state" class="form-select" data-rule-required="true">
                                            <option value="">-- State --</option>
                                            @foreach($states as $state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" class="form-select" data-rule-required="true">
                                            <option value="">-- City --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="blood_group">Blood Group</label>
                                        <select name="blood_group" id="blood_group" class="form-select" data-rule-required="true">
                                            <option value="">-- Blood Group --</option>
                                            <option value="A+" @if(old('blood_group')=="A+" || $donor->blood_group =="A+") Selected @endif >A+</option>
                                            <option value="A-" @if(old('blood_group')=="A-" || $donor->blood_group =="A-") Selected @endif >A-</option>
                                            <option value="B+" @if(old('blood_group')=="B+" || $donor->blood_group =="B+") Selected @endif >B+</option>
                                            <option value="B-" @if(old('blood_group')=="B-" || $donor->blood_group =="B-") Selected @endif >B-</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="medical_condition">Medical Condition Description</label>
                                        <textarea name="medical_condition" id="medical_condition" rows="3" placeholder="Medical Condition Description" class="form-control" data-rule-required="true">{{old('medical_condition')}}</textarea>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-red px-5 my-4">Submit</button>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var baseUrl = "{{ url('/') }}";

        // Handle state change event
        $('#state').change(function() {
            var stateId = $(this).val();
            // Load districts based on selected state
            $.ajax({
                url: baseUrl + '/stateTocities/' + stateId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#city').empty().append('<option value="">Select City</option>');
                    $.each(data, function(index, city) {
                        $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities:', error);
                }
            });
        });

        $("#donation_request").validate({
            errorClass: "text-danger",
            submitHandler: function(form) {
                // If form is valid, submit the form
                form.submit();
            }
        });
    });
</script>
@endsection