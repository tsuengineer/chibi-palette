@section('footer')
    <div class="container m-auto pt-4 pb-12 text-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex">
                <ul>
                    <li>
                        <a href="/about">
                            このサイトについて
                        </a>
                    </li>
                    <li>
                        <a href="/terms">
                            利用規約
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/aichibigirl" target="_blank">
                            Twitter
                        </a>
                    </li>
                </ul>
                <ul class="ml-8">
                    <li>
                        <a href="/model">
                            モデル紹介
                        </a>
                    </li>
                    <li>
                        <a href="/license">
                            免許証作成
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-4 text-center">
            (C) {{now()->year}} ちびキャラパレット
        </div>
    </div>
@endsection
