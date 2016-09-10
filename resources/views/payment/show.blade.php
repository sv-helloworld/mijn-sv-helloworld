@extends('layouts.master')
@section('back', url('payment'))
@section('title', 'Details Betaling')

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
                            <td>{{ $payment->amount }}</td>
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
                        @else
                        <tr>
                            <td>Actie</td>
                            <td>
                                <a href="{{ route('payment.pay', $payment->id) }}" class="btn btn-primary btn-xs">Betalen</a>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
