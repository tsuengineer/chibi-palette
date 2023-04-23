@section('footer')
    <div class="container m-auto pt-4 pb-12 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ul class="flex">
                <li>
                    <a href="/about">
                        このサイトについて
                    </a>
                </li>
                <li class="pl-5">
                    <a href="/terms">
                        利用規約
                    </a>
                </li>
                <li class="pl-5">
                    <a href="https://twitter.com/aichibigirl" target="_blank">
                        Twitter
                    </a>
                </li>
            </ul>
        </div>

        <div class="pt-4 text-center">
            (C) {{now()->year}} ちびキャラパレット
        </div>
    </div>
@endsection
