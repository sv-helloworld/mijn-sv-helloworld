@extends('layouts.master')
@section('title', 'Gebruikers')

@section('content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>E-mailadres</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ url('gebruikers', $user->id) }}">{{ $user->first_name }} {{ $user->name_prefix }} {{ $user->last_name }}</a></td>
                    <td>{{ $user->email }}</td>
                    <td>{!! $user->verified ? '<span class="label label-success">Geverifieerd</a>' : '<span class="label label-warning">Niet geverifieerd</span>' !!}</td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Bewerk</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">{!! $users->render() !!}</div>

@endsection
