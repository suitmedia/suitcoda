@extends('_layouts.base')

@section('title')
    @parent - Forgot Password
@stop

@section('main-content')
    <main class="main bg-grey site-content">
        <div class="block-up block-double">
            <div class="container">
                
                <h1 class="title text-center block-double block-up">Forgot Password?</h1>

                <div class="box box-form box-form--wide">
                    <form method="POST" action="{{ action('Auth\PasswordController@postEmail') }}" data-validate>
                        {!! csrf_field() !!}
                        <div class="bzg block">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="forgot-email" class="form-label">Email :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="forgot-email" class="form-input form-input--block" name="email" placeholder="Input your email here ...." type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('email') }}</span>
                                @elseif (\Session::has('status'))
                                    <span style="font-size:13px; color:green;">{{ \Session::get('status') }}</span>
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