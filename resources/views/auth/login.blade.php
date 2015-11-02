@extends('_layouts.base')

@section('title', 'Login')

@section('main-content')
    <main class="main bg-grey site-content">
        <div class="block-up block">
            <div class="container">
                <div class="text-center">
                    <img class="block" src="{{ asset('assets/img/logo.png') }}" alt="">
                    <h1 class="title">An automated tool to measure website's quality</h1>
                    <h2 class="subtitle block">Sign in to Suitcoda</h2>
                </div>

                <div class="box box-form">
                    <form class="cf" method="POST" action="{{ action('Auth\AuthController@postLogin') }}" data-validate>
                        {!! csrf_field() !!}
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,l4">
                                <label class="form-label" for="login-user">Username :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,l8">
                                <input id="login-user" class="form-input form-input--block" name="username" type="text" required> <br>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('username') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,l4">
                                <label class="form-label" for="login-pass">Password :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,l8">
                                <input id="login-pass" class="form-input form-input--block" name="password" type="password" required> <br>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg">
                            <div class="bzg_c" data-col="s12,l8" data-offset="l4">
                                <!-- input captcha here -->
                                <img src="{{ Captcha::url() }}" width="100%" alt="Captcha"> <br>
                            </div>
                        </div>

                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,l4">
                                <label class="form-label" for="login-captcha">Captcha :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,l8">
                                <input id="login-captcha" class="form-input form-input--block" name="captcha" type="text" required> <br>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('captcha') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <label class="float-left" for="login-remember">
                            <input id="login-remember" name="remember" type="checkbox">
                            <span>Remember me</span>
                        </label>

                        <button type="submit" class="btn btn--regular btn--primary float-right">Log in</button>
                    </form>
                </div>

                <br>

                <div class="text-center">
                    <a href="{{ action('Auth\PasswordController@getEmail') }}">
                        Forgot password?
                    </a>
                </div>
            </div>
        </div>
    </main>
@stop