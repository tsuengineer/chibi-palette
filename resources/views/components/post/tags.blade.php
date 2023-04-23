@props(['tags'])

@if ($tags)
    <div class="p-2">
        <ul class="flex flex-wrap">
            @foreach($tags as $tag)
                <li class="border rounded-lg shadow bg-gray-900 text-gray-50 text-sm font-bold p-1 mx-1 mb-2 px-3">
                    <a href="{{ route('filter_by_tag', ['tag' => $tag->name]) }}"># {{ $tag->name }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
