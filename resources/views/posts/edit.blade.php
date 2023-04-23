@extends('layouts.common')
@include('layouts.header')
@section('title')イラスト編集 {{ $post->title }}｜{{ config('app.name') }}@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'イラスト編集', 'url' => ''],
                ];
            @endphp
            <div class="px-2 mb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <form id="postUpdate" method="POST" action="{{ route('posts.update', $post->ulid) }}" class="px-2 sm:px-0">
                @csrf
                @method('PUT')

                <div class="grid sm:grid-cols-2 grid-cols-1 grid-auto-rows gap-4 pb-16">
                    <div class="sm:col-span-2">
                        <label for="image" class="block text-gray-700 font-bold mb-2">イラスト(変更不可)</label>
                        <img id="preview" class="w-64 h-64 pb-2" src="{{ asset('storage/images/post/' . user_directory_path($post->user_id) . '/thumbnail/' . $post->ulid . '.webp') }}" alt="{{ $post->title }}">
                    </div>

                    <div>
                        <x-input-label for="title" value="タイトル" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $post->title)" maxlength="100" placeholder="お花見日和" required autocomplete="title" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <label for="ai_model_id" class="block font-medium text-sm text-gray-700">使用AI</label>
                        <select id="ai_model_id" name="ai_model_id" class="p-2 mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="">-- 使用AIを選択してください --</option>
                            @foreach($aiModels as $aiModel)
                                <option value="{{ $aiModel->id }}" {{ $post->ai_model_id === $aiModel->id ? 'selected' : '' }}>{{ $aiModel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <x-form.toggle-button name="visibility_prompt" :value="old('visibility_prompt', (string)$post->visibility_prompt)">
                            プロンプトとネガティブプロンプトを公開する
                        </x-form.toggle-button>
                    </div>

                    <div>
                        <x-input-label for="prompt" value="プロンプト" />
                        <x-form.input-textarea id="prompt" name="prompt" type="text" class="mt-1 block w-full" :value="old('prompt', $post->prompt)" maxlength="10000" placeholder="a very cute and beautiful chibi anime girl, full body view" autocomplete="prompt" rows="8" />
                        <x-input-error class="mt-2" :messages="$errors->get('prompt')" />
                    </div>

                    <div>
                        <x-input-label for="negative_prompt" value="ネガティブプロンプト" />
                        <x-form.input-textarea id="negative_prompt" name="negative_prompt" type="text" class="mt-1 block w-full" :value="old('negative_prompt', $post->negative_prompt)" maxlength="10000" placeholder="nsfw, retro style, bad face, bad fingers, bad anatomy, missing fingers" autocomplete="negative_prompt" rows="8" />
                        <x-input-error class="mt-2" :messages="$errors->get('negative_prompt')" />
                    </div>

                    <div>
                        <x-input-label for="steps" value="Sampling steps" />
                        <x-text-input id="steps" name="steps" type="number" class="mt-1 block w-full" :value="old('steps', $post->steps)" max="9999999999" placeholder="20" autocomplete="steps" />
                        <x-input-error class="mt-2" :messages="$errors->get('steps')" />
                    </div>

                    <div>
                        <x-input-label for="scale" value="CFG Scale" />
                        <x-text-input id="scale" name="scale" type="number" step="0.01" class="mt-1 block w-full" :value="old('scale', $post->scale)" max="9999999999" placeholder="7" autocomplete="scale" />
                        <x-input-error class="mt-2" :messages="$errors->get('scale')" />
                    </div>

                    <div>
                        <x-input-label for="seed" value="Seed" />
                        <x-text-input id="seed" name="seed" type="number" class="mt-1 block w-full" :value="old('seed', $post->seed)" maxlength="100" placeholder="2144716641" autocomplete="seed" />
                        <x-input-error class="mt-2" :messages="$errors->get('seed')" />
                    </div>

                    <div>
                        <x-input-label for="sampler" value="Sampling method" />
                        <x-text-input id="sampler" name="sampler" type="text" class="mt-1 block w-full" :value="old('sampler', $post->sampler)" maxlength="100" placeholder="DPM++ 2M Karras" autocomplete="sampler" />
                        <x-input-error class="mt-2" :messages="$errors->get('sampler')" />
                    </div>

                    <div>
                        <x-input-label for="strength" value="Strength" />
                        <x-text-input id="strength" name="strength" type="number" step="0.1" class="mt-1 block w-full" :value="old('strength', $post->strength)" max="9999999999" placeholder="0.8" autocomplete="strength" />
                        <x-input-error class="mt-2" :messages="$errors->get('strength')" />
                    </div>

                    <div>
                        <x-input-label for="noise" value="Noise" />
                        <x-text-input id="noise" name="noise" type="number" step="0.1" class="mt-1 block w-full" :value="old('noise', $post->noise)" max="9999999999" placeholder="0.1" autocomplete="noise" />
                        <x-input-error class="mt-2" :messages="$errors->get('noise')" />
                    </div>

                    <div>
                        <x-input-label for="model" value="Model" />
                        <x-text-input id="model" name="model" type="text" class="mt-1 block w-full" :value="old('model', $post->model)" maxlength="255" placeholder="anything-v3.0" autocomplete="model" />
                        <x-input-error class="mt-2" :messages="$errors->get('model')" />
                    </div>

                    <div>
                        <x-input-label for="tweet" value="関連ツイート(「ツイートのリンクをコピー」で取得)" />
                        <x-text-input id="tweet" name="tweet" type="text" class="mt-1 block w-full" :value="old('tweet', $post->tweet)" maxlength="100" placeholder="https://twitter.com/aichibigirl/status/1641819740334325763" autocomplete="tweet" />
                        <x-input-error class="mt-2" :messages="$errors->get('tweet')" />
                    </div>

                    <div class="sm:col-span-2">
                        <x-input-label for="description" value="説明文" />
                        <x-form.input-textarea id="description" name="description" type="text" class="mt-1 block w-full" :value="old('description', $post->description)" maxlength="10000" placeholder="上記パラメータで伝えきれないことを書いたりしてください" autocomplete="description" rows="3" />
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    @for($i = 0; $i < 10; $i++)
                        <div class="tag-input" @if ($i > 0 && empty($post->tags[$i - 1])) style="display:none" @endif>
                            <x-input-label for="tag-input-{{ $i }}"
                                           :value="$i === 0 ? 'タグ(10個まで指定できます)' : 'タグ' . ($i + 1)" />
                            <x-text-input id="tag-input-{{ $i }}" name="tags[]" type="text" class="mt-1 block w-full" :value="old('tags.' . $i, isset($post->tags[$i]->name) ? $post->tags[$i]->name : '')" maxlength="20" placeholder="「猫耳」「乗り物」「メイド服」など" autocomplete="description"/>
                            <x-input-error class="mt-2" :messages="$errors->get('tags.*')" />
                        </div>
                    @endfor
                </div>

                <x-primary-button>
                    更新する
                </x-primary-button>

                <x-form.delete-button class="ml-4" onclick="openModal()">
                    削除
                </x-form.delete-button>
            </form>

            <!-- モーダル -->
            <div class="hidden fixed inset-0 w-full h-full bg-gray-900 bg-opacity-50 flex justify-center items-center" id="modal">
                <div class="bg-white rounded-md p-4">
                    <p class="text-center text-gray-800 p-4">
                        投稿を削除しようとしています。<br>
                        この操作は元に戻せません。
                    </p>
                    <p class="text-center text-gray-800 p-4">
                        削除するにはフィールドに「完全に削除」と入力してください。
                    </p>
                    <div class="flex justify-center items-center">
                        <form id="deleteForm" action="{{ route('posts.delete', $post->ulid) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-text-input name="deleteConfirmText" type="text" class="mt-2 mb-6 block w-full" value="" placeholder="完全に削除"/>
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 mr-2">削除する</button>
                            <button type="button" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500" onclick="closeModal()">戻る</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

        function openModal() {
            document.getElementById("modal").classList.remove("hidden");
        }
        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
        }
    </script>
@endsection
@include('layouts.footer')
