@extends('layouts.common')
@include('layouts.header')
@section('title')イラスト投稿｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'イラスト投稿', 'url' => ''],
                ];
            @endphp
            <div class="px-2 mb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            @if (count($errors) > 0)
                <x-text.aside type="error" class="mb-4 mx-2 sm:mx-0">
                    入力内容に誤りがあります。エラーメッセージを確認してください。
                </x-text.aside>
            @endif

            <form id="postUpload" method="POST" action="/posts/upload" enctype="multipart/form-data"  class="px-2 sm:px-0">
                @csrf

                @if(Auth::user()->posts()->count() >= 100)
                    <div class="bg-red-100 w-64 p-4 rounded-lg mb-2">
                        <p class="text-red-600 font-bold">※投稿数が上限に達しています。</p>
                    </div>
                @endif

                <div class="grid sm:grid-cols-2 grid-cols-1 grid-auto-rows gap-4 pb-6">
                    <div class="sm:col-span-2">
                        <label for="image" class="block text-gray-700 font-bold mb-2">
                            イラスト(10MB以内)<br><span class="text-sm text-gray-600">※大きい画像は1200×1200px以内に縮小されます</span>
                        </label>
                        <div class="mb-2 border w-64 h-64">
                            <img id="preview" class="w-auto h-auto max-w-64 max-h-64 pb-2" alt="プレビュー" style="display:none">
                        </div>
                        <input id="inputImage" type="file" name="image" onchange="previewImage(this);setForm();" required>
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>

                    <div>
                        <x-input-label for="title" value="タイトル" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" placeholder="お花見日和" maxlength="100" autocomplete="title" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <label for="ai_model_id" class="block font-medium text-sm text-gray-700">使用AI</label>
                        <select id="ai_model_id" name="ai_model_id" class="p-2 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="999">-- 使用AIを選択してください --</option>
                            @foreach($aiModels as $aiModel)
                                <option value="{{ $aiModel->id }}" {{ old('ai_model_id') == $aiModel->id ? 'selected' : '' }}>
                                    {{ $aiModel->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-form.toggle-button name="visibility_prompt" :value="old('visibility_prompt', '1')">
                            プロンプトとネガティブプロンプトを公開する
                        </x-form.toggle-button>
                    </div>

                    <div>
                        <x-input-label for="prompt" value="プロンプト" />
                        <x-form.input-textarea id="prompt" name="prompt" type="text" class="mt-1 block w-full" :value="old('prompt')" maxlength="10000" placeholder="a very cute and beautiful chibi anime girl, full body view" autocomplete="prompt" rows="8" />
                        <x-input-error class="mt-2" :messages="$errors->get('prompt')" />
                    </div>

                    <div>
                        <x-input-label for="negative_prompt" value="ネガティブプロンプト" />
                        <x-form.input-textarea id="negative_prompt" name="negative_prompt" type="text" class="mt-1 block w-full" :value="old('negative_prompt')" maxlength="10000" placeholder="nsfw, retro style, bad face, bad fingers, bad anatomy, missing fingers" autocomplete="negative_prompt" rows="8" />
                        <x-input-error class="mt-2" :messages="$errors->get('negative_prompt')" />
                    </div>

                    <div>
                        <x-input-label for="steps" value="Sampling steps" />
                        <x-text-input id="steps" name="steps" type="number" class="mt-1 block w-full" :value="old('steps')" max="9999999999" placeholder="20" autocomplete="steps" />
                        <x-input-error class="mt-2" :messages="$errors->get('steps')" />
                    </div>

                    <div>
                        <x-input-label for="scale" value="CFG Scale" />
                        <x-text-input id="scale" name="scale" type="number" step="0.01" class="mt-1 block w-full" :value="old('scale')" max="9999999999" placeholder="7" autocomplete="scale" />
                        <x-input-error class="mt-2" :messages="$errors->get('scale')" />
                    </div>

                    <div>
                        <x-input-label for="seed" value="Seed" />
                        <x-text-input id="seed" name="seed" type="number" class="mt-1 block w-full" :value="old('seed')" maxlength="100" placeholder="2144716641" autocomplete="seed" />
                        <x-input-error class="mt-2" :messages="$errors->get('seed')" />
                    </div>

                    <div>
                        <x-input-label for="sampler" value="Sampling method" />
                        <x-text-input id="sampler" name="sampler" type="text" class="mt-1 block w-full" :value="old('sampler')" maxlength="100" placeholder="DPM++ 2M Karras" autocomplete="sampler" />
                        <x-input-error class="mt-2" :messages="$errors->get('sampler')" />
                    </div>

                    <div>
                        <x-input-label for="strength" value="Strength" />
                        <x-text-input id="strength" name="strength" type="number" step="0.1" class="mt-1 block w-full" :value="old('strength')" max="9999999999" placeholder="0.8" autocomplete="strength" />
                        <x-input-error class="mt-2" :messages="$errors->get('strength')" />
                    </div>

                    <div>
                        <x-input-label for="noise" value="Noise" />
                        <x-text-input id="noise" name="noise" type="number" step="0.1" class="mt-1 block w-full" :value="old('noise')" max="9999999999" placeholder="0.1" autocomplete="noise" />
                        <x-input-error class="mt-2" :messages="$errors->get('noise')" />
                    </div>

                    <div>
                        <x-input-label for="model" value="Model" />
                        <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model')" maxlength="255" placeholder="anything-v3.0" autocomplete="model" />
                        <x-input-error class="mt-2" :messages="$errors->get('model')" />
                    </div>

                    <div>
                        <x-input-label for="tweet" value="関連ツイート(「ツイートのリンクをコピー」で取得)" />
                        <x-text-input id="tweet" name="tweet" type="text" class="mt-1 block w-full" :value="old('tweet')" maxlength="100" placeholder="https://twitter.com/aichibigirl/status/1641819740334325763" autocomplete="tweet" />
                        <x-input-error class="mt-2" :messages="$errors->get('tweet')" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input-label for="description" value="説明文" />
                        <x-form.input-textarea id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description')" maxlength="10000" placeholder="上記パラメータで伝えきれないことを書いたりしてください" autocomplete="description" rows="3" />
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    @for($i = 0; $i < 10; $i++)
                        <div class="tag-input" @if($i > 0) style="display:none" @endif>
                            <x-input-label for="tag-input-{{ $i }}"
                                           :value="$i === 0 ? 'タグ(10個まで指定できます)' : 'タグ' . ($i + 1)" />
                            <x-text-input id="tag-input-{{ $i }}" name="tags[]" type="text" class="mt-1 block w-full" :value="old('tags.'.$i)" maxlength="20" placeholder="「猫耳」「乗り物」「メイド服」など" autocomplete="description"/>
                            <x-input-error class="mt-2" :messages="$errors->get('tags.*')" />
                        </div>
                    @endfor
                </div>

                @if(Auth::user()->posts()->count() >= 100)
                    <x-primary-button disabled title="投稿数上限に達しています">
                        投稿する
                    </x-primary-button>
                @else
                    <x-primary-button>
                        投稿する
                    </x-primary-button>
                @endif

                <p class="mt-8 text-sm leading-6">
                    <a href="/terms" class="underline">利用規約</a>に沿った投稿をお願いいたします。<br>
                    規約違反のイラストは削除する場合がございます。
                </p>
            </form>
        </div>
    </div>
    <script src="../js/pngMetaData.js"></script>
    <script>
        // タグの初期表示
        const tagInputs = document.querySelectorAll('.tag-input');
        let tagCount = null;
        for (let i = 0; i < tagInputs.length; i++) {
            const tagInput = tagInputs[i];
            const input = tagInput.querySelector('input');
            if (input.value !== '') {
                tagCount = i;
            }
        }
        if(tagCount !== null) {
            for (let i = 0; i <= tagCount; i++) {
                const tagInput = tagInputs[i + 1];
                tagInput.style.display = 'inline-block';
            }
        }
        // 最初の入力フォームに入力がある場合、次の入力フォームを表示する
        tagInputs.forEach((tagInput, index) => {
            tagInput.addEventListener('input', () => {
                if(index < tagInputs.length - 1 && tagInput.querySelector('input').value !== '') {
                    tagInputs[index + 1].style.display = 'inline-block';
                    tagCount++;
                }
            });
        });

        // エンターでsubmitが発火しないようにする
        const form = document.getElementById('postUpload');
        form.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && event.target.type !== 'textarea') {
                event.preventDefault();
            }
        });

        // 画像のプレビュー
        const previewImage = (input) => {
            const img = document.getElementById('preview');
            if (input.files && input.files[0]) {
                if (!checkFileSize()) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    img.src = e.target.result;
                    img.style.display = 'block'; // 画像が読み込まれたら表示する
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                img.src = '';
                img.style.display = 'none'; // 画像がない場合は非表示にする
            }
        };

        // ファイルサイズチェック
        function checkFileSize() {
            const fileInput = document.getElementById('inputImage');
            if (fileInput.files[0].size > 1024 * 1024 * 10) {
                console.log(fileInput.files[0].size)
                alert('ファイルサイズが10MBを超えています。');
                fileInput.value = '';
                return false;
            }

            return true;
        }

        // 自動入力
        const setForm = () => {
            const inputImage = document.querySelector('#inputImage');
            const file = inputImage.files[0];
            if (file.type === "image/png") {
                extractMetaDataFromPng(file).then((metaData) => {
                    const prompt = document.getElementById('prompt');
                    const negativePrompt = document.getElementById('negative_prompt');
                    const model = document.getElementById('model');
                    const sampler = document.getElementById('sampler');
                    const scale = document.getElementById('scale');
                    const seed = document.getElementById('seed');
                    const steps = document.getElementById('steps');

                    if (metaData.prompt) {
                        prompt.innerText = metaData.prompt;
                    }
                    if (metaData.negative_prompt) {
                        negativePrompt.innerText = metaData.negative_prompt;
                    }
                    if (metaData.model) {
                        model.value = metaData.model;
                    }
                    if (metaData.model) {
                        model.value = metaData.model;
                    }
                    if (metaData.sampler) {
                        sampler.value = metaData.sampler;
                    }
                    if (metaData.scale) {
                        scale.value = metaData.scale;
                    }
                    if (metaData.seed) {
                        seed.value = metaData.seed;
                    }
                    if (metaData.steps) {
                        steps.value = metaData.steps;
                    }
                }).catch((error) => {
                    console.error(error);
                });
            }
        }
    </script>
@endsection
@include('layouts.footer')
