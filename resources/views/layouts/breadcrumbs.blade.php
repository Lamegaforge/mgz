<div class="relative items-center hidden text-white sm:flex">
    @foreach($breadcrumbs as $bread)
    @if($loop->last)
    <div class="font-semibold" key={index}>{{$bread}}</div>
    @else
    <div class="flex items-center">
        <a href="{{$bread[1]}}" class="font-light hover:text-indigo-400">{{$bread[0]}}</a>
        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </div>
    @endif
    @endforeach
</div>