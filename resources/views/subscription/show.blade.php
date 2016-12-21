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
                        <td>Contributie</td>
                        <td>
                            <div>
                                @if ($subscription->contribution->is_early_bird)
                                    <span class="label label-success label-offset-right">Early Bird</span>
                                @endif
                                &euro; {{ $subscription->contribution->amount }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td>
                            <div>{{ $subscription->contribution->period->name }}</div>
                            <small class="text-muted">@date($subscription->contribution->period->start_date) tot @date($subscription->contribution->period->end_date)</small>
                        </td>
                    </tr>
                    <tr>
                        <td>Status inschrijving</td>
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
                    </tr>
                    <tr>
                        <td>Ingeschreven op</td>
                        <td>@datetime($subscription->created_at)</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3>Betalingen</h3>
        @if ($subscription->payments->count())
            <p>Dit is een overzicht van de betalingen behorende bij deze inschrijving.</p>

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
                        @foreach($subscription->payments as $payment)
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
            <p class="alert alert-info">Er zijn geen betalingen gevonden behorende bij deze inschrijving.</p>
        @endif

        <a href="{{ route('subscription.index') }}" class="btn btn-primary">Terug naar overzicht</a>
    </div>
</div>
@endsection
