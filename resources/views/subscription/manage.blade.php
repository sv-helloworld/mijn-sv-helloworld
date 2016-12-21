@extends('layouts.master')
@section('title', 'Inschrijvingen beheren')

@section('content')
    @if ($subscriptions->count())
        <p>Dit is een overzicht van openstaande inschrijvingen.</p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Periode</th>
                        <th>Contributie</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($subscriptions as $subscription)
                    <tr>
                        <td><a href="{{ route('user.show', $subscription->user->id) }}">{{ $subscription->user->full_name() }}</a></td>
                        <td>{{ $subscription->contribution->period->name }}</td>
                        <td>
                            @if ($subscription->contribution->is_early_bird)
                                <span class="label label-success label-offset-right">Early Bird</span>
                            @endif
                            &euro; {{ $subscription->contribution->amount }}
                        </td>
                        <td>
                            {!! Form::open([
                                'method'=>'PATCH',
                                'route' => ['subscription.approve', $subscription->id],
                                'style' => 'display:inline'
                            ]) !!}
                                {!! Form::button('Goedkeuren', ['type' => 'submit', 'class' => 'btn btn-success btn-xs']) !!}
                            {!! Form::close() !!}

                            {!! Form::open([
                                'method'=>'PATCH',
                                'route' => ['subscription.decline', $subscription->id],
                                'style' => 'display:inline'
                            ]) !!}
                                {!! Form::button('Weigeren', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">{!! $subscriptions->render() !!}</div>
    @else
        <p class="alert alert-info">Er zijn op dit moment geen nieuwe inschrijvingen bekend.</p>
    @endif
@endsection
