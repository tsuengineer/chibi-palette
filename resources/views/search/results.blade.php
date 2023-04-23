@extends('layouts.common')
@include('layouts.header')
@section('title')検索結果｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => '検索結果', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="px-2 font-bold">検索結果</h1>

                @if (isset($keyword))
                    <p class="p-2">キーワード検索: "{{ $keyword }}"</p>
                @elseif (isset($tag))
                    <p class="p-2">タグ検索: "{{ $tag }}"</p>
                @endif

                @if (count($posts) !== 0)
                    <div class="my-4">
                        {{ $posts->links() }}
                    </div>
                    <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                        @foreach($posts as $post)
                            <x-card.illustration
                                user="{{ $post->user->name }}"
                                slug="{{ $post->user->slug }}"
                                title="{{ $post->title }}"
                                image="{{ $post->ulid }}.webp"
                                directory="{{ user_directory_path($post->user->id) }}"
                                avatar="{{ $post->user->avatars->path ?? '' }}"
                                ulid="{{ $post->ulid }}"
                            />
                        @endforeach
                    </div>
                @else
                    <p class="p-2">検索結果が0件でした。<br>キーワードを変えて検索してみてください。</p>
                    <div class="p-2">
                        <h1 class="mb-2 font-bold">検索</h1>
                        <x-navigation.search></x-navigation.search>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@include('layouts.footer')
