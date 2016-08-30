@extends('layouts.master')
@section('title', 'Inschrijvingen lidmaatschap')

@section('content')
    @if ($contribution)
        @if (count($subscriptions))
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
                            <td>{!! !$subscription->canceled ? '<span class="label label-info">Inschrijvingsverzoek ingediend</span>' : '<span class="label label-warning">Uitgeschreven</span>' !!}</td>
                            <td>
                                <a href="{{ route('subscription.show', $subscription->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="alert alert-info">Je hebt je op dit moment niet ingeschreven als lid. Geen probleem, dat is zo geregeld!</p>
            <a href="{{ route('subscription.create', $contribution->period->slug) }}" class="btn btn-primary">Ik wil me inschrijven</a>
        @endif
    @else
        <p class="alert alert-info">Je kunt je op dit moment nog niet inschrijven.</p>
    @endif
@endsection
