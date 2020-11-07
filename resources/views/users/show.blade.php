@extends('app')
@section('content')
<section>
    <div class="relative xl:pt-0 pt-3/1 xl:h-400px">
        <img alt="profil banner" class="absolute top-0 left-0 object-cover object-center w-full h-full" src="{{'/images/banners/' . ($user->banner_image_slug ?? 'placeholder.jpg')}}" />
    </div>
</section>
<section class="relative border-t border-gray-900">
    <div class="px-4 py-6 mx-auto -mt-10 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col items-center sm:flex-row">
            <img class="inline-block w-40 h-40 mx-auto border-4 border-black rounded-md sm:ml-0 sm:mr-0" src="{{$user->profile_image_url ?? '/images/profile_placeholder.jpg'}}" alt="">
            <div class="sm:ml-6 sm:mt-3">
                <p class="text-3xl leading-tight">{{$user->display_name}}</p>
                <p class="max-w-md">{{ $user->description }}</p>
                <div class="flex mt-2 space-x-2">
                    <a href="{{'https://twitch.tv/'.$user->login}}" target="_blank" rel="nofollow noreferrer" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Twitch</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z"></path>
                        </svg>
                    </a>
                    @if($user->twitter)
                    <a href="{{'https://twitter.com/'.$user->twitter}}" target="_blank" rel="nofollow noreferrer" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 512 512">
                            <path d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path>
                        </svg>
                    </a>
                    @endif
                    @if($user->youtube)
                    <a href="{{'https://youtube.com/'.$user->youtube}}" target="_blank" rel="nofollow noreferrer" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Youtube</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 576 512">
                            <path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>
                        </svg>
                    </a>
                    @endif
                    @if($user->instagram)
                    <a href="{{'https://instagram.com/'.$user->instagram}}" target="_blank" rel="nofollow noreferrer" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Instagram</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 448 512">
                            <path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="pb-16 mt-6 md:pb-20 lg:pb-24">
            <tabs>
                <tab title="Clips" :value="0">
                    <fetch-list :user-id="{{$user->id}}" grid-class="grid mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10" fetch-url="{{route('api.clips.search')}}" type="clips" />
                </tab>
                <tab title="Succès" :value="1">
                    <div class="mt-6 md:grid grid-cols-layout md:gap-8">
                        <div class="text-center">
                            <div class="px-3 py-2 border border-gray-900">
                                <p>Succès</p>
                                <x-achievements-progress 
                                    :sumAchievements="$scores['sum_achievements']" 
                                    :maxAchievementsPoints="$max_achievements_points"
                                />
                                <p class="text-xs text-gray-400">{{$scores['sum_achievements']}}/{{$max_achievements_points}} points</p>
                                <p class="mt-3">Clips</p>
                                <p class="text-xs text-gray-400">Validés: {{$scores['sum_clips']}} points</p>
                                <p class="text-xs text-gray-400">Vues total: {{$scores['sum_views']}} points</p>
                                <p class="text-xs text-gray-400">En favoris: {{$scores['sum_favorites']}} points</p>
                            </div>
                            <p class="mt-4 text-lg">Total: {{$scores['sum']}} points</p>
                        </div>
                        <div>
                            <fetch-list fetch-url="{{route('api.achievement.search', $user->id)}}" type="achievements" />
                        </div>
                    </div>
                </tab>
                <tab title="Favoris" :value="2">
                    <fetch-list grid-class="grid mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-10" fetch-url="{{route('api.favorites.search', $user->id)}}" type="clips" />
                </tab>
            </tabs>
        </div>
    </div>
</section>
@endsection