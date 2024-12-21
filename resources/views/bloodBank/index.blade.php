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
            <h1 class="page-title">Blood Banks</h1>
            <div class="action-area">
                @can('create BloodBank')
                <a href="{{url('blood_banks/create')}}" class="btn btn-sm btn-success" value="">Create Blood Bank</a>
                @elsecan('view BloodBank')
                <form id="stateFilterForm" action="{{url('blood_banks')}}" method="GET">
                    <div class="item">
                        <label for="state">State</label>
                        <select name="state" id="state" class="form-select form-select-sm" onchange="submitStateFilterForm();">
                            <option value="">None Selected</option>
                            @foreach($states as $state)
                            <option value="{{$state->id}}">{{$state->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <form id="cityFilterForm" action="{{url('blood_banks')}}" method="GET">
                    <div class="item">
                        <label for="city">City</label>
                        <select name="city" id="city" class="form-select form-select-sm" onchange="submitCityFilterForm()">
                            <option value="">None Selected</option>
                            @foreach($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                @endcan
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td>Blood Bank</td>
                        <td>Contact Number</td>
                        <td>City</td>
                        <td>State</td>
                        <td>Address</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bloodBanks as $bloodBank)
                    <tr>
                        <td>{{ $bloodBank->name }}</td>
                        <td>{{ $bloodBank->phone }}</td>
                        <td>{{ $bloodBank->city }}</td>
                        <td>{{ $bloodBank->state }}</td>
                        <td>{{ $bloodBank->address }}</td>
                        <td>
                            @can('delete BloodBank')
                            <a href="{{url('blood_banks/'.$bloodBank->id.'/delete')}}" class="text-primary" title="Delete Blood Bank"><i class="mdi mdi-trash-can-outline delete-icon"></i></a>
                            <a href="{{url('blood_banks/'.$bloodBank->id.'/edit')}}" class="text-primary" title="Edit Blood Bank"><i class="mdi mdi-square-edit-outline"></i></a>
                            @endcan
                            @can('create DonationRequest')
                            <a href="{{ url('donation_requests/create') }}" class="img-icon">
                                <img src="assets/images/question-icon.svg" alt="User">
                            </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav aria-label="Page navigation" class="pagination-nav">
            <ul class="pagination">
                {{ $bloodBanks->links('pagination.bootstrap-4') }}
            </ul>
        </nav>

    </div>
    <script>
        // Assuming you're using jQuery for simplicity
        function delete_blood_bank(bloodBankId) {
            // Make AJAX request to delete blood bank
            $.ajax({
                url: "{{ url('blood_banks/" + bloodBankId + "/delete') }}",
                type: 'DELETE',
                success: function(response) {
                    // Display SweetAlert message based on controller response
                    if (response.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: response.message,
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Display error message using SweetAlert
                    Swal.fire({
                        title: 'Error',
                        text: 'Failed to delete blood bank',
                        icon: 'error'
                    });
                }
            });
        }

        function submitStateFilterForm() {
            $('#stateFilterForm').submit();
        }

        function submitCityFilterForm() {
            $('#cityFilterForm').submit();
        }
    </script>

</div>
@endsection