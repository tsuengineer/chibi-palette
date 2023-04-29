@extends('layouts.common')
@include('layouts.header')
@section('title')モデル紹介｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'モデル紹介', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <h1 class="px-2 pb-4 font-bold text-lg">モデル紹介</h1>
            <p class="px-2">Stable Diffusionで使えるマージ済みモデルを紹介します。</p>

            <x-card.model
                title="Hanamix"
                directory="hanamix"
                tweet="https://twitter.com/hanabi_aiart/status/1651510252515512322"
                downloadLink="https://huggingface.co/Hanabiaiart/Hanamix"
                class="mb-4" />

            <x-card.model
                title="COreMixPure"
                directory="coremix"
                tweet="https://twitter.com/core_tan/status/1647193886761324544"
                downloadLink="https://huggingface.co/corechan/CoreMix"
                class="mb-4" />

            <x-card.model
                title="ShiratakiMix"
                directory="shiratakimix"
                tweet="https://twitter.com/Vsukiyaki_AIArt/status/1644490244207542272"
                downloadLink="https://huggingface.co/Vsukiyaki/ShiratakiMix"
                class="mb-4" />
        </div>
    </div>
@endsection
@include('layouts.footer')
