@extends('layouts.auth')

@section('content')
<div class="container-fluid page-body-wrapper d-flex align-items-center justify-content-center full-page-wrapper auth-page">
    <div class="content-wrapper d-flex align-items-center justify-content-center auth register-bg-1 theme-one w-100">
        <div class="row w-100">
            <div class="col-lg-12 mx-auto">
                <h4 class="fw-300 c-grey-900 mB-40">{{ __('Verify Your Email Address') }}</h4>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
