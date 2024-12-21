@section('sidebar')
<div class="sidebar">
    <div class="upper-section">
        <h2 class="logo">Blood Donation</h2>
        <button class="btn collapse-menu" type="button" data-collapse-menu>
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="middle-section">
        <nav class="sidenav">
            <ul>
                @can('view BloodBank')
                <li>
                    <a href="{{url('blood_banks')}}" class="{{ request()->routeIs('blood_banks.index') ? 'active' : '' }}">
                        <div class="icon-area">
                            <i class="bi bi-shield-fill-plus"></i>
                        </div>
                        <p>Blood Banks</p>
                    </a>
                </li>
                @endcan
                @can('view Donor')
                <li>
                    <a href="{{url('donors')}}" class="{{ request()->routeIs('donors.index') ? 'active' : '' }}">
                        <div class="icon-area">
                            <i class="mdi mdi-account-group-outline"></i>
                        </div>
                        <p>Donors</p>
                    </a>
                <li>
                    @endcan
                    @can('search Donor')
                <li>
                    <a href="{{url('donors/searchDonors')}}" class="{{ request()->routeIs('donors.searchDonors') ? 'active' : '' }}">
                        <div class="icon-area">
                            <i class="bi bi-search"></i>
                        </div>
                        <p>Search Donors</p>
                    </a>
                </li>
                @endcan
                <li>
                    <a href="@can('create DonationRequest') {{route('donation_requests.create')}} @elsecan('view DonationRequest') {{route('donation_requests.index')}} @endcan" class="@if(request()->routeIs('blood_banks.index') || request()->routeIs('blood_banks.create')) 'active' @endif">
                        <div class="icon-area">
                            <i class="bi bi-chat-left-dots-fill"></i>
                        </div>
                        <p>Donation Request</p>
                    </a>
                </li>
                @can('view BloodBankInventory')
                <li>
                    <a href="{{url('blood_bank_inventory')}}">
                        <div class="icon-area">
                            <i class="mdi mdi-blood-bag"></i>
                        </div>
                        <p>Blood Inventory</p>
                    </a>
                <li>
                    @endcan
            </ul>
        </nav>
    </div>
    @can('view permission')
    <div class="bottom-section">
        <a href="{{url('permissions')}}" class="btn btn-red">User Permission Management</a>
    </div>
    @endcan
    @can('create Donor')
    <div class="bottom-section">
        <a href="{{url('donors/create')}}" class="btn btn-red">Register as Donor</a>
    </div>
    @endcan
    <a href="{{url('logout')}}" class="btn btn-red m-3">Log out</a>
</div>
@endsection