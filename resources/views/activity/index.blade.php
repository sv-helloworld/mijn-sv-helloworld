@extends('layouts.master')
@section('title', 'Aanmelden activiteiten')

@section('content')
    <h3>Activiteiten</h3>
    @if ($activities->count())
        <p>Dit is een overzicht van de activiteiten die georganiseerd worden door Studievereniging "Hello World".</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Datum en tijd</th>
                        <th>Aanmeldperiode</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td>
                                <a href="{{ route('activity.show', $activity->id) }}">{{ $activity->title }}</a>
                            </td>
                            <td>
                                @datetime($activity->starts_at) t/m @datetime($activity->ends_at)
                            </td>
                            <td>
                                @date($activity->available_from) t/m @date($activity->available_to)
                            </td>
                            <td>
                                <a href="{{ route('activity.show', $activity->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="alert alert-info">Op dit moment zijn er geen activiteiten beschikbaar, kijk op een later moment nog eens!</p>
    @endif
@endsection
