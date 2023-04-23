@extends('layouts.common')
@include('layouts.header')
@section('title')
    ランキング｜{{ config('app.name') }}
@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'ランキング', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="font-bold px-2">ランキング</h1>
                <p class="px-2 text-sm">※1時間ごとに更新</p>
                <ul class="flex my-8 mx-2" id="rankingTabs">
                    <li id="weeklyButton" class="">
                        <button class="nav-link block py-2 px-8" id="daily-tab">
                            7日間
                        </button>
                    </li>
                    <li id="monthlyButton" class="">
                        <button class="nav-link block py-2 px-8" id="daily-tab">
                            30日間
                        </button>
                    </li>
                </ul>

                <div id="rankingContent">
                    <div id="weeklyRanking">
                        <h2 class="px-2 mb-1 font-bold">イラストのいいね数(直近7日)</h2>
                        <div id="postWeeklyLikes" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($postWeeklyLikes as $index => $ranking)
                                    <x-card.illustration
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->post->user->name }}"
                                        slug="{{ $ranking->post->user->slug }}"
                                        title="{{ $ranking->post->title }}"
                                        directory="{{ user_directory_path($ranking->post->user->id) }}"
                                        avatar="{{ $ranking->post->user->avatars->path ?? '' }}"
                                        ulid="{{ $ranking->post->ulid }}"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <h2 class="px-2 mb-1 font-bold">イラストの閲覧数(直近7日)</h2>
                        <div id="postWeeklyAccess" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($postWeeklyAccess as $index => $ranking)
                                    <x-card.illustration
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->post->user->name }}"
                                        slug="{{ $ranking->post->user->slug }}"
                                        title="{{ $ranking->post->title }}"
                                        directory="{{ user_directory_path($ranking->post->user->id) }}"
                                        avatar="{{ $ranking->post->user->avatars->path ?? '' }}"
                                        ulid="{{ $ranking->post->ulid }}"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <h2 class="px-2 mb-1 font-bold">ユーザーごとのいいね数(直近7日)</h2>
                        <div id="userWeeklyLikes" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($userWeeklyLikes as $index => $ranking)
                                    <x-card.user
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->user->name }}"
                                        twitter="{{ $ranking->user->twitter }}"
                                        instagram="{{ $ranking->user->instagram }}"
                                        likeCount="{{ $ranking->point }}"
                                        slug="{{ $ranking->user->slug }}"
                                        directory="{{ user_directory_path($ranking->user->id) }}"
                                        avatar="{{ $ranking->user->avatars->path ?? '' }}"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <h2 class="px-2 mb-1 font-bold">ユーザーごとのイラストページの閲覧数(直近7日)</h2>
                        <div id="userWeeklyLikes" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($userWeeklyAccess as $index => $ranking)
                                    <x-card.user
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->user->name }}"
                                        twitter="{{ $ranking->user->twitter }}"
                                        instagram="{{ $ranking->user->instagram }}"
                                        viewCount="{{ $ranking->point }}"
                                        slug="{{ $ranking->user->slug }}"
                                        directory="{{ user_directory_path($ranking->user->id) }}"
                                        avatar="{{ $ranking->user->avatars->path ?? '' }}"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </div>


                    <div id="monthlyRanking" class="hidden">
                        <h2 class="px-2 mb-1 font-bold">イラストのいいね数(直近30日)</h2>
                        <div id="postMonthlyLikes" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($postMonthlyLikes as $index => $ranking)
                                    <x-card.illustration
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->post->user->name }}"
                                        slug="{{ $ranking->post->user->slug }}"
                                        title="{{ $ranking->post->title }}"
                                        directory="{{ user_directory_path($ranking->post->user->id) }}"
                                        avatar="{{ $ranking->post->user->avatars->path ?? '' }}"
                                        ulid="{{ $ranking->post->ulid }}"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <h2 class="px-2 mb-1 font-bold">イラストの閲覧数(直近30日)</h2>
                        <div id="postMonthlyAccess" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($postMonthlyAccess as $index => $ranking)
                                    <x-card.illustration
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->post->user->name }}"
                                        slug="{{ $ranking->post->user->slug }}"
                                        title="{{ $ranking->post->title }}"
                                        directory="{{ user_directory_path($ranking->post->user->id) }}"
                                        avatar="{{ $ranking->post->user->avatars->path ?? '' }}"
                                        ulid="{{ $ranking->post->ulid }}"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <h2 class="px-2 mb-1 font-bold">ユーザーごとのいいね数(直近30日)</h2>
                        <div id="userMonthlyLikes" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($userMonthlyLikes as $index => $ranking)
                                    <x-card.user
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->user->name }}"
                                        twitter="{{ $ranking->user->twitter }}"
                                        instagram="{{ $ranking->user->instagram }}"
                                        likeCount="{{ $ranking->point }}"
                                        slug="{{ $ranking->user->slug }}"
                                        directory="{{ user_directory_path($ranking->user->id) }}"
                                        avatar="{{ $ranking->user->avatars->path ?? '' }}"
                                    />
                                @endforeach
                            </div>
                        </div>

                        <h2 class="px-2 mb-1 font-bold">ユーザーごとのイラストページの閲覧数(直近30日)</h2>
                        <div id="userMonthlyLikes" class="pb-8">
                            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                                @foreach($userMonthlyAccess as $index => $ranking)
                                    <x-card.user
                                        rank="{{ ($index + 1) }}"
                                        user="{{ $ranking->user->name }}"
                                        twitter="{{ $ranking->user->twitter }}"
                                        instagram="{{ $ranking->user->instagram }}"
                                        viewCount="{{ $ranking->point }}"
                                        slug="{{ $ranking->user->slug }}"
                                        directory="{{ user_directory_path($ranking->user->id) }}"
                                        avatar="{{ $ranking->user->avatars->path ?? '' }}"
                                    />
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // 初期状態ではweeklyButtonをアクティブ状態にする
        document.getElementById('weeklyButton').classList.add('border-b-2', 'border-gray-900');
        document.getElementById('monthlyButton').classList.add('border-b-2', 'border-gray-200');

        // weeklyButtonをクリックしたらweeklyRankingを表示する
        document.getElementById('weeklyButton').addEventListener('click', function() {
            // weeklyButtonをアクティブ状態にし、monthlyButtonのアクティブ状態を解除する
            this.classList.add('border-b-2', 'border-gray-900');
            document.getElementById('monthlyButton').classList.remove('border-gray-900');
            document.getElementById('monthlyButton').classList.add('border-gray-200');
            // weeklyRankingを表示し、monthlyRankingを非表示にする
            document.getElementById('weeklyRanking').classList.remove('hidden');
            document.getElementById('monthlyRanking').classList.add('hidden');
        });

        // monthlyButtonをクリックしたらmonthlyRankingを表示する
        document.getElementById('monthlyButton').addEventListener('click', function() {
            // monthlyButtonをアクティブ状態にし、weeklyButtonのアクティブ状態を解除する
            this.classList.add('border-b-2', 'border-gray-900');
            document.getElementById('weeklyButton').classList.remove('border-gray-900');
            document.getElementById('weeklyButton').classList.add('border-gray-200');
            // monthlyRankingを表示し、weeklyRankingを非表示にする
            document.getElementById('monthlyRanking').classList.remove('hidden');
            document.getElementById('weeklyRanking').classList.add('hidden');
        });
    </script>
@endsection

@include('layouts.footer')
