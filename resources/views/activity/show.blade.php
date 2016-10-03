@extends('layouts.master')
@section('title', 'Details activiteit')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ $activity->title }}</h2>
            <p>
                {{ $activity->description }}
            </p>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="2">Details over de activiteit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Datum en tijd</td>
                            <td>
                                @datetime($activity->starts_at) t/m @datetime($activity->ends_at)
                            </td>
                        </tr>
                        <tr>
                            <td>Aanmeldperiode</td>
                            <td>
                                @date($activity->available_from) t/m @date($activity->available_to)
                            </td>
                        </tr>
                        <tr>
                            <td>Prijs</td>
                            @if($activity_price)
                                @if($activity_price->amount > 0)
                                    <td>&euro; {{ $activity_price->amount }}</td>
                                @else
                                    <td>Gratis</td>
                                @endif
                            @else
                                <td>Onbekend</td>
                            @endif
                        </tr>
                        @if($activity_entry)
                            <tr>
                                <td>Status aanmelding</td>
                                <td>
                                    @if ($activity_entry->confirmed())
                                        <span class="label label-success">Aangemeld</span>
                                    @else
                                        <span class="label label-info">Nog niet bevestigd</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Ingeschreven op</td>
                                <td>@datetime($activity_entry->created_at)</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <a href="{{ route('activity.index') }}" class="btn btn-default">Terug naar overzicht</a>
            @if($activity_entry)
                <a href="{{ route('activity_entry.show', $activity_entry->id) }}" class="btn btn-primary">Bekijk aanmelding</a>
            @else
                <a href="{{ route('activity_entry.create', $activity->id) }}" class="btn btn-primary">Aanmelden</a>
            @endif
        </div>
    </div>
@endsection
