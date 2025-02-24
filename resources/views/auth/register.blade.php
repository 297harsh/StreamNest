@extends('layouts.app')

@section('content')
    <!-- Normal Breadcrumb Begin -->
    <section class="normal-breadcrumb set-bg" data-setbg="{{ asset('img/normal-breadcrumb.jpg') }}"
        style="margin-top: -25px; background-color: #0b0c2a">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Sign Up</h2>
                        <p>Welcome to the official Anime blog.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Normal Breadcrumb End -->

    <!-- Signup Section Begin -->
    <section class="signup spad" style="background-color: #0b0c2a">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="login__form">
                        <h3>Sign Up</h3>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="input__item ">
                                <input id="email" type="email" placeholder="Email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror <span class="icon_mail"></span>
                            </div>
                            <div class="input__item">
                                <input id="name" type="text" placeholder="Name"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror <span class="icon_profile"></span>
                            </div>
                            <div class="input__item">
                                <input id="password" type="password" placeholder="Password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror <span class="icon_lock"></span>
                            </div>
                            <div class="input__item">
                                <input id="password-confirm" type="password" placeholder="Confirm Password"
                                    class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <span class="icon_lock"></span>
                            </div>
                            <button type="submit" class="site-btn">Login Now</button>
                        </form>
                        <h5>Already have an account? <a href="{{ route('login') }}">Log In!</a></h5>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Signup Section End -->
@endsection
