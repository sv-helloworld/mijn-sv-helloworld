@extends('layouts.master')
@section('title', 'Leden')

@section('content')
    <p>Er zijn momenteel {{ count($members) }} leden.</p>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Naam</th>
                    <th>E-mailadres</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
            @foreach($members as $member)
                <tr>
                    <td><img src="{{ Gravatar::src($member->email, 40) }}" alt="{{ $member->first_name }}" class="avatar"></td>
                    <td><a href="{{ url('gebruikers', $member->id) }}">{{ $member->full_name() }}</a></td>
                    <td>{{ $member->email }}</td>
                    <td>
                        <a href="{{ route('user.edit', $member->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Bewerk</a>
                        <a href="{{ route('payment.user', $member->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-money"></i> Betalingen</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">{!! $members->render() !!}</div>
@endsection
