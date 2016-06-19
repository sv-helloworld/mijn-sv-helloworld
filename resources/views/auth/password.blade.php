@extends('layouts.master')
@section('title', 'Wachtwoord vergeten')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6">
            <p>Als u uw wachtwoord bent vergeten kunt u hieronder uw e-mailadres opgeven. U zal een link toegestuurd krijgen waarmee u uw wachtwoord opnieuw kunt instellen.</p>

            <form method="post" action="{{ action('Auth\PasswordController@postEmail') }}" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="email" class="control-label col-sm-4">E-mailadres</label>
                    <div class="col-sm-8">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <a href="{{ route('login') }}" class="btn btn-danger">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Wachtwoord opnieuw instellen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection