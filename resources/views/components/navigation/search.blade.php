<form class="flex w-full" action="{{ route('search.search') }}" method="POST">
    @csrf

    <div class="relative flex m-auto w-full">
        <input id='searchInput' class="w-full bg-white border border-gray-300 rounded-md py-2 px-10 text-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" type="text" placeholder="キーワード" name="keyword">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
            <i class="fa-solid fa-magnifying-glass text-gray-500"></i>
        </span>
        <button id="searchClear" class="absolute inset-y-0 right-0 flex items-center m-1 p-2 rounded-full text-gray-600 hover:bg-purple-200 transition-colors duration-300 hidden" type="button">
            <i class="fa-solid fa-circle-xmark"></i>
        </button>
    </div>
</form>
<script>
    const searchInput = document.querySelector('#searchInput');
    const clearButton = document.querySelector('#searchClear');

    searchInput.addEventListener('input', () => {
        clearButton.classList.toggle('hidden', !searchInput.value);
    });

    clearButton.addEventListener('click', () => {
        searchInput.value = '';
        searchInput.focus();
        clearButton.classList.add('hidden');
    });
</script>
