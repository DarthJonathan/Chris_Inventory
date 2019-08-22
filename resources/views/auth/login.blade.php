@extends('layouts.auth')

@section('content')
    <div class="container-fluid page-body-wrapper d-flex align-items-center justify-content-center full-page-wrapper auth-page">
        <div class="content-wrapper d-flex align-items-center justify-content-center auth register-bg-1 theme-one w-100">
            <div class="row w-100">
                <div class="col-lg-12 mx-auto">
                    <h4 class="fw-300 c-grey-900 mB-40">Login</h4>
                    <form method="post" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="text-normal text-dark">Username</label>
                            <input id="email" type="email" placeholder="Username" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>
                                        {{ $errors->first('email') }}
                                    </strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="text-normal text-dark">Password</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="peers ai-c jc-sb fxw-nw">
                                <div class="peer">
                                    <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                                        <input class="peer" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label for="inputCall1" class=" peers peer-greed js-sb ai-c">
                                            {{ __('Keep me signed in') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="peer">
                                    <button class="btn btn-primary">Login</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="peers ai-c">
                                <div class="peer">
                                    <a class="text-small forgot-password text-black ml-2" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
