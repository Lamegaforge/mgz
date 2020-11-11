<meta property='og:title' content='qsdqd {{$clip->title}}'>
<meta property='og:description' content='{{$clip->slug}}'>

<meta property="og:url" content="{{route('clips.show', $clip)}}">
<meta property="og:image" content="{{$clip->thumbnail}}">
<meta property="og:video:type" content="text/html">
<meta property="og:video:url" content="{{$embedUrl}}">
<meta property="og:video:height" content="720">
<meta property="og:video:width" content="1280">
<meta property="og:type" content="video.other">
