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
            <h1 class="page-title">Search Donors</h1>
            <div class="action-area"></div>
        </div>

        <div class="container px-0">
            <div class="card">
                <div class="card-body">
                    <form id="search_blood_bank" action="{{url('donors/searchDonorsResult')}}" method="GET">
                        <div class="container form-container">
                            <div class="row">

                                <h6 class="my-3 w-100">Location Details</h6>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="state">State</label>
                                        <select name="state" id="state" class="form-select">
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
                                        <select name="district" id="district" class="form-select">
                                            <option value="">-- District --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="city">City</label>
                                        <select name="city" id="city" class="form-select">
                                            <option value="">-- City --</option>
                                        </select>
                                    </div>
                                </div>

                                <h6 class="w-100 my-3">Blood Group Type</h6>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="blood_group">Blood Group</label>
                                        <select name="blood_group" id="blood_group" class="form-select">
                                            <option value="">Select a Blood Group</option>
                                            <option value="1">A+</option>
                                            <option value="1">A-</option>
                                            <option value="1">B+</option>
                                            <option value="1">B-</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-red px-5 my-4">Search</button>
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
        // Handle form submission
        $('#search_blood_bank').submit(function(e) {
            e.preventDefault(); // Prevent form from submitting
            // Get values of all form fields
            var state = $('#state').val();
            var district = $('#district').val();
            var city = $('#city').val();
            var bloodGroup = $('#blood_group').val();

            // Check if any field has value
            if (state || district || city || bloodGroup) {
                // Submit form
                $(this).unbind('submit').submit();
            } else {
                // Show sweet alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Fill at least one field to search'
                });
            }
        });
    });
</script>
@endsection