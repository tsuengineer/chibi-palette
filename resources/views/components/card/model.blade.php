@props(['header', 'tweet', 'downloadLink', 'title'])

<div {!! $attributes->merge(['class' => "grid md:grid-cols-2 grid-cols-1 p-2 border rounded-lg shadow"]) !!} >
    <div class="border rounded-lg my-2 mr-0 md:mr-2 p-2">
        <h2 class="font-bold text-lg">{{ $title }}</h2>
        <img src="images/model/{{ $header }}" />

        <h2 class="font-bold mt-4">配布先</h2>
        <a class="underline" href="{{ $downloadLink }}">{{ $downloadLink }}</a>
    </div>

    <div class="m-auto w-full">
        <x-card.twitter :tweet="$tweet" />
    </div>
</div>
