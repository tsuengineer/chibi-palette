@props(['post'])

<!-- ポップアップのスタイルを設定するCSS -->
<style>
    .bg-opacity-75 {
        --bg-opacity: 0.75;
        background-color: rgba(0, 0, 0, var(--bg-opacity));
    }
</style>

<div {!! $attributes->merge(['class' => "my-auto w-full text-gray-900"]) !!} >
    <img
        style="width:800px"
        class="w-auto h-auto max-w-full max-h-full cursor-pointer"
        src="{{ asset('storage/images/post/' . user_directory_path($post->user_id) . '/main/' . $post->ulid . '.webp') }}"
        alt="{{ $post->title }}"
        onclick="showPopup()"
    />
</div>


<!-- 画像をクリックしたら表示されるポップアップのHTML -->
<div class="fixed inset-0 z-50 flex items-center hidden bg-gray-800 bg-opacity-75">
    <div class="relative mx-auto">
        <!-- ポップアップのコンテンツ -->
        <div class="bg-white rounded-lg max-h-screen overflow-y-auto py-4">
                <div class="mx-2">
                    <button class="w-full px-4 py-1 mb-3 text-white bg-gray-900 rounded-lg" onclick="closePopup()">
                        <i class="fa-solid fa-xmark mr-2"></i>閉じる
                    </button>
                </div>

                <!-- 画像の表示 -->
                <img
                    src="{{ asset('storage/images/post/' . user_directory_path($post->user_id) . '/main/' . $post->ulid . '.webp') }}"
                    alt="{{ $post->title }}"
                    class="w-full"
                />
        </div>
    </div>
</div>

<script>
    // 画像をクリックしたときにポップアップを表示する
    function showPopup() {
        // ポップアップを表示する要素を取得
        const popupElement = document.querySelector('.fixed');

        // ポップアップを表示する要素のスタイルを変更して表示する
        popupElement.classList.remove('hidden');
    }

    function closePopup() {
        // ポップアップを閉じる要素を取得
        const popupElement = document.querySelector('.fixed');

        // ポップアップを閉じる要素のスタイルを変更して非表示にする
        popupElement.classList.add('hidden');
    }
</script>
