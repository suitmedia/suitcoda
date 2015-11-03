@extends('_layouts.base')

@section('title')
    @parent - Reset Password
@stop

@section('main-content')
    <main class="main bg-grey site-content">
        <div class="block-up block-double">
            <div class="container">
                
                <h1 class="title text-center block-double block-up">Please Reset Your Password Here</h1>

                <div class="box box-form box-form--wide block-quad">
                    <form method="POST" action="{{ action('Auth\PasswordController@postReset') }}" data-validate>
                        {!! csrf_field() !!}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m5">
                                <label for="email" class="form-label">Email :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m7">
                                <input id="email" class="form-input form-input--block" name="email" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m5">
                                <label for="new-pass" class="form-label">New Password :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m7">
                                <input id="new-pass" class="form-input form-input--block" name="password" type="password" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m5">
                                <label for="new-pass-conf" class="form-label">Confirm New Password :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m7">
                                <input id="new-pass-conf" class="form-input form-input--block" name="password_confirmation" type="password" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn--primary btn--regular">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@stop