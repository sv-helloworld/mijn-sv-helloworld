@extends('layouts.master')
@section('title', 'Aanmeldingen activiteiten')

@section('content')
    @if ($activity_entries->count())
        <p>Dit is een overzicht van jouw aanmeldingen voor activiteiten.</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Aangemeld op</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activity_entries as $activity_entry)
                        <tr>
                            <td>
                                <a href="{{ route('activity_entry.show', $activity_entry->id) }}">{{ $activity_entry->activity->title }}</a>
                            </td>
                            <td>
                                @datetime($activity_entry->created_at)
                            </td>
                            <td>
                                @if ($activity_entry->confirmed())
                                    <span class="label label-success">Aangemeld</span>
                                @else
                                    <span class="label label-info">Nog niet bevestigd</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('activity_entry.show', $activity_entry->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="alert alert-info">Op dit moment heb je je nog niet aangemeld voor een activiteit.</p>
    @endif
@endsection
