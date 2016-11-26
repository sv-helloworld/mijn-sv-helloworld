@extends('layouts.master')
@section('title', 'Betalingen')

@section('content')
    <h3>Openstaande betalingen</h3>
    @if ($open_payments->count())
        <p>Dit is een overzicht van openstaande betalingen.</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Beschrijving</th>
                        <th>Status</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($open_payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</th>
                            <td>{{ $payment->description }}</td>
                            <td>{!! $payment->paid() ? '<span class="label label-success">Betaald</a>' : '<span class="label label-warning">Nog niet betaald</span>' !!}</td>
                            <td>
                                <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
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
    @if ($finalized_payments->count())
        <p>Dit is een overzicht van afgeronde betalingen.</p>

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
                    @foreach($finalized_payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</th>
                            <td>{{ $payment->description }}</td>
                            <td>{!! $payment->paid() ? '<span class="label label-success">Betaald</a>' : '<span class="label label-warning">Nog niet betaald</span>' !!}</td>
                            <td>@datetime($payment->paid_at)</td>
                            <td>
                                <a href="{{ route('payment.show', $payment->id) }}" class="btn btn-primary btn-xs">Bekijken</a>
                                <a href="{{ route('payment.invoice', $payment->id) }}" class="btn btn-primary btn-xs">Factuur</a>
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
