@extends('app')
@section('title', 'Clips')
@section('content')
<div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
    @include('layouts.breadcrumbs', [
	    'breadcrumbs' => [
	    	[
	    		'Accueil', 
	    		route('home'),
	    	],
	    	'Clips',
	    ],
    ])
</div>
<section class="-mt-6 section">
    <h1 class="text-3xl font-semibold leading-8 tracking-tight text-white md:text-4xl sm:text-3xl sm:leading-9">Tous les clips</h1>
    <fetch-list :cards="{{json_encode($cards)}}" grid-class="grid mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10" fetch-url="{{route('api.clips.search')}}" type="clips" :can-filter="true" :can-search="true" :can-order="true" />
</section>
@endsection