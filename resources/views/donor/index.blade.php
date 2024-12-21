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
            <h1 class="page-title">Donors</h1>
            <div class="action-area mt-2">
                @can('export Donors')
                <div class="item">

                    <a href="{{url('donors/export')}}" class="btn btn-sm btn-primary mt-4">Export</a>
                </div>
                @elsecan('search Donor')
                <div class="item">
                    <form id="search_blood_bank" action="{{url('donors/searchDonorsResult')}}" method="GET">
                        <label for="city">City</label>
                        <select name="city" id="city" class="form-select form-select-sm">
                            <option value="">None Selected</option>
                            @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                @endcan
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>Donor Name</td>
                        <td>Blood Group</td>
                        <td>Contact Number</td>
                        <td>State</td>
                        <td>City</td>
                        <td>Address</td>
                        @canany(['update Donor', 'delete Donor', 'verify Donor'])
                        <td>Action</td>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @foreach($donors as $donor)
                    <tr>
                        <td>{{$donor->donor_name}}</td>
                        <td>{{$donor->blood_group}}</td>
                        <td>{{$donor->mobile}}</td>
                        <td>{{$donor->state_name}}</td>
                        <td>{{$donor->city_name}}</td>
                        <td>{{$donor->user_address}}</td>
                        <td>
                            @can('delete Donor')
                            <a href="{{url('donors/'.$donor->id.'/delete')}}" class="btn btn-sm btn-danger"><i class="mdi mdi-trash-can-outline"></i></a>
                            @endcan
                            @can('update Donor')
                            <a href="{{url('donors/'.$donor->id.'/edit')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-square-edit-outline"></i></a>
                            @endcan
                            @can('verify Donor')
                            @if($donor->status != 'pending')
                            <i class="mdi mdi-check-decagram btn btn-sm btn-success"></i>
                            @else
                            <a href="{{url('donors/'.$donor->id.'/verify')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-check-decagram"></i></a>
                            @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation" class="pagination-nav">
            <ul class="pagination">
                {{ $donors->links('pagination.bootstrap-4') }}
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