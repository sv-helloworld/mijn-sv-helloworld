@extends('layouts.master')
@section('title', 'Wachtwoord wijzigen')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <p>Hier kun je het wachtwoord van je account wijzigen.</p>

            <form method="post" action="{{ action('Account\PasswordController@update') }}" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group {{ $errors->has('password_current') ? 'has-error' : ''}}">
                    <label for="password_current" class="control-label col-sm-4">Huidig wachtwoord</label>
                    <div class="col-sm-8">
                        <input type="password" name="password_current" id="password_current" class="form-control">
                        {!! $errors->first('password_current', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                    <label for="password" class="control-label col-sm-4">Nieuw wachtwoord</label>
                    <div class="col-sm-8">
                        <input type="password" name="password" id="password" class="form-control">
                        {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                    <label for="password_confirmation" class="control-label col-sm-4">Herhaal wachtwoord</label>
                    <div class="col-sm-8">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        {!! $errors->first('password_confirmation', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <a href="{{ route('account.index') }}" class="btn btn-danger">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Wachtwoord wijzigen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
