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
            <h1 class="page-title">New Donation Request</h1>
        </div>

        <div class="card">
            <div class="card-body p-5">
                <table>
                    <tbody>
                        <tr class="mb-3">
                            <td class="pb-4">Full Name:</td>
                            <td class="pb-4">{{$donationRequest->donor_name}}</td>
                        </tr>
                        <tr class="">
                            <td class="pb-4">Contact Number:</td>
                            <td class="pb-4">{{$donationRequest->mobile}}</td>
                        </tr>
                        <tr class="">
                            <td class="pb-4">Email:</td>
                            <td class="pb-4">{{$donationRequest->email}}</td>
                        </tr>
                        <tr class="">
                            <td class="pb-4">Blood Group:</td>
                            <td class="pb-4">{{$donationRequest->blood_group}}</td>
                        </tr>
                        <tr class="">
                            <td class="pb-4">Medical Condition Description:</td>
                            <td class="pb-4">{{$donationRequest->medical_condition}}</td>
                        </tr>

                        <tr class="">
                            @if($donationRequest->status != 'approved' )
                            <td class="pb-4"><a href="{{url('donation_requests/'.$donationRequest->id.'/approveDonationRequest')}}" class="btn btn-success">Accept</a></td>
                            <td class="pb-4"><a href="{{url('donation_requests/'.$donationRequest->id.'/delete')}}" class="btn btn-sm btn-danger"> Discard</a></td>
                            @else
                            <td class="pb-4"><span class="text-success"><b>Approved</b></span></td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

@endsection