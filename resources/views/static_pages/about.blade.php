@extends('layouts.common')
@include('layouts.header')
@section('title')
    このサイトについて｜{{ config('app.name') }}
@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'このサイトについて', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <h1 class="px-2 font-bold">このサイトについて</h1>
            <div class="p-2">
                <p class="pb-2">
                    ちびキャラパレットは「ちびキャラ」という可愛らしいキャラクターを集めた「パレット」という意味の言葉を合わせたものです。
                </p>
                <p>
                    「ちびキャラ」という表現は、2頭身〜3頭身のキャラクターを指して使われることが多く、可愛らしくてポップなデザインのキャラクターが多いです。<br>
                    そして、「パレット」は、絵画やデザインなどで使われる複数の色を集めた板のことを指します。つまり、「ちびキャラパレット」という名前は、多様な可愛らしいキャラクターたちが集まっている、まるで色のパレットのようなイメージを表現したものとなっています。
                </p>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
