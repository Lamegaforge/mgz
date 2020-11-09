@extends('app')
@section('title', 'Classement')
@section('content')
<div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
@include('layouts.breadcrumbs', [
	'breadcrumbs' => [
		[
			'Accueil', 
			route('home')
		],
		'Classement',
	],
])
</div>
<section class="-mt-6 section">
    <h1 class="text-3xl font-semibold leading-8 tracking-tight text-white md:text-4xl sm:text-3xl sm:leading-9">Classement</h1>
    <fetch-list grid-class="mt-6" :can-filter="true" :can-search="true" fetch-url="{{route('api.users.search')}}" type="users" />
</section>
@endsection