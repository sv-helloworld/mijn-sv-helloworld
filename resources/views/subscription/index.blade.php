@extends('layouts.master')
@section('title', 'Inschrijvingen lidmaatschap')

@section('content')
    <h3>Bestaande inschrijvingen</h3>
    @if ($subscriptions->count())
        <p>Dit is een overzicht van je inschrijvingen voor lidmaatschap bij Studievereniging "Hello World".</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                        <tr>
                            <td><a href="{{ route('subscription.show', $subscription->id) }}">{{ $subscription->contribution->period->name }}</a></td>
                            <td>
                                @if ($subscription->canceled())
                                    <span class="label label-danger">Inschrijving stopgezet</span>
                                @elseif ($subscription->confirmed())
                                    <span class="label label-success">Ingeschreven</span>
                                @elseif ($subscription->approved())
                                    <span class="label label-info">Inschrijvingsverzoek goedgekeurd</span>
                                @elseif ($subscription->declined())
                                    <span class="label label-danger">Inschrijvingsverzoek geweigerd</span>
                                @else
                                    <span class="label label-info">Inschrijvingsverzoek ingediend</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('subscription.show', $subscription->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="alert alert-info">Je hebt je op dit moment nog nooit ingeschreven als lid. Geen probleem, dat is zo geregeld!</p>
    @endif

    <h3>Inschrijven</h3>
    @if ($contributions->count())
        <p>Dit is een overzicht van de nieuwe periode's waarvoor je je kunt inschrijven als lid.</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contributions as $contribution)
                        <tr>
                            <td>
                                <div>
                                    @if ($contribution->is_early_bird)
                                        <span class="label label-success label-offset-right">Early Bird</span>
                                    @endif
                                    {{ $contribution->period->name }}
                                </div>
                                <small class="text-muted">@date($contribution->period->start_date) tot @date($contribution->period->end_date)</small>
                            </td>
                            <td>
                                <a href="{{ route('subscription.create', $contribution->period->slug) }}" class="btn btn-primary btn-sm">Inschrijven</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="alert alert-info">Je kunt je op dit moment nog niet inschrijven voor een nieuwe periode.</p>
    @endif
@endsection
