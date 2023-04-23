@props(['rank', 'user', 'slug', 'title', 'image', 'directory', 'avatar', 'ulid'])

<div class="relative text-gray-900 p-2">
    <!-- 順位を表す数字の要素 -->
    @php
        $rankBackground = isset($rank) ? 'bg-gray-500' : '';
        if (isset($rank)) {
            $rankBackground = $rank === '1' ? 'bg-yellow-400 gold' :
                             ($rank === '2' ? 'bg-gray-300 silver' :
                             ($rank === '3' ? 'bg-orange-600 bronze' : 'bg-gray-500'));
        }
    @endphp
    @if (isset($rank))
        <div class="absolute top-2 left-2 text-white text-lg font-bold w-8 h-8 flex items-center justify-center {{ $rankBackground }}">
            {{ $rank }}
        </div>
    @endif
    <!-- 画像の要素 -->
    <a href="{{ route('posts.show', ['ulid' => $ulid]) }}">
        <img
            class="shadow-md w-full rounded-lg"
            src="{{ asset('storage/images/post/' . $directory . '/thumbnail/' . $ulid . '.webp') }}"
            alt="{{ $title }}"
        />
    </a>
    <div class="flex pt-3 pb-8">
        <a class="my-auto flex-shrink-0" href="{{ route('profile.show', ['userSlug' => $slug]) }}">
            @if ($avatar)
                <img class="w-9 h-9 rounded-full my-auto" src="{{ asset('storage/images/avatar/' . $directory . '/' . $avatar) }}" alt="アバター" />
            @else
                <img class="w-8 h-8 rounded-full m-auto border" src="{{ asset('images/default_user.png') }}" alt="アバター" />
            @endif
        </a>
        <div class="pl-3 min-w-0">
            <div class="font-semibold overflow-hidden truncate">
                <a href="{{ route('posts.show', ['ulid' => $ulid]) }}">
                    {{ $title }}
                </a>
            </div>
            <div class="pt-1 text-xs text-gray-500 overflow-hidden truncate">
                {{ $user }}
            </div>
        </div>
    </div>
</div>
<style>
    .gold{
        background: linear-gradient(45deg, #DAAF08 0%, #DAAF08 45%, #FEE9A0 70%, #DAAF08 85%, #DAAF08 90% 100%);
        background-size: 800% 400%;
        animation: gradient 5s infinite cubic-bezier(.62, .28, .23, .99) both;
    }

    .silver{
        background: linear-gradient(45deg, #757575 0%, #9E9E9E 45%, #E8E8E8 70%, #9E9E9E 85%, #757575 90% 100%);
        background-size: 800% 400%;
        animation: gradient 5s infinite cubic-bezier(.62, .28, .23, .99) both;
    }

    .bronze{
        background: linear-gradient(45deg, #a57e65 0%, #a57e65 45%, #f3cfb8 70%, #a57e65 85%, #a57e65 90% 100%);
        background-size: 800% 400%;
        animation: gradient 5s infinite cubic-bezier(.62, .28, .23, .99) both;
    }
    @keyframes gradient {
        0% {
            background-position: 0 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0 50%;
        }
    }
</style>
