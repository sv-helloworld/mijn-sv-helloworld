@extends('layouts.master')
@section('title', 'Niet toegankelijk')

@section('content')
	<p>Oeps! De pagina die je probeert te bezoeken is niet toegankelijk. Ga naar de <a href="{{ route('index') }}">startpagina</a>.</p>
@endsection
