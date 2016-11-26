@extends('layouts.master')
@section('back', route('payment.index'))
@section('title', 'Details betaling')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ $payment->description }}</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th colspan="2">Gegevens</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Volgnummer</td>
                            <td>{{ $payment->id }}</td>
                        </tr>
                        <tr>
                            <td>Bedrag</td>
                            <td>&euro; {{ $payment->amount }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>{!! $payment->paid() ? '<span class="label label-success">Betaald</a>' : '<span class="label label-warning">Nog niet betaald</span>' !!}</td>
                        </tr>
                        @if ($payment->paid())
                            <tr>
                                <td>Betaald op</td>
                                <td>@datetime($payment->paid_at)</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if (! $payment->paid())
                <a href="{{ route('payment.pay', $payment->id) }}" class="btn btn-primary">Betalen</a>
                <a href="{{ route('payment.index') }}" class="btn btn-danger">Annuleren</a>
            @else
                <a href="{{ route('payment.index') }}" class="btn btn-primary">Terug naar het overzicht</a>
                <a href="{{ route('payment.invoice', $payment->id) }}" class="btn btn-primary">Factuur downloaden</a>
            @endif
        </div>
    </div>
@endsection
