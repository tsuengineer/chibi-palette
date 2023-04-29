@props(['tweet'])

@if ($tweet)
    <h2 class="font-bold mt-8 px-2">関連ツイート</h2>
    <div class="detail-tweet px-2">
        <x-card.twitter :tweet="$tweet" />
    </div>
@endif
