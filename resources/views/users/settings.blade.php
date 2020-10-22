@extends('app')
@section('content')
<section>
    <banner-form banner="{{'/images/banners/' . ($user->banner_image_slug ? $user->banner_image_slug  : 'placeholder.jpg')}}"></banner-form>
</section>
<user-settings :user="{{json_encode($user)}}"></user-settings>
@endsection