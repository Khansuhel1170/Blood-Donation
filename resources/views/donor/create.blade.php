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
            <h1 class="page-title">Register as a Donor</h1>
            <div class="action-area"></div>
        </div>

        <div class="container px-0">
            <div class="card">
                <div class="card-body">
                    <form id="register-donor" method="POST" action="@if(!empty($donor->id)) {{url('donors/'.$donor->id)}} @else {{ url('donors') }} @endif">
                        @csrf
                        @if(!empty($donor->id))
                        @method('PUT')
                        @endif
                        <div class="container form-container">
                            <div class="row">
                                <h6 class="my-3 w-100">Personal Details</h6>

                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" value="{{ old('name') !=''
                                             ? old('name'): $donor->donor_name }}" data-rule-requiredMin2Max60NoSpecial='true'>
                                        @error('name')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender" class="form-select" data-rule-required='true'>
                                            <option value="">Select</option>
                                            <option value="male" @if(old('gender')=='male' || $donor->gender == 'male') Selected @endif>Male</option>
                                            <option value="female" @if(old('gender')=='female' || $donor->gender == 'female') Selected @endif>Female</option>
                                            <option value="other" @if(old('gender')=='other' || $donor->gender == 'other') Selected @endif>Other</option>
                                        </select>
                                        @error('gender')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" name="dob" id="dob" class="form-control" data-rule-required="true" value="{{ old('dob') !='' ? old('dob'): $donor->dob }}">
                                    </div>
                                    @error('dob')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="blood_group">Blood Group</label>
                                        <select name="blood_group" id="blood_group" class="form-select" data-rule-required="true">
                                            <option value="">Select</option>
                                            <option value="A+" @if(old('blood_group')=='A+' || $donor->blood_group == 'A+') Selected @endif>A+</option>
                                            <option value="A-" @if(old('blood_group')=='A-' || $donor->blood_group == 'A-') Selected @endif>A-</option>
                                            <option value="B+" @if(old('blood_group')=='B+' || $donor->blood_group == 'B+') Selected @endif>B+</option>
                                            <option value="B-" @if(old('blood_group')=='B-' || $donor->blood_group == 'B-') Selected @endif>B-</option>
                                        </select>
                                        @error('blood_group')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <h6 class="my-3 w-100">Contact Details</h6>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="mobile">Mobile Number</label>
                                        <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number" data-rule-mobile="true" value="{{old('mobile') !='' ? old('mobile'): $donor->mobile}}">
                                    </div>
                                    @error('mobile')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" data-rule-email="true" value="{{old('email') !='' ? old('email'): $donor->email}}">
                                    </div>
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <h6 class="my-3 w-100">Location Details</h6>

                                <div class="col-lg-4">
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
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="district">District</label>
                                        <select name="district" id="district" class="form-select" data-rule-required="true">
                                            <option value="">-- District --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" class="form-select" data-rule-required="true">
                                            <option value="">-- City --</option>
                                        </select>
                                    </div>
                                </div>

                                <h6 class="w-100 my-3">Donor Specific Information</h6>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="donation_date">Late Date of Donation</label>
                                        <input type="date" name="donation_date" id="donation_date" class="form-control" data-rule-required="true" value="{{old('donation_date') !='' ? old('donation_date'): $donor->late_donation_date}}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="preference">Unit of Blood</label>
                                        <input type="number" name="preference" id="preference" class="form-control" placeholder="Blood preference in unit " data-rule-digit="true" value="{{ old('preference') !='' ? old('preference') : $donor->total_donation_unit }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Have you donated previously</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="donated_previously" id="donated_previously_1" value="1">
                                                <label class="form-check-label" for="donated_previously_1">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="donated_previously" id="donated_previously_2" value="0" checked>
                                                <label class="form-check-label" for="donated_previously_2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>In the last six months have you had any of the
                                            following?</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="last_six_months_procedures" id="following_1" value="Tattooing">
                                                <label class="form-check-label" for="following_1">Tattooing</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="last_six_months_procedures" id="following_2" value="Piercing">
                                                <label class="form-check-label" for="following_2">Piercing</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="last_six_months_procedures" id="following_3" value="Dental extraction">
                                                <label class="form-check-label" for="following_3">Dental
                                                    extraction</label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="last_six_months_procedures" id="following_3" value="Not Any" checked>
                                                <label class="form-check-label" for="following_3">Not Any</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <!-- <div class=""> -->
                                        <input class="form-check-input" type="checkbox" id="agree" name="form_agreement" data-rule-required="true">
                                        <label class="form-check-label" for="agree">
                                            I agree to be contacted by blood banks, SBTCs and NBTC
                                        </label>
                                        <!-- </div> -->
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
                url: baseUrl + '/districts/' + stateId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#district').empty().append('<option value="">Select District</option>');
                    $.each(data, function(index, district) {
                        $('#district').append('<option value="' + district.id + '">' + district.name + '</option>');
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
            // Load cities based on selected district
            $.ajax({
                url: baseUrl + '/cities/' + districtId,
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
        $("#register-donor").validate({
            errorClass: "text-danger",
            submitHandler: function(form) {
                // If form is valid, submit the form
                form.submit();
            }
        });
    });
</script>
@endsection