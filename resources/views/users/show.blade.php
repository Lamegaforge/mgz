@extends('app')
@section('content')
<section>
    <div class="relative xl:pt-0 pt-3/1 xl:h-400px">
        <img alt="profil banner" class="absolute top-0 left-0 object-cover object-center w-full h-full" src="{{'/images/banners/'.$user->banner_image_slug}}" />
    </div>
</section>
<section class="relative border-t border-gray-900">
    <div class="px-4 py-6 mx-auto -mt-10 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-center sm:flex-row">
            <img class="inline-block w-40 h-40 mx-auto border-4 border-black rounded-md sm:ml-0 sm:mr-0" src="{{$user->profile_image_url}}" alt="">
            <div class="sm:ml-6 sm:mt-3">
                <p class="text-3xl leading-tight">{{$user->display_name}}</p>
                <p class="max-w-md">{{ $user->description }}</p>
                <div class="flex mt-2 space-x-2">
                    @if($user->twitter)
                    <a href="{{'https://twitter.com/'.$user->twitter}}" target="_blank" rel="nofollow noreferrer" class="text-gray-400 hover:text-gray-500"><span class="sr-only">Twitter</span><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                        </svg></a>
                    @endif
                    @if($user->youtube)
                    <a href="{{'https://youtube.com/'.$user->youtube}}" target="_blank" rel="nofollow noreferrer" class="text-gray-400 hover:text-gray-500"><span class="sr-only">Youtube</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
                        </svg></a>
                    @endif
                    @if($user->instagram)
                    <a href="{{'https://instagram.com/'.$user->instagram}}" target="_blank" rel="nofollow noreferrer"   class="text-gray-400 hover:text-gray-500"><span class="sr-only">Instagram</span><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                        </svg></a>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-6 border-b border-gray-900">
            <nav class="flex -mb-px space-x-6 overflow-x-scroll sm:overflow-x-auto sm:space-x-8">
                <a href="#" class="px-1 py-4 text-base font-medium leading-5 text-indigo-400 whitespace-no-wrap border-b-2 border-indigo-500 focus:outline-none focus:text-indigo-800 focus:border-indigo-700" aria-current="page">
                    Clips
                </a>
                <a href="#" class="px-1 py-4 text-base font-medium leading-5 text-gray-400 whitespace-no-wrap border-b-2 border-transparent hover:text-white hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300">
                    Succès
                </a>
                <a href="#" class="px-1 py-4 text-base font-medium leading-5 text-gray-400 whitespace-no-wrap border-b-2 border-transparent hover:text-white hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300">
                    Commentaires
                </a>
                <a href="#" class="px-1 py-4 text-base font-medium leading-5 text-gray-400 whitespace-no-wrap border-b-2 border-transparent hover:text-white hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300">
                    Favoris
                </a>
            </nav>
        </div>
        <div class="pb-16 mt-6 md:pb-20 lg:pb-24">
            <grid :user-id="{{$user->id}}" grid-class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10" fetch-url="{{route('api.clips.search')}}" type="clips" />
        </div>
    </div>
</section>
@endsection