@extends('layouts.common')
@include('layouts.header')
@section('title')
    モデルを追加する方法｜{{ config('app.name') }}
@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'モデルを追加する方法', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <h1 class="px-2 mb-2 font-bold text-lg">Stable Diffusion WebUI にモデルを追加する方法</h1>
            <div class="p-2">
                <x-text.aside type="warning" class="mb-8 mx-2 sm:mx-0">
                    この記事はStable Diffusion WebUIの環境構築が完了していることを前提としています<br>
                    まだの方は<a href="/introduction" class="underline">導入方法</a>をご覧ください
                </x-text.aside>

                <p class="pb-2">
                    この記事では「anything-v3.0」というモデルを使って説明します。<br>
                </p>

                <h2 class="font-bold text-lg border-b mb-2">目次</h2>

                <p class="pb-8">
                    1. モデルをダウンロード<br>
                    2. モデルを配置<br>
                    3. 実際に使ってみる<br>
                    4. おわりに
                </p>

                <h2 class="mb-4 font-bold text-lg border-b mb-2">1. モデルをダウンロード</h2>
                <p class="pb-2">
                    <a
                        class="underline"
                        href="https://huggingface.co/Linaqruf/anything-v3.0/blob/main/anything-v3-full.safetensors"
                        target="_blank"
                    >
                        Linaqruf / anything-v3.0
                    </a>
                    を開いてください。<br>
                    「download」 をクリックします。
                </p>
                <img src="/images/add_model/download1.webp" class="mb-8" />

                <h2 class="mb-4 font-bold text-lg border-b">2. モデルを配置</h2>
                <p class="pb-2">
                    「stable-diffusion-webui-directml/models/Stable-diffusion」にダウンロードしたモデルを配置します。
                </p>
                <img src="/images/add_model/download2.webp" class="mb-8" />

                <h2 class="mb-4 font-bold text-lg border-b">3. 実際に使ってみる</h2>
                <h3 class="font-bold mb-2">3.1. Anything-v3.0を使う</h3>
                <p class="pb-2">
                    「anything-v3-full.safetensors」を選択します。
                </p>
                <img src="/images/add_model/sd1.webp" class="mb-8" />

                <h3 class="font-bold">3.2. イラストを生成する</h3>
                <p class="pb-2">
                    プロンプトに「1 girl」と指定してGenerateをクリックしてみます。<br>
                    初期モデルと比べてアニメキャラっぽいイラストを生成できました。
                </p>
                <img src="/images/add_model/sd2.webp" class="mb-8" />

                <h3 class="font-bold">3.3. ちびキャラを生成する</h3>
                <p class="pb-2">
                    プロンプトとネガティブプロンプトを入力してGenerateをクリックします。<br>
                    プロンプト「a very cute and beautiful chibi anime girl, chibi, smile, cat ears」<br>
                    ネガティブプロンプト「nsfw, (worst quality, low quality:1.4), flat color, flat shading, bad face, bad fingers, bad anatomy, missing fingers」<br>
                </p>
                <img src="/images/add_model/sd3.webp" class="mb-8" />

                <h2 class="font-bold text-lg border-b mb-2">4. おわりに</h2>
                <p class="pb-2">
                    ちびキャラを作成できるようになりました。<br>
                    キャラパレットに投稿されたイラストのプロンプトを参考に色々試してみてください。<br>
                    モデルを変えると画風が変わります。どんなモデルがあるかは、<a href="/model" class="underline">モデル紹介</a>をご覧ください。
                </p>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
