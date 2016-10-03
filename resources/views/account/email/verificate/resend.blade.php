@extends('layouts.master')
@section('title', 'E-mail verificatie opnieuw sturen')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <p>Als je de verificatie e-mail niet hebt ontvangen kun je hier de e-mail opnieuw laten versturen.</p>

            <form method="post" action="{{ action('Account\EmailController@resendVerification') }}" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary">E-mail opnieuw versturen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
