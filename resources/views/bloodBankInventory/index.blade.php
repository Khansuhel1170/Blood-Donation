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
<div class="container-fluid">
    <div class="heading-area">
        <h1 class="page-title">Blood Inventory</h1>
        <div class="button-area">
            @can('create BloodBankInventory')
            <!-- Button to open the side panel -->
            <button id="openPanelBtn" class="btn btn-success">Add Blood Bags</button>
            @endcan
        </div>
    </div>
    <!-- Side panel (initially hidden) -->
    <div id="sidePanel" class="side-panel p-3" style="display: none;">
        <!-- Panel content -->
        <div class="side-panel-header">
            <h5 class="page-title m-3 ">Add Blood Bags</h5>
            <button id="closePanelBtn" class="btn btn-dark close-btn">&times;</button>
        </div>
        <div class="side-panel-body p-3">
            <!-- Your form goes here -->
            <form id="addBloodBagForm" action="{{ url('blood_bank_inventory') }}" method="POST">
                @csrf <!-- CSRF token for security -->
                <div class="form-group">
                    <label for="blood_bank">Blood Bank</label>
                    <select id="blood_bank" name="blood_bank" class="form-select" data-rule-mandatory="true">
                        <option value="">Select Blood Bank</option>
                        @foreach($blood_banks as $blood_bank)
                        <option value="{{ $blood_bank->id }}">{{ $blood_bank->name }}</option>
                        @endforeach
                    </select>
                    @error('blood_bank')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="blood_group">Blood Group</label>
                    <select id="blood_group" name="blood_group" class="form-select" data-rule-mandatory="true">
                        <option value="">Select Blood Group</option>
                        @foreach($blood_groups as $blood_group)
                        <option value="{{ $blood_group }}">{{ $blood_group }}</option>
                        @endforeach
                    </select>
                    @error('blood_group')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity of Blood Bags</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" placeholder="Add minimum 1 quanity of Blood Bag" data-rule-mandatorynumber="true">
                    @error('quantity')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="collectionDate">Date of Collection</label>
                    <input type="date" id="collectionDate" name="collectionDate" class="form-control" placeholder="" data-rule-mandatory="true">
                    @error('collectionDate')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-dark mt-2 pl-3 pr-3" onclick="closeSidePanel()">Cancel</button>
                    <button type="submit" class="btn btn-primary mt-2 pl-3 pr-3">Add</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Background cover (initially hidden) -->
    <div id="panelCover" class="panel-cover"></div>

    @if($bloodBankInventories->isEmpty())
    <div class="alert alert-info" role="alert">
        No Blood Bag Found.
    </div>
    @else
    <div class="row">
        @foreach($bloodBankInventories as $bags)
        <div class="col-md-3 mb-3">
            <div class="card blood-type-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="blood-info">
                            <h8 class="card-subtitle mb-2 text-muted">Bags available</h8>
                            <h6 class="card-title">{{ $bags->bags_count }} Bags</h6>
                        </div>
                        <div class="blood-group">
                            <span class="blood_drop" style="background-image: url({{asset('assets/images/vector.png')}})">{{ $bags->blood_group }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@push('scripts')
<script>
    document.getElementById('openPanelBtn').addEventListener('click', function() {
        document.getElementById('sidePanel').style.width = '400px'; // Adjust width as needed
        document.getElementById('sidePanel').style.display = 'block';
    });

    function closeSidePanel() {
        document.getElementById('sidePanel').style.width = '0';
        document.getElementById('sidePanel').style.display = 'none';
    }

    document.getElementById('closePanelBtn').addEventListener('click', closeSidePanel);
    document.getElementById('panelCover').addEventListener('click', closeSidePanel);

    $("#addBloodBagForm").validate({
        errorClass: "text-danger",
        submitHandler: function(form) {
            // If form is valid, submit the form
            form.submit();
        }
    });
</script>
@endpush
@endsection