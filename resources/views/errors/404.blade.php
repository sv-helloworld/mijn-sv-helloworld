@extends('layouts.master')
@section('title', 'Niet gevonden')

@section('content')
	<p>Oeps! De pagina die je zocht is niet gevonden. Ga naar de <a href="{{ route('index') }}">startpagina</a>.</p>
@endsection
