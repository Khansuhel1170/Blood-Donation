@section('header')
<div class="header-wrapper">
    <div class="left-area">
        <button class="btn" type="button" data-open-sidebar>
            <i class="bi bi-list"></i>
        </button>
    </div>
    <div class="right-area">
        <div class="profile-card">
            <div class="img-area">
                <img src="{{asset('assets/images/user.svg')}}" alt="User">
            </div>
            <div class="user-details-area">
                <p class="username">{{auth()->user()->name}}</p>
                <p class="user-id">User ID: {{auth()->user()->id}}</p>
            </div>
        </div>
    </div>
</div>
@endsection