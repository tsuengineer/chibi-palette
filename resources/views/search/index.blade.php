@extends('layouts.common')
@include('layouts.header')
@section('title')検索｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => '検索', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-2">
                    <h1 class="mb-2 font-bold">検索</h1>
                    <x-navigation.search></x-navigation.search>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('layouts.footer')
