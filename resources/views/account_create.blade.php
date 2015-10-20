@extends('_layouts.pages')

@section('title')
    @parent - Create New Account
@stop

@section('main-content')
    @parent
    <main class="main bg-grey site-content">
        <div class="block-up block">
            <div class="container">
                
                <h1 class="title text-center block block-up">Create New Account</h1>

                <div class="box box-form box-form--wide block">
                    <form method="POST" action="{{ route('user.store') }}" data-validate>
                    {!! csrf_field() !!}
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="acc-name" class="form-label">Name :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="acc-name" class="form-input form-input--block" name="name" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="acc-username" class="form-label">Username :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="acc-username" class="form-input form-input--block" name="username" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('username') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="acc-email" class="form-label">Email :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="acc-email" class="form-input form-input--block" name="email" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="acc-pass" class="form-label">Password :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="acc-pass" class="form-input form-input--block" name="password" type="password" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="acc-confpass" class="form-label">Confirm Password :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="acc-confpass" class="form-input form-input--block" name="password_confirmation" type="password" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="acc-role" class="form-label">Role :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <select id="acc-role" class="form-input form-input--block" name="is_admin" id="" required>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn--primary btn--regular">
                                Save
                            </button>
                            <a class="btn btn--secondary btn--regular" href="{{ route('user.index') }}">
                                Discard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@stop