@extends('layouts.master')
@section('title', sprintf('Aanmeldingen \'%s\'', $activity->title))

@section('content')
    @if ($activity_entries->count())
        <p>Dit is een overzicht van aanmeldingen voor '{{ $activity->title }}'.</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Bevestigd</th>
                        <th>Opmerkingen</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($activity_entries as $activity_entry)
                    <tr>
                        <td><a href="{{ route('user.show', $activity_entry->user->id) }}">{{ $activity_entry->user->full_name() }}</a></td>
                        <td>
                            @if ($activity_entry->confirmed())
                                <span class="label label-success">Aangemeld</span>
                            @else
                                <span class="label label-info">Nog niet bevestigd</span>
                            @endif
                        </td>
                        <td>{{ $activity_entry->notes }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">{!! $activity_entries->render() !!}</div>
    @else
        <p class="alert alert-info">Er zijn op dit moment geen nieuwe aanmeldingen bekend.</p>
    @endif
@endsection
