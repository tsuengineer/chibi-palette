@props(['user', 'favoriteCount'])

<div class="sm:flex sm:grid sm:grid-cols-10">
    <div class="sm:col-span-3 lg:col-span-2">
        <div class="flex justify-between pt-4 px-2">
            @if ($user?->avatars?->path)
                <img
                    class="w-20 h-20 rounded-full my-auto"
                    src="{{ asset('storage/images/avatar/' . user_directory_path($user->id) . '/' . $user->avatars->path) }}"
                    alt="アバター"
                />
            @else
                <img class="w-20 h-20 border rounded-full my-auto" src="{{ asset('images/default_user.png') }}" alt="アバター" />
            @endif

            @if ($user->id === Auth::user()?->id)
                <div>
                    <a
                        href="{{ route('profile.edit') }}"
                        class="py-1 px-4 border font-bold rounded-lg shadow-sm hidden sm:block "
                    >
                        編集
                    </a>
                    <a
                        href="{{ route('profile.edit') }}"
                        class="py-2 px-4 border font-bold rounded-lg shadow-sm block sm:hidden"
                    >
                        プロフィールを編集
                    </a>
                </div>
            @endif
        </div>

        <div class="flex flex-col pl-4">
            <div class="mb-1 text-lg font-semibold">
                {!! $user->name !!}
                <x-card.sns-links twitter="{{ $user->twitter }}" instagram="{{ $user->instagram }}"></x-card.sns-links>
            </div>
            <div class="font-sm text-gray-600">&#x40;{!! $user->slug !!}</div>
        </div>
    </div>

    <div class="sm:col-span-7 lg:col-span-8 sm:pt-4 sm:pr-4 pt-8 px-4">
        <h2 class="text-sm font-bold">自己紹介</h2>
        <div class="flex flex-col">
            <div class="p-4 bg-gray-100 rounded-lg">
                @if($user->profile){!! nl2br(e($user->profile)) !!}@else<span class="text-gray-600">未設定</span>@endif
            </div>
        </div>

        <div class="flex flex-col py-4">
            <div class="text-gray-600">
                📅{!! $user->created_at->format('Y年n月j日') !!}から利用しています
            </div>
        </div>

        <div class="flex my-2 py-4 bg-white rounded-lg">
            <div class="flex items-center">
                <div class="text-gray-600 text-sm">投稿数:</div>
                <div class="pl-2 font-semibold text-gray-800">{!! count($user->posts) !!}</div>
            </div>
            <div class="flex items-center justify-between pl-4">
                <div class="text-gray-600 text-sm">いいね数:</div>
                <div class="pl-2 font-semibold text-gray-800">{{ $favoriteCount }}</div>
            </div>
            <div class="flex items-center justify-between pl-4">
                <div class="text-gray-600 text-sm">閲覧数:</div>
                <div class="pl-2 font-semibold text-gray-800">{{ $user->posts_sum_views ?? 0 }}</div>
            </div>
        </div>
    </div>
</div>
