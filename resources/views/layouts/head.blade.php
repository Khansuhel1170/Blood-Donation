@section('head')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Blood Banks</title>

<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('assets/css/blood_bank_custom.css') }}">
<!-- /CSS -->

<!-- JS -->
<script defer src="{{asset('assets/js/blood_bank_custom.js')}}"></script>
<script defer src="{{asset('assets/js/main.js')}}"></script>
<script src="{{ asset('assets/js/jquery.js')}}"></script>
<script src="{{ asset('assets/js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/js/validation.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- /JS -->
@endsection