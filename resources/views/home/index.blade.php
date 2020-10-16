@extends('app')
@section('content')
<section class="section">
    <h1 class="text-3xl">🚧 C'est le chantier ici</h1>
    @if (session()->has('info')) 
    	<p style="color: red;">{{session('info')}}</p>
    @endif
</section>
@endsection