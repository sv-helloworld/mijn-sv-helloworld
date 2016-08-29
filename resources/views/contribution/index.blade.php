@extends('layouts.master')
@section('title', 'Contributies')

@section('content')

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Periode</th>
                    <th>Bedrag</th>
                    <th>Status</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
            @foreach($contributions as $contribution)
                <tr>
                    <td>{{ $contribution->period->name }}</td>
                    <td>{{ date('d-m-Y', strtotime($contribution->period->start_date)) }} t/m {{ date('d-m-Y', strtotime($contribution->period->end_date)) }}</td>
                    @if(!empty($contribution->payments->first()) && $contribution->payments->first()->status == 'paid')
                        <td>&euro; {{ $contribution->payments->first()->payment_amount }}</td>
                    @elseif(date("Y-m-d") <= $contribution->early_bird_end_date)
                        <td>&euro; {{ $contribution->early_bird_amount }}</td>
                    @else
                        <td>&euro; {{ $contribution->amount }}</td>
                    @endif
                    <td>{{ $contribution->payments->first() ? $contribution->payments->first()->status : 'open' }}</td>
                    <td>
                        @if(empty($contribution->payments->first()) || (!empty($contribution->payments->first()) && $contribution->payments->first()->status == 'open'))
                            <a href="{{ route('contribution.pay', $contribution->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-money"></i> Betalen</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper">{!! $contributions->render() !!}</div>
    </div>

@endsection
