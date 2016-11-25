@extends('layouts.master')
@section('back', url('user'))
@section('title', 'Betalingen gebruiker')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <h2>{{ $user->first_name }} {{ $user->name_prefix }} {{ $user->last_name }}</h2>
            @if(count($user->payments))
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
                <p class="alert alert-info">Op dit moment geen openstaande betalingen.</p>
            @endif
        </div>
    </div>
@endsection
