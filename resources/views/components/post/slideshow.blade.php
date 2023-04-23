@props(['posts'])

<div class="flex items-center justify-between bg-gray-100 py-4">
    <button class="flex items-center justify-center w-10 h-10 px-2 mx-2 rounded-lg border text-gray-700 bg-gray-300 hover:bg-gray-300 focus:outline-none" onclick="prevSlide()">
        <span class="font-bold">&lt;</span>
    </button>
    <div class="flex overflow-x-auto space-x-4 overflow-x-hidden">
        @foreach ($posts as $post)
            <div class="w-32 h-32 flex-none bg-gray-300 bg-center bg-cover rounded-lg shadow">
                <a href="{{ route('posts.show', ['ulid' => $post->ulid]) }}">
                    <img
                        id="preview"
                        src="{{ asset('storage/images/post/' . user_directory_path($post->user_id) . '/thumbnail/' . $post->ulid . '.webp') }}"
                        alt="{{ $post->title }}"
                    />
                </a>
            </div>
        @endforeach
    </div>
    <button class="flex items-center justify-center w-10 h-10 px-2 mx-2 rounded-lg border text-gray-700 bg-gray-300 hover:bg-gray-300 focus:outline-none" onclick="nextSlide()">
        <span class="font-bold">&gt;</span>
    </button>
</div>

<script>
    function prevSlide() {
        const slider = document.querySelector(".overflow-x-auto");
        slider.scrollBy({
            left: -144,
            behavior: 'smooth'
        });
    }

    function nextSlide() {
        const slider = document.querySelector(".overflow-x-auto");
        slider.scrollBy({
            left: 144,
            behavior: 'smooth'
        });
    }
</script>
