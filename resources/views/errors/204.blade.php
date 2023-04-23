@extends('layouts.common')
@include('layouts.header')
@section('title')204｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => '204', 'url' => ''],
                ];
            @endphp
            <div class="px-2 mb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <div class="bg-white overflow-hidden">
                削除対象のデータが見つかりません。
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
