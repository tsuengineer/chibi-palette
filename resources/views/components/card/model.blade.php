@props(['directory', 'tweet', 'downloadLink', 'title'])

<div {!! $attributes->merge(['class' => "grid md:grid-cols-2 grid-cols-1 p-2 border rounded-lg shadow"]) !!} >
    <div class="border rounded-lg my-2 mr-0 md:mr-2 p-2">
        <h2 class="font-bold text-lg">{{ $title }}</h2>
        <img src="images/model/{{ $directory }}/header.webp" />

        <h2 class="font-bold mt-4">配布先</h2>
        <a class="underline" href="{{ $downloadLink }}">{{ $downloadLink }}</a>

{{--        <h2 class="font-bold mt-4">ギャラリー(準備中)</h2>--}}
{{--        <div class="grid grid-cols-2">--}}
{{--            <div class="max-w-full m-2">--}}
{{--                <img class="w-full h-auto" src="https://placehold.jp/150x150.png" />--}}
{{--            </div>--}}
{{--            <div class="max-w-full m-2">--}}
{{--                <img class="w-full h-auto" src="https://placehold.jp/150x150.png" />--}}
{{--            </div>--}}
{{--            <div class="max-w-full m-2">--}}
{{--                <img class="w-full h-auto" src="https://placehold.jp/150x150.png" />--}}
{{--            </div>--}}
{{--            <div class="max-w-full m-2">--}}
{{--                <img class="w-full h-auto" src="https://placehold.jp/150x150.png" />--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

    <div class="m-auto w-full">
        <x-card.twitter :tweet="$tweet" />
    </div>
</div>
