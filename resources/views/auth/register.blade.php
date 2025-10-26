@extends('front.layouts.layout')

@section('content')

    <section class="background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: url('assets/img/ct_sea-418742_1920.jpg');">
        <div class="container mt-5 pt-4">
            <div class="row">
                <div class="col-md">
                    <h1 class="text-uppercase">@lang('Register')</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">

                    <p class="text-center">@lang('Register a new membership')</p>

                    <!-- Validation Errors -->
                    <x-auth.validation-errors :errors="$errors" />

                    <form class="h-add-bottom" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="@lang('Name')" id="name"
                                   name="name" required autofocus
                                   value="{{ old('name') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Email Address -->
                        <x-auth.input-email />

                        <!-- Password -->
                        <x-auth.input-password />

                        <!-- Confirm Password -->
                        <x-auth.input-confirm-password />

                        <div class="text-right">
                            <x-auth.submit title="Register" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
