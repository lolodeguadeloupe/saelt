@extends('front.layouts.layout')

@section('content')
    <section class="background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: url('assets/img/ct_sea-418742_1920.jpg');">
        <div class="container mt-5 pt-4">
            <div class="row">
                <div class="col-md">
                    <h1 class="text-uppercase">@lang('Login')</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <p class="text-center">@lang('Sign in to start your session')</p>

                    <!-- Session Status -->
                    <x-auth.session-status :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth.validation-errors :errors="$errors" />

                    <form class="" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                        <x-auth.input-email />

                        <!-- Password -->
                        <x-auth.input-password />

                        <div class="row">
                            <div class="col-8">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="remember_me" id="remember_me" {{ old('remember_me') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember_me">@lang('Remember me')</label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-4 text-right">
                                <x-auth.submit title="Login" />
                            </div>
                            <!-- /.col -->
                        </div>

                        <div>
                            <p class="mb-1">
                                <a href="{{ route('password.request') }}" class="mr-2">@lang('Forgot Your Password?')</a>
                            </p>
                            <p class="mb-0">
                                <a href="{{ route('register') }}" class="text-center">@lang('Not registered?')</a>
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
