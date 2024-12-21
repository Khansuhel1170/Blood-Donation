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
                <h2 class="card-title">Login</h2>
                <p>Please enter your details to log into your account</p>
            </div>

            <form id="login-form" method="POST" action="{{route('authenticate')}}">
                @csrf
                <div class="auth-form">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="user_id">User Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="User Email" value="{{ old('email') }}" data-rule-required='true'>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" data-rule-required='true'>
                            </div>
                        </div>
                    </div>
                    <div class="form-action-area">
                        <button type="submit" class="btn btn-red btn-fluid">Login</button>
                    </div>
                </div>
            </form>

            <div class="auth-bottom-area">
                <p>Don't have an account? <a href="{{route('signup')}}" class="btn btn-link">Sign up</a></p>
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
    document.addEventListener('DOMContentLoaded', function() {
        var message = document.getElementById('message');
        var closeBtn = document.getElementById('close-message');

        setTimeout(function() {
            hideMessage();
        }, 10000);

        // Function to hide message
        function hideMessage() {
            message.classList.add('hidden');
        }

        // Event listener for close button
        closeBtn.addEventListener('click', function() {
            hideMessage();
        });
    });
</script>
@endsection