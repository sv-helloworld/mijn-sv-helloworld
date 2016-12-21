@extends('layouts.master')
@section('title', 'Account')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="3">Gegevens</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Naam</td>
                            <td>{{ $user->full_name() }}</td>
                            <td><a href="{{ route('account.edit') }}"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <td>E-mailadres</td>
                            <td>{{ $user->email }}</td>
                            <td><a href="{{ route('account.email.edit') }}"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <td>Wachtwoord</td>
                            <td>{{ str_repeat('&#183;', 20) }}</td>
                            <td><a href="{{ route('account.password.edit') }}"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <tr>
                            <td>Geregistreerd als</td>
                            <td colspan="2">{{ $user->role ? $user->role->title : 'Normale gebruiker' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
