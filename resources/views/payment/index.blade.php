@extends('layouts.master')
@section('title', 'Betalingen')

@section('content')
    <h3>Openstaande betalingen</h3>
    @if (count($open_payments))
        <p>Dit is een overzicht van openstaande betalingen.</p>

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
                    @foreach($open_payments as $payment)
                        <tr>
                            <td>
                                <a href="{{ route('subscription.show', $subscription->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="alert alert-info">Je hebt op dit moment geen openstaande betalingen.</p>
    @endif

    <h3>Betalingsgeschiedenis</h3>
    @if (count($finalized_payments) > 0)
        <p>Dit is een overzicht van afgeronde betalingen.</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finalized_payments as $payment)
                        <tr>
                            <td></td>
                            <td>
                                <a href="{{ route('subscription.create', $contribution->period->slug) }}" class="btn btn-primary btn-sm">Inschrijven</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="alert alert-info">Je hebt op dit moment nog geen afgeronde betalingen.</p>
    @endif
@endsection
