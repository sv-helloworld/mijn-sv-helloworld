@extends('layouts.master')
@section('title', 'E-mailadres wijzigen')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-md-10">
            <p>Na het wijzigen van uw e-mailadres moet u opnieuw uw e-mailadres valideren.</p>

            <form method="post" action="{{ action('Account\EmailController@update') }}" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="email" class="control-label col-sm-4">Nieuw e-mailadres</label>
                    <div class="col-sm-8">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="control-label col-sm-4">Herhaal e-mailadres</label>
                    <div class="col-sm-8">
                        <input type="email" name="email_confirmation" id="email_confirmation" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <a href="{{ route('account.index') }}" class="btn btn-danger">Annuleren</a>
                        <button type="submit" class="btn btn-primary">E-mailadres wijzigen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection