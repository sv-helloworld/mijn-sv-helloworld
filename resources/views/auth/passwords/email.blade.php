@extends('layouts.master')
@section('title', 'Wachtwoord vergeten')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <p>Als je je wachtwoord bent vergeten kun je hieronder je e-mailadres opgeven. Je zal dan een link toegestuurd krijgen waarmee je je wachtwoord opnieuw kan instellen.</p>

            <form method="post" action="{{ route('account.password.send') }}" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="email" class="control-label col-sm-4">HZ e-mailadres</label>
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
