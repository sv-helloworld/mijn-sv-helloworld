@extends('layouts.master')
@section('title', 'Account wijzigen')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <p>Hier kun je de algemene gegevens van je account wijzigen.</p>

            <form method="post" action="{{ action('Account\AccountController@update') }}" class="form-horizontal">
                {!! csrf_field() !!}

                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                    <label for="first_name" class="control-label col-sm-4">Voornaam *</label>
                    <div class="col-sm-8">
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') ? old('first_name') : $user->first_name }}" class="form-control">
                        {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('name_prefix') ? 'has-error' : ''}}">
                    <label for="name_prefix" class="control-label col-sm-4">Tussenvoegsel</label>
                    <div class="col-sm-8">
                        <input type="text" name="name_prefix" id="name_prefix" value="{{ old('name_prefix') ? old('name_prefix') : $user->name_prefix }}" class="form-control">
                        {!! $errors->first('name_prefix', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                    <label for="last_name" class="control-label col-sm-4">Achternaam *</label>
                    <div class="col-sm-8">
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') ? old('last_name') : $user->last_name }}" class="form-control">
                        {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <hr>

                <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
                    <label for="phone_number" class="control-label col-sm-4">Telefoonnummer</label>
                    <div class="col-sm-8">
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') ? old('phone_number') : $user->phone_number }}" class="form-control">
                        {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <hr>

                <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                    <label for="address" class="control-label col-sm-4">Adres *</label>
                    <div class="col-sm-8">
                        <input type="text" name="address" id="address" value="{{ old('address') ? old('address') : $user->address }}" class="form-control">
                        {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('zip_code') ? 'has-error' : ''}}">
                    <label for="zip_code" class="control-label col-sm-4">Postcode *</label>
                    <div class="col-sm-8">
                        <input type="text" name="zip_code" id="zip_code" value="{{ old('zip_code') ? old('zip_code') : $user->zip_code }}" class="form-control">
                        {!! $errors->first('zip_code', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
                    <label for="city" class="control-label col-sm-4">Stad *</label>
                    <div class="col-sm-8">
                        <input type="text" name="city" id="city" value="{{ old('city') ? old('city') : $user->city }}" class="form-control">
                        {!! $errors->first('city', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <a href="{{ route('account.index') }}" class="btn btn-danger">Annuleren</a>
                        <button type="submit" class="btn btn-primary">Account wijzigen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
