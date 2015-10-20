@extends('_layouts.pages')

@section('title')
    @parent - Edit Account
@stop

@section('main-content')
    @parent
    <main class="main bg-grey site-content">
        <div class="block-up block">
            <div class="container">
                
                <h1 class="title text-center block block-up">Edit Account</h1>

                <div class="box box-form box-form--wide block">
                    {!! Form::model($model, ['route' => ['user.update', $model], 'method' => 'PUT', 'data-validate']) !!}
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="edit-name" class="form-label">Name :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="edit-name" class="form-input form-input--block" name="name" value="{{ $model->name }}" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="edit-username" class="form-label">Username :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="edit-username" class="form-input form-input--block" name="username" value="{{ $model->username }}" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('username') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="edit-email" class="form-label">Email :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="edit-email" class="form-input form-input--block" name="email" value="{{ $model->email }}" type="text" required>
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="edit-pass" class="form-label">Password :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="edit-pass" class="form-input form-input--block" name="password" value="" type="password">
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="edit-confpass" class="form-label">Confirm Password :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                <input id="edit-confpass" class="form-input form-input--block" name="password_confirmation" value="" type="password">
                                @if (\Session::has('errors'))
                                    <span style="font-size:13px; color:red;">{{ \Session::get('errors')->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="bzg block-half">
                            <div class="bzg_c" data-col="s12,m4">
                                <label for="edit-role" class="form-label">Role :</label>
                            </div>
                            <div class="bzg_c" data-col="s12,m8">
                                {!! Form::select('is_admin', [false => 'User', true => 'Admin'], $model->is_admin, ['id' => 'edit-role', 'class' => 'form-input form-input--block', 'required']) !!}
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
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </main>
@stop