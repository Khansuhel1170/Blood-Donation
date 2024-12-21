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
            <div class="action-area">
                <div class="item">
                    @can('export DonationRequest')
                    <a href="{{url('donation_requests/export')}}" class="btn btn-sm btn-primary">Export</a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>Name</td>
                        <td>Contact Number</td>
                        <td>Email</td>
                        <td>State</td>
                        <td>City</td>
                        <td>Blood Group</td>
                        @canany(['delete DonationRequest', 'approve DonationRequest'])
                        <td>Action</td>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach($donation_requests as $donation_request)
                    <tr>
                        @can('open DonationRequest')
                        <td><a href="{{url('donation_requests/'.$donation_request->id.'/openNewRequest')}}">{{$donation_request->donor_name}}</a></td>
                        @elsecan('view DonationRequest')
                        <td>{{$donation_request->donor_name}}</td>
                        @endcan
                        <td>{{$donation_request->mobile}}</td>
                        <td>{{$donation_request->email}}</td>
                        <td>{{$donation_request->state_name}}</td>
                        <td>{{$donation_request->city_name}}</td>
                        <td>{{$donation_request->blood_group}}</td>
                        @canany(['delete DonationRequest', 'approve DonationRequest'])
                        <td>
                            <a href="{{url('donation_requests/'.$donation_request->id.'/delete')}}" class=" btn btn-sm btn-warning"><i class="mdi mdi-trash-can-outline delete-icon"></i></a>
                            @if($donation_request->status == 'approved')
                            <i class="mdi mdi-check-decagram btn btn-sm btn-success"></i>
                            @else
                            <a href="{{url('donation_requests/'.$donation_request->id.'/approveDonationRequest')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-check-decagram"></i></a>
                            @endif
                        </td>
                        @endcanany
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation" class="pagination-nav">
            <ul class="pagination">
                {{ $donation_requests->links('pagination.bootstrap-4') }}
            </ul>
        </nav>

    </div>

</div>
<script>
    $(document).ready(function() {
        $('#city').change(function() {
            $('#search_blood_bank').submit();
        });
    });
</script>
@endsection