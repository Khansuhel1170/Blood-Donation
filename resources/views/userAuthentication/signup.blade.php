@extends('layouts.login')
@section('head')
@include('layouts.login_head', ['title' => "Sign up"])
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
<div class="auth-wrapper">
    <div class="card auth-card">
        <div class="card-body">
            <div class="auth-header">
                <h2 class="card-title">Sign up</h2>
            </div>

            <form id="signup-form" action="{{route('register')}}" method="POST">
                @csrf
                <div class="auth-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" placeholder="Name" data-rule-firstname='true'>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class=" col-12">
                            <div class="form-group">
                                <label>Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" {{ old('gender') == 'male' ? 'checked' : '' }} name="gender" id="male" value="male">
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" {{ old('gender') == 'female' ? 'checked' : '' }} name="gender" id="female" value="female">
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="other" value="other" @if( old('gender') == 'other' || old('gender') == '') checked @endif>
                                        <label class="form-check-label" for="other">Other</label>
                                    </div>
                                    @error('gender')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email" data-rule-email='true' value="{{old('email')}}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="phone">Contact Number</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" data-rule-mobile='true' value="{{old('phone')}}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select name="city" id="city" data-rule-mandatory='true' class="form-control">
                                    <option value="">-- Select City --</option>
                                    @foreach($cities as $city)
                                    <option value="{{$city->id}}" {{ old('city') == $city->id ? 'selected' : '' }}>{{$city->name}}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Address" data-rule-addressline1='true' value="{{old('address')}}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" data-rule-passwd='true'>
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-action-area">
                        <button type="submit" class="btn btn-red btn-fluid">Sign up</button>
                    </div>
                </div>
            </form>

            <div class="auth-bottom-area">
                <p>Already have an account? <a href="{{route('login')}}" class="btn btn-link">Login</a></p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#signup-form").validate({
            errorClass: "text-danger",
            submitHandler: function(form) {
                // If form is valid, submit the form
                form.submit();
            }
        });
    });
</script>
@endsection