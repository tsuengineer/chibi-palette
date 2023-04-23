@props(['breadcrumbs'])

<nav class="text-sm font-medium" aria-label="breadcrumb">
    <ol class="list-none p-0 inline-flex">
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="flex items-center">
                @if ($breadcrumb['url'])
                    <a href="{{ $breadcrumb['url'] }}" class="text-gray-500 hover:text-gray-700">
                        {{ $breadcrumb['name'] }}
                    </a>
                @else
                    <span class="text-gray-700">
                        {{ $breadcrumb['name'] }}
                    </span>
                @endif
                @if (!$loop->last)
                    <i class="fa-solid fa-angle-right mx-2"></i>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
