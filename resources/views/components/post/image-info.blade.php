@props(['post'])

<div {!! $attributes->merge(['class' => "px-2 py-4 md:w-full"]) !!} >
    @if ($post->user_id === Auth::user()?->id)
        <div class="mt-2 mb-8 text-right">
            <a
                href="/posts/{{ $post->ulid }}/edit"
                class="py-2 px-4 border font-bold rounded-lg shadow-sm"
            >
                イラストの情報を編集
            </a>
        </div>
    @endif

    <div class="flex justify-between items-end pb-1">
        <h2 class="font-bold text-sm">プロンプト</h2>
        <x-post.copy-button id="copyPrompt" class="w-28">
            <i class="fa-regular fa-clipboard text-gray-600 pr-1"></i><span id="copyPromptText">コピーする</span>
        </x-post.copy-button>
    </div>
    <p class="p-2 mb-6 bg-gray-200 rounded max-h-24 overflow-y-auto">
        @if ($post->prompt)
            {{ $post->prompt }}
        @else
            <span class="text-gray-400">N/A</span>
        @endif
    </p>
    <div class="flex justify-between items-end pb-1">
        <h2 class="font-bold text-sm">ネガティブプロンプト</h2>
        <x-post.copy-button id="copyNegativePrompt" class="w-28">
            <i class="fa-regular fa-clipboard text-gray-600 pr-1"></i><span id="copyNegativePromptText">コピーする</span>
        </x-post.copy-button>
    </div>
    <p class="p-2 mb-6 bg-gray-200 rounded max-h-24 overflow-y-auto">
        @if ($post->negative_prompt)
            {{ $post->negative_prompt }}
        @else
            <span class="text-gray-400">N/A</span>
        @endif
    </p>

    <dl class="grid grid-cols-2 gap-4 pb-6">
        @if($post->model)
            <div class="col-span-2">
                <dt class="font-bold text-sm">Model</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->model }}</dd>
            </div>
        @endif
        @if($post->aiModel->name)
            <div>
                <dt class="font-bold text-sm">AI</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->aiModel->name }}</dd>
            </div>
        @endif
        @if($post->steps)
            <div>
                <dt class="font-bold text-sm">Steps</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->steps }}</dd>
            </div>
        @endif
        @if($post->scale)
            <div>
                <dt class="font-bold text-sm">Scale</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->scale }}</dd>
            </div>
        @endif
        @if($post->seed)
            <div>
                <dt class="font-bold text-sm">Seed</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->seed }}</dd>
            </div>
        @endif
        @if($post->sampler)
            <div>
                <dt class="font-bold text-sm">Sampling</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->sampler }}</dd>
            </div>
        @endif
        @if($post->strength)
            <div>
                <dt class="font-bold text-sm">Strength</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->strength }}</dd>
            </div>
        @endif
        @if($post->noise)
            <div>
                <dt class="font-bold text-sm">Noise</dt>
                <dd class="p-2 bg-gray-200 rounded text-sm">{{ $post->noise }}</dd>
            </div>
        @endif
    </dl>

    @if ($post->description)
        <h2 class="font-bold text-sm">説明</h2>
        <p class="p-2 mb-6 bg-gray-200 rounded max-h-24 overflow-y-auto">
            {!! nl2br(e($post->description)) !!}
        </p>
    @endif
</div>
<script>
    document.getElementById('copyPrompt').addEventListener('click', function() {
        const promptText = document.querySelector('#copyPrompt').parentNode.nextElementSibling.textContent.trim();
        copyToClipboard(promptText, 'copyPromptText');
    });

    document.getElementById('copyNegativePrompt').addEventListener('click', function() {
        const negativePromptText = document.querySelector('#copyNegativePrompt').parentNode.nextElementSibling.textContent.trim();
        copyToClipboard(negativePromptText, 'copyNegativePromptText');
    });

    function copyToClipboard(text, copyButtonTextId) {
        const tempElement = document.createElement('textarea');
        tempElement.value = text;
        document.body.appendChild(tempElement);
        tempElement.select();
        document.execCommand('copy');
        document.body.removeChild(tempElement);

        // コピー成功時にボタンのテキストを「コピー完了」に変更し、3秒後に元に戻す
        const copyButtonText = document.getElementById(copyButtonTextId);
        copyButtonText.textContent = 'コピー完了';
        setTimeout(function() {
            copyButtonText.textContent = 'コピーする';
        }, 1000);
    }
</script>

