@extends('layouts.master')
@section('title', 'Inschrijven')

@section('content')
    <p>
        Op deze pagina kun je je inschrijven als lid bij onze studievereniging voor de periode '{{ $contribution->period->name }}'.
        De contributie voor deze periode bedraagt &euro;{{ $contribution->amount }}.
    </p>

    @if (date('Y-m-d') <= $contribution->early_bird_end_date)
        <p class="alert alert-info">Als je je inschrijft voor <strong>{{ $contribution->early_bird_end_date }}</strong> bedraagt de contributie slechts <strong>&euro;{{ $contribution->early_bird_amount }}</strong> in plaats van de reguliere &euro;{{ $contribution->amount }}!</strong></p>
    @endif

    <p>Controlleer de gegevens in het onderstaante formulier goed! Gegevens kun je aanpassen in het <a href="{{ route('account.edit') }}" target="_blank">accountbeheer</a>.</p>

    <div class="row">
        <div class="col-xs-12">
            {!! Form::open(['url' => route('subscription.store', $contribution->period->slug), 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                    {!! Form::label('first_name', 'Voornaam *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('first_name', $user->first_name, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                    {!! Form::label('name_prefix', 'Tussenvoegsel *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('name_prefix', $user->name_prefix, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                    {!! Form::label('last_name', 'Achternaam *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('last_name', $user->last_name, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <hr>

            <div class="form-group">
                {!! Form::label('email', 'E-mailadres *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::email('email', $user->email, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('phone_number', 'Telefoonnummer', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('phone_number', $user->phone_number, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <hr>

            <div class="form-group">
                {!! Form::label('address', 'Adres *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('address', $user->address, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('zip_code', 'Postcode *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('zip_code', $user->zip_code, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('city', 'Stad *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('city', $user->city, ['disabled', 'class' => 'form-control']) !!}
                </div>
            </div>

            <hr>

            <div class="form-group {{ $errors->has('accept') ? 'has-error' : ''}}">
                <div class="col-sm-offset-4 col-sm-8">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('accept', '1', false) !!} Ik bevestig hiermee mijn inschrijving en ga akkoord met de betaling van de contributie.
                        </label>
                    </div>

                    {!! $errors->first('accept', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    {!! Form::button('Inschrijven als lid', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection