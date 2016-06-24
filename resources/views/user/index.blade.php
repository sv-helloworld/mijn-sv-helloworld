@extends('layouts.master')
@section('title', 'Gebruikers')

{{-- Sidebar button --}}
@section('sidebar-nav')
    <li>
        <a href="{{ url('gebruikers/create') }}">
            <i class="fa fa-plus"></i> Maak nieuwe gebruiker
        </a>
    </li>
@stop

@section('content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>E-mailadres</th>
                    <th>E-mailadres status</th>
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

                        {!! Form::open([
                            'method'=>'PATCH',
                            'route' => ['user.activate', $user->id],
                            'style' => 'display:inline'
                        ]) !!}
                            @if ($user->activated)
                                {!! Form::hidden('activated', false) !!}
                                {!! Form::button('Deactiveren', ['type' => 'submit', 'class' => 'btn btn-warning btn-xs']) !!}
                            @else
                                {!! Form::hidden('activated', true) !!}
                                {!! Form::button('Activeren', ['type' => 'submit', 'class' => 'btn btn-success btn-xs']) !!}
                            @endif
                        {!! Form::close() !!}

                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['gebruikers', $user->id],
                            'style' => 'display:inline'
                        ]) !!}
                            {!! Form::button('<i class="fa fa-trash"></i> Verwijder', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper">{!! $users->render() !!}</div>
    </div>

@endsection
