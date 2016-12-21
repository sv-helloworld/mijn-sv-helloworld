@extends('layouts.master')
@section('title', 'Details aanmelding')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            @unless ($activity_entry->confirmed())
                <p class="alert alert-info">Je aanmelding voor dit activiteit is nog niet bevestigd.</p>
            @endunless

            <h2>Aanmelding voor {{ $activity_entry->activity->title }}</h2>
            <p>Dit zijn de aanmeldingsgegevens van je aanmelding voor het activiteit '{{ $activity_entry->activity->title }}'.</p>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="2">Details over de aanmelding</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Prijs</td>
                            @if($activity_entry->activity_price->amount > 0)
                                <td>&euro; {{ $activity_entry->activity_price->amount }}</td>
                            @else
                                <td>Gratis</td>
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
                                <td>Aangemeld op</td>
                                <td>@datetime($activity_entry->created_at)</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="2">Details over de activiteit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Activiteit</td>
                            <td>{{ $activity_entry->activity->title }}</td>
                        </tr>
                        <tr>
                            <td>Datum en tijd</td>
                            <td>
                                @datetime($activity_entry->activity->starts_at) t/m @datetime($activity_entry->activity->ends_at)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>Betalingen</h3>
            @if ($activity_entry->payments->count())
                <p>Dit is een overzicht van de betalingen behorende bij deze aanmelding.</p>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Beschrijving</th>
                                <th>Status</th>
                                <th>Betaald op</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activity_entry->payments as $payment)
                                <tr>
                                    <td>{{ $payment->id }}</th>
                                    <td>{{ $payment->description }}</td>
                                    <td>{!! $payment->paid() ? '<span class="label label-success">Betaald</a>' : '<span class="label label-warning">Nog niet betaald</span>' !!}</td>
                                    <td>
                                        @if ($payment->paid())
                                            @datetime($payment->paid_at)
                                        @else
                                            N.v.t.
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="alert alert-info">Er zijn geen betalingen gevonden behorende bij deze aanmelding.</p>
            @endif

            <a href="{{ route('activity_entry.index') }}" class="btn btn-default">Terug naar overzicht</a>
            <a href="{{ route('activity.show', $activity_entry->activity->id) }}" class="btn btn-primary">Naar activiteit</a>
        </div>
    </div>
@endsection
