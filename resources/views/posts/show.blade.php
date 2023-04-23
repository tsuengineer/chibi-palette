@extends('layouts.common')
@include('layouts.header')
@section('title'){{ $post->title }}｜{{ config('app.name') }}@endsection
@section('ogPath'){{ 'storage/images/post/' . user_directory_path($post->user_id) . '/main/' . $post->ulid . '.webp' }}
@endsection

@php
    $shareUrl = "https://twitter.com/intent/tweet?text=".urlencode("「".$post->title."」をシェアしました");
    $shareUrl .= "&amp;url=".route('posts.show', ['ulid' => $post->ulid]);
    $shareUrl .= "&amp;hashtags=ちびキャラパレット,ちびパレ"
@endphp

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => '個別イラスト', 'url' => ''],
                ];
            @endphp
            <div class="px-2 mb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <div class="flex justify-between items-center">
                <div class="font-semibold overflow-hidden truncate text-lg sm:text-2xl w-9/12 md:w-10/12">{{ $post->title }}</div>
                <a class="flex items-center justify-center w-28 py-1 my-1 mr-1 rounded-lg shadow-lg text-sm text-white bg-blue-500 hover:bg-blue-400"
                   href="{!! $shareUrl !!}" rel="nofollow noopener" target="_blank">
                    <i class="fa-brands fa-twitter pr-2"></i>共有する
                </a>
            </div>

            <div class="border shadow-sm sm:rounded-lg">
                <div class="flex flex-col md:flex-row">
                    <x-post.main-image :post="$post"></x-post.main-image>
                    <x-post.image-info :post="$post" class="sm:ml-4"></x-post.image-info>
                </div>

                <div id="favoriteAside" class="hidden transition-all duration-500 overflow-hidden">
                    <x-text.aside type="warning" class="mx-2 mt-4 sm:w-96">
                        いいねするにはログインが必要です
                        <a class="pl-2 underline" href="{{ route('login') }}">ログイン</a>
                        <a class="pl-2 underline" href="{{ route('register') }}">新規登録</a>
                    </x-text.aside>
                </div>

                <div class="mt-4">
                    <div class="flex px-2 py-2 mb-4 bg-gray-100">
                        <div class="pl-2 pr-4">
                            <a class="flex" href="/users/{{ $post->user->slug }}">
                                @if($post->user->avatars?->path)
                                    <img class="w-9 h-9 rounded-full my-auto" src="{{ asset('storage/images/avatar/' . user_directory_path($post->user_id) . '/' . $post->user->avatars->path ) }}" alt="アバター"/>
                                @else
                                    <img class="w-8 h-8 rounded-full my-auto border" src="{{ asset('images/default_user.png') }}" alt="アバター"/>
                                @endif
                                <div class="flex items-center pl-1 min-w-0">
                                    <div class="overflow-hidden truncate font-bold">{{ $post->user->name }}</div>
                                </div>
                            </a>
                        </div>

                        <div class="flex items-center font-bold text-gray-600 whitespace-nowrap">
                            <span class="hidden sm:block">投稿日: </span>{{ $post->created_at->format('Y年n月j日') }}
                        </div>

                        <div class="flex items-center pl-4">
                            @if(Auth::check() && Auth::user()->hasFavorite($post->id))
                                <button id="favoriteButton" class="btn text-lg" data-action="remove" data-post-id="{{ $post->id }}">
                                    <i class="fa-solid fa-heart text-red-500"></i>
                                </button>
                                <span class="pl-2 font-bold text-red-500 fav-count">{{ $post->favorites_count }}</span>
                            @else
                                <button id="favoriteButton" class="btn text-lg" data-action="add" data-post-id="{{ $post->id }}">
                                    <i class="fa-sharp fa-regular fa-heart"></i>
                                </button>
                                <span class="pl-2 font-bold fav-count">{{ $post->favorites_count }}</span>
                            @endif
                        </div>

                    </div>
                    <x-post.tags :tags="$post->tags"></x-post.tags>
                    <x-post.tweet :tweet="$post->tweet"></x-post.tweet>
                </div>

                @if (count($otherPosts) > 0)
                    <h2 class="font-bold pl-2">{{ $post->user->name }}さんのその他の投稿</h2>
                    <x-post.slideshow :posts="$otherPosts"></x-post.slideshow>
                @endif
            </div>

        </div>
    </div>
    <script>
        // いいねボタンのクリックイベント
        const favoriteButton = document.getElementById('favoriteButton');
        favoriteButton.addEventListener('click', function (event) {
            const action = this.dataset.action;
            if (action === 'add') {
                const postId = this.dataset.postId;
                addFavorite(postId, this);
            }
            if (action === 'remove') {
                const postId = this.dataset.postId;
                removeFavorite(postId, this);
            }
        });

        // いいね追加処理
        function addFavorite(postId, button) {
            fetch(`/favorites`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    post_id: postId
                })
            })
                .then(response => {
                    if (response.ok) {
                        response.json().then(data => {
                            if (!data.success) {
                                document.getElementById('favoriteAside').style.display = 'block';
                                return;
                            }
                            button.dataset.action = 'remove';
                            button.innerHTML = '<i class="fa-solid fa-heart text-red-500"></i>';
                            const favCount = document.querySelector('.fav-count');
                            favCount.innerText = data.favorite_count ?? 0;
                            favCount.classList.add('text-red-500');
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // いいね解除処理
        function removeFavorite(postId, button) {
            fetch(`/favorites/${postId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        response.json().then(data => {
                            if (!data.success) {
                                document.getElementById('favoriteAside').style.display = 'block';
                                return;
                            }
                            button.dataset.action = 'add';
                            button.innerHTML = '<i class="fa-sharp fa-regular fa-heart"></i>';
                            const favCount = document.querySelector('.fav-count');
                            favCount.innerText = data.favorite_count ?? 0;
                            favCount.classList.remove('text-red-500');
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
@include('layouts.footer')
