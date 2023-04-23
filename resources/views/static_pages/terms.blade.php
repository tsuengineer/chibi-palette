@extends('layouts.common')
@include('layouts.header')
@section('title')利用規約｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => '利用規約', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <h1 class="px-2 pb-4 font-bold text-lg">利用規約</h1>
            <div class="p-2 mb-8">
                <h2 class="font-bold">第1条</h2>
                <p class="pb-2">
                    本Webサービスは、自動画像生成AIを使用して作成された画像の投稿を目的としています。投稿できる画像は、ちびキャラと呼ばれる概ね2頭身～3頭身程度のキャラクターのみ※とします。
                </p>

                <h2 class="font-bold">第2条</h2>
                <p class="pb-2">
                    ユーザーは会員登録を行い、本Webサービスを利用する際には、法令および本利用規約を遵守しなければなりません。
                </p>

                <h2 class="font-bold">第3条</h2>
                <p class="pb-2">
                    ユーザーが投稿する画像は、猥褻なものや公序良俗に反する内容を含んではなりません。また、同人や創作活動などのイラスト・アニメーションの場合でも、局部の描写がないものである必要があります(モザイクなどの処理をした場合も含む)。
                </p>

                <h2 class="font-bold">第4条</h2>
                <p class="pb-2">
                    利用規約に違反する画像は削除される可能性があります。ユーザーは、自己の責任において画像を投稿し、利用規約を遵守することに同意します。
                </p>

                <h2 class="font-bold">第5条</h2>
                <p class="pb-2">
                    ユーザーは、本Webサービスを利用するにあたり、第三者の著作権や肖像権、プライバシー権などの権利を侵害してはなりません。また、他のユーザーに対して嫌がらせや誹謗中傷を行うことは禁止されています。
                </p>

                <h2 class="font-bold">第6条</h2>
                <p class="pb-2">
                    ユーザーは、本Webサービスを利用することにより発生するいかなる損害についても、運営者は一切の責任を負いません。
                </p>

                <h2 class="font-bold">第7条</h2>
                <p class="pb-2">
                    本利用規約は、予告なく変更される場合があります。変更後の利用規約は本Webサービス上に掲載されるものとし、ユーザーは定期的に確認する責任を負います。
                </p>

                <h2 class="font-bold">第8条</h2>
                <p class="pb-2">
                    本Webサービスの利用に関して生じる紛争については、日本国法を準拠法とし、被告の居住地を管轄する地方裁判所を第一審の専属的合意管轄裁判所とすることに合意する。
                </p>

                <p class="pb-2 mt-4">
                    以上の内容を了承し、本Webサービスを利用する場合は、利用規約に同意したものとみなします。
                </p>
            </div>
            <div class="p-2">
                <h2 class="font-bold">※ちびキャラの基準(削除対象の目安)</h2>
                <div class="flex grid grid-cols-2 sm:grid-cols-4 mt-2">
                    <div class="mb-2">
                        <p><span class="font-bold text-green-600 mr-1">〇</span>問題なし(2頭身)</p>
                        <img src="/images/terms1.webp" />
                    </div>
                    <div class="mb-2">
                        <p><span class="font-bold text-green-600 mr-1">〇</span>問題なし(3頭身)</p>
                        <img src="/images/terms2.webp" />
                    </div>
                    <div class="mb-2">
                        <p><span class="font-bold text-orange-600 mr-1">△</span>ギリセーフ(4頭身)</p>
                        <img src="/images/terms3.webp" />
                    </div>
                    <div class="mb-2">
                        <p><span class="font-bold text-red-600 mr-1">×</span>アウト(5頭身以上)</p>
                        <img src="/images/terms4.webp" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
