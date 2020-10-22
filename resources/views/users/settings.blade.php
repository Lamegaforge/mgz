@extends('app')
@section('content')
<section>
    <banner-form banner="{{'/images/banners/'.$user->banner_image_slug}}"></banner-form>
</section>
<user-settings :user="{{json_encode($user)}}"></user-settings>
@endsection