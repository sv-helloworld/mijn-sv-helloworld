@extends('layouts.master')
@section('back', url('user'))
@section('title', 'Betalingen gebruiker')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <p>Overzicht van de betalingen van gebruiker {{ $user->full_name() }}.</p>

            @if($user->payments->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr>
                            <th>Beschrijving</th>
                            <th>Bedrag</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->payments as $payment)
                            <tr>
                                <td>{{ $payment->description }}</td>
                                <td>&euro;{{ $payment->amount }}</td>
                                <td>{!! $payment->paid() ? '<span class="label label-success">Betaald</a>' : '<span class="label label-warning">Nog niet betaald</span>' !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="alert alert-info">Deze gebruiker heeft op dit moment nog geen betalingen.</p>
            @endif
        </div>
    </div>
@endsection
