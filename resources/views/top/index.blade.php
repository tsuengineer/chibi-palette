@extends('layouts.common')
@include('layouts.header')
@section('title')トップページ ｜{{ config('app.name') }}@endsection
@section('ogPath'){{ 'images/ogp/main.webp' }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '']
                ];
            @endphp
            <div class="px-2 mb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <h1 class="px-2 font-bold">投稿されたイラスト(最新順で表示)</h1>
            <div class="my-4">
                {{ $posts->links() }}
            </div>
            <div class="flex grid lg:grid-cols-5 md:grid-cols-4 grid-cols-2 py-2 border shadow-sm sm:rounded-lg">
                @foreach($posts as $post)
                    <x-card.illustration
                        user="{{ $post->user->name }}"
                        slug="{{ $post->user->slug }}"
                        title="{{ $post->title }}"
                        directory="{{ user_directory_path($post->user->id) }}"
                        avatar="{{ $post->user->avatars->path ?? '' }}"
                        ulid="{{ $post->ulid }}"
                    />
                @endforeach
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
