@extends('layouts.master')
@section('title', 'Wachtwoord vergeten')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <p>Voer hieronder het gewenste nieuwe wachtwoord in.</p>

            <form method="post" action="{{ route('account.password.reset') }}" class="form-horizontal">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="control-label col-sm-4">HZ e-mailadres</label>
                    <div class="col-sm-8">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="control-label col-sm-4">Wachtwoord</label>
                    <div class="col-sm-8">
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="control-label col-sm-4">Herhaal wachtwoord</label>
                    <div class="col-sm-8">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-primary">Wachtwoord opnieuw instellen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
