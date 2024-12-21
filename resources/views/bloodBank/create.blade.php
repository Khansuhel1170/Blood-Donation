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

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Add Blood Bank
        </div>
        <div class="card-body">
            <form class="validate_form" id="blood_bank_form" action="@if(!empty($bloodBank->id)) {{url('blood_banks/'.$bloodBank->id)}} @else {{ url('blood_banks') }} @endif" method="POST">
                @csrf
                @if(!empty($bloodBank->id))
                @method('PUT')
                @endif
                <div class="mb-12">
                    <label for="name" class="form-label">Name of the Blood Bank</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Please enter the name" value="{{ old('name') !='' ? old('name'): $bloodBank->name }}" data-rule-firstname="true">
                    @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="contact_no" class="form-label">Contact Number</label>
                        <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Please enter the phone number" value="{{ old('mobile') !='' ? old('mobile'): $bloodBank->phone }}" data-rule-mobile="true">
                        @error('contact_no')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Please enter the email" value="{{old('email') !='' ? old('name'): $bloodBank->email }}" data-rule-email="true">
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address Line</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Please enter the address" value="{{ old('address') !='' ? old('address'): $bloodBank->address }}" data-rule-addressLine1="true">
                    @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="mb-3 col-md-4">
                        <label for="state" class="form-label">State</label>
                        <select class="form-select" id="state" name="state" data-rule-mandatory="true">
                            <option value="">--Select State--</option>
                            @foreach ($states as $state)
                            <option value="{{ $state->name }}_{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="district" class="form-label">District</label>
                        <select class="form-select" id="district" name="district" data-rule-mandatory="true">
                            <option value="">--Select District--</option>
                        </select>
                        @error('district')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 col-md-4">
                        <label for="city" class="form-label">City</label>
                        <select class="form-select" id="city" name="city" data-rule-mandatory="true">
                            <option value="">--Select City--</option>
                            @error('city')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </select>
                    </div>
                </div>

                <fieldset class="mb-3">
                    <legend class="col-form-label pt-0">Type of Blood Bank</legend>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="blood_bank_type" id="public" value="public" @if(old('blood_bank_type')=='public' || $bloodBank->type == 'public') Checked @endif>
                                <label class="form-check-label" for="public">Public</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="blood_bank_type" id="private" value="private" @if(old('blood_bank_type')=='private' || $bloodBank->type == 'private') Checked @endif>
                                <label class="form-check-label" for="private">Private</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="blood_bank_type" id="hospital_based" value="hospital_based" @if(old('blood_bank_type')=='hospital_based' || $bloodBank->type == 'hospital_based') Checked @endif>
                                <label class="form-check-label" for="private">Hospital Based</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="blood_bank_type" id="independent" value="independent" checked @if(old('blood_bank_type')=='independent' || $bloodBank->type == 'independent') Checked @endif>
                                <label class="form-check-label" for="private">Independent</label>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <div class="mb-3">
                    <label for="license" class="form-label">License/Certification Number</label>
                    <input type="text" class="form-control" id="license_no" name="license_no" placeholder="Please enter the license/certification number" value="{{ old('license_no') !="" ? old('license_no'): $bloodBank->license_no }}" data-rule-mandatory="true">
                    @error('license_certificate_no')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Blood Types Available</label>
                    <!-- Add checkboxes for blood types -->
                    @foreach($bloodGroups as $bloodGroup)
                    @php
                    $checkbloodgroup = explode(',', $bloodBank->blood_type_available);
                    @endphp
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="{{ $bloodGroup }}" id="bloodType_{{ $bloodGroup }}" name="blood_types[]" @if(in_array($bloodGroup, old('blood_types', [])) || in_array($bloodGroup, $checkbloodgroup)) checked @elseif($bloodGroup == 'A+') Checked @endif>
                        <label class="form-check-label" for="bloodType_{{ $bloodGroup }}">{{ $bloodGroup }}</label>
                    </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var baseUrl = "{{ url('/') }}";

        // Handle state change event
        $('#state').change(function() {
            var stateId = $(this).val();
            //explode stateId with '_'
            var stateId = stateId.split('_')[1];
            // Load districts based on selected state
            $.ajax({
                url: baseUrl + '/districts/' + stateId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#district').empty().append('<option value="">Select District</option>');
                    $.each(data, function(index, district) {
                        $('#district').append('<option value="' + district.name + '_' + district.id + '">' + district.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching districts:', error);
                }
            });

        });

        // Handle district change event
        $('#district').change(function() {
            var districtId = $(this).val();
            //explode districtId with '_'
            var districtId = districtId.split('_')[1];
            // Load cities based on selected district
            $.ajax({
                url: baseUrl + '/cities/' + districtId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#city').empty().append('<option value="">Select City</option>');
                    $.each(data, function(index, city) {
                        $('#city').append('<option value="' + city.name + '_' + city.id + '">' + city.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching cities:', error);
                }
            });

        });
        $("#blood_bank_form").validate({
            errorClass: "text-danger",
            submitHandler: function(form) {
                // If form is valid, submit the form
                form.submit();
            }
        });
    });
</script>
@endsection