@extends('layouts.common')
@include('layouts.header')
@section('title')マイページ｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'マイページ', 'url' => ''],
                ];
            @endphp
            <div class="px-2 mb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            @if (session('success'))
                <x-text.aside type="info" class="mb-4 mx-2">
                    {{ session('success') }}
                </x-text.aside>
            @endif

            <div class="bg-white overflow-hidden border sm:rounded-lg">
                <x-profile.summary-panel :user="$user" :favoriteCount="$favoriteCount"></x-profile.summary-panel>
                <div>
                    <div class="flex border-b">
                        <button
                            id="tab-button-1"
                            class="p-3 border-b-4 active-tab"
                            onclick="switchTab(event, 1)"
                        >
                            投稿したイラスト
                        </button>
                        <button
                            id="tab-button-2"
                            class="p-3 border-b-4 inactive-tab"
                            onclick="switchTab(event, 2)"
                        >
                            いいねしたイラスト
                        </button>
                    </div>
                    <div class="p-3">
                        <div id="tab1" class="text-gray-600 active-tab-content">
                            @if (count($posts) === 0)
                                <p>投稿したイラストがありません</p>
                            @endif
                            <ul class="flex grid lg:grid-cols-8 sm:grid-cols-5 grid-cols-4">
                                @foreach ($posts as $post)
                                    <li class="p-1">
                                        <a href="/posts/{{ $post->ulid }}/edit">
                                            <img
                                                class="shadow-md w-auto h-auto rounded-lg"
                                                src="{{ asset('storage/images/post/' . user_directory_path($user->id) . '/thumbnail/' . $post->ulid . '.webp') }}"
                                                alt="{{ $post->title }}"
                                            />
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            {{ $posts->appends(['page' => request()->query('page')])->links() }}
                        </div>
                        <div id="tab2" class="text-gray-600 inactive-tab-content" style="display: none;">
                            @if (count($likedPosts) === 0)
                                <p>いいねしたイラストがありません</p>
                            @endif
                            <ul class="flex grid lg:grid-cols-8 sm:grid-cols-5 grid-cols-4">
                                @foreach ($likedPosts as $post)
                                    <li class="p-1">
                                        <a href="/posts/{{ $post->ulid }}">
                                            <img
                                                class="shadow-md w-auto h-auto rounded-lg"
                                                src="{{ asset('storage/images/post/' . user_directory_path($post->user_id) . '/thumbnail/' . $post->ulid . '.webp') }}"
                                                alt="{{ $post->title }}"
                                            />
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            {{ $likedPosts->appends(['likedPage' => request()->query('likedPage')])->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <style>
        .active-tab {
            border-bottom-width: 4px;
            border-color: #4f46e5;
            font-weight: bold;
        }
        .active-tab:focus {
            outline: none;
        }
        .inactive-tab {
            border-bottom-width: 4px;
            border-color: transparent;
        }
    </style>
    <script>
        function switchTab(event, tabNumber) {
            // クリックされたタブをアクティブにする
            const activeTab = document.querySelector(".active-tab");
            activeTab.classList.remove("active-tab");
            activeTab.classList.add("inactive-tab");

            event.target.classList.add("active-tab");
            event.target.classList.remove("inactive-tab");

            // 対応するタブコンテンツを表示する
            const activeContent = document.querySelector(".active-tab-content");
            activeContent.classList.remove("active-tab-content");
            activeContent.classList.add("inactive-tab-content");
            activeContent.style.display = "none";

            const newActiveContent = document.querySelector("#tab" + tabNumber);
            newActiveContent.classList.add("active-tab-content");
            newActiveContent.classList.remove("inactive-tab-content");
            newActiveContent.style.display = "block";
        }

        // ページ読み込み時の処理
        document.addEventListener("DOMContentLoaded", function(event) {
            const tabNumber = "{{ $tab }}"; // アクティブにするタブの番号
            const activeTab = document.querySelector("#tab-button-" + tabNumber);
            activeTab.click();
        });
    </script>
@endsection
@include('layouts.footer')
