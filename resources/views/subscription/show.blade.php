@extends('layouts.master')
@section('title', 'Details inschrijving')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <h2>{{ $subscription->contribution->period->name }}</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th colspan="2">Details van de inschrijving</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ingeschreven op</td>
                        <td>{{ $subscription->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Status inschrijving</td>
                        <td>{!! !$subscription->canceled ? '<span class="label label-info">Inschrijvingsverzoek ingediend</span>' : '<span class="label label-warning">Uitgeschreven</span>' !!}</td>
                    </tr>
                    <tr>
                        <td>Status betaling</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>
                            <span class="block">{{ $subscription->contribution->period->name }}</span>
                            <small class="text-muted">{{ $subscription->contribution->period->start_date }} tot {{ $subscription->contribution->period->end_date }}</small>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="{{ route('subscription.index') }}" class="btn btn-primary">Terug naar overzicht</a>
    </div>
</div>
@endsection
