@extends('layouts.master')
@section('title', 'Aanmelden')

@section('content')
    <p>
        Op deze pagina kun je je aanmelden voor de activiteit: '{{ $activity->title }}'.
        @if($activity_price->amount > 0)
            De kosten voor deze activiteit bedragen &euro;{{ $activity_price->amount }}.
        @else
            Omdat je lid bent kun je gratis deelnemen aan deze activiteit.
        @endif
    </p>

    <p>Controlleer de gegevens in het onderstaande formulier goed! Gegevens kun je aanpassen bij <a href="{{ route('account.edit') }}" target="_blank">accountbeheer</a>.</p>

    <div class="row">
        <div class="col-xs-12">
            {!! Form::open(['url' => route('activity_entry.store', $activity->id), 'class' => 'form-horizontal']) !!}

            <div class="form-group">
                    {!! Form::label('first_name', 'Voornaam *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('first_name', $user->first_name, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                    {!! Form::label('name_prefix', 'Tussenvoegsel *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('name_prefix', $user->name_prefix, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                    {!! Form::label('last_name', 'Achternaam *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('last_name', $user->last_name, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <hr>

            <div class="form-group">
                {!! Form::label('email', 'E-mailadres *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::email('email', $user->email, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('phone_number', 'Telefoonnummer', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('phone_number', $user->phone_number, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <hr>

            <div class="form-group">
                {!! Form::label('address', 'Adres *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('address', $user->address, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('zip_code', 'Postcode *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('zip_code', $user->zip_code, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('city', 'Stad *', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('city', $user->city, ['readonly', 'class' => 'form-control']) !!}
                </div>
            </div>

            <hr>

            <div class="form-group">
                {!! Form::label('notes', 'Opmerkingen', ['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div class="form-group {{ $errors->has('accept') ? 'has-error' : ''}}">
                <div class="col-sm-offset-4 col-sm-8">
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('accept', '1', false) !!}
                            @if($activity_price->amount > 0)
                                Ik bevestig hiermee mijn aanmelding en ga akkoord met de betaling van de kosten voor de bovenstaande activiteit.
                            @else
                                Ik bevestig hiermee mijn aanmelding voor de bovenstaande activiteit.
                            @endif
                        </label>
                    </div>

                    {!! $errors->first('accept', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    {!! Form::button('Aanmelden voor activiteit', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
                    <a href="{{ route('activity.show', $activity->id) }}" class="btn btn-danger">Annuleren</a>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection
