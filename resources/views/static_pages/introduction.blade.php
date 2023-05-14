@extends('layouts.common')
@include('layouts.header')
@section('title')
    Stable Diffusion WebUI の導入方法｜{{ config('app.name') }}
@endsection

@section('content')
    <div class="pt-4 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $breadcrumbs = [
                    ['name' => 'トップ', 'url' => '/'],
                    ['name' => 'Stable Diffusion WebUI の導入方法', 'url' => ''],
                ];
            @endphp
            <div class="px-2 pb-8">
                <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
            </div>

            <h1 class="px-2 mb-2 font-bold text-lg">Stable Diffusion WebUI の導入方法</h1>
            <div class="p-2">
                <p class="pb-2">
                    自分のPCでAIイラストを生成するための環境を構築する方法を紹介します。<br>
                    「Stable Diffusion automatic1111 WebUI」というUIを使います。
                </p>
                <x-text.aside type="warning" class="mb-8 mx-2 sm:mx-0">
                    この記事はWindows11で作業することを前提としています
                </x-text.aside>

                <h2 class="font-bold text-lg border-b mb-2">目次</h2>

                <p class="pb-8">
                    1. Pythonをインストール<br>
                    2. Gitをインストール<br>
                    3. Stable Diffusion WebUIをインストール<br>
                    4. Stable Diffusion WebUIを使ってみる<br>
                    5. おわりに
                </p>

                <h2 class="mb-4 font-bold text-lg border-b mb-2">1. Pythonをインストール</h2>
                <h3 class="font-bold mb-2">1.1. インストーラーをダウンロード</h3>
                <p class="pb-2">

                    <a
                        class="underline"
                        href="https://www.python.org/downloads/release/python-3109/"
                        target="_blank"
                    >
                        Python 3.10.9
                    </a>
                    を開いてください。<br>
                    ページ下部にインストーラーがあります。<br>
                    「Windows installer (64-bit)」 をクリックしてダウンロードします。
                </p>
                <img src="/images/introduction/python1.webp" class="mb-8" />

                <h3 class="font-bold mb-2">1.2. インストーラーを実行</h3>
                <p class="pb-2">
                    ダウンロードしたインストーラーをダブルクリックで起動します。
                </p>
                <img src="/images/introduction/python2.webp" class="mb-8" />

                <p class="pb-2">
                    「Add python.exe to PATH」にチェックをつけてから「Install Now」をクリックします。
                </p>
                <img src="/images/introduction/python3.webp" class="mb-8" />

                <p class="pb-2">
                    インストールが完了するのを待ちます。
                </p>
                <img src="/images/introduction/python4.webp" class="mb-8" />

                <p class="pb-2">
                    完了するとこの画面になるので、「Close」をクリックして閉じてください。
                </p>
                <img src="/images/introduction/python5.webp" class="mb-8" />


                <h2 class="mb-4 font-bold text-lg border-b">2. Gitをインストール</h2>
                <h3 class="font-bold mb-2">2.1. インストーラーをダウンロード</h3>
                <p class="pb-2">
                    <a
                        class="underline"
                        href="https://git-scm.com/downloads"
                        target="_blank"
                    >
                        Git - Downloads
                    </a>
                    を開いてください。<br>
                    まず「Windows」をクリックします。
                </p>

                <img src="/images/introduction/git1.webp" class="mb-8" />

                <p class="pb-2">
                    次に「64-bit Git for Windows Setup.」をクリックしてインストーラーをダウンロードします。
                </p>
                <img src="/images/introduction/git2.webp" class="mb-8" />

                <h3 class="font-bold mb-2">2.2. インストーラーを実行</h3>
                <p class="pb-2">
                    ダウンロードしたインストーラーをダブルクリックで起動します。
                </p>
                <img src="/images/introduction/git3.webp" class="mb-8" />

                <p class="pb-2">
                    「Next」をクリックします。
                </p>
                <img src="/images/introduction/git4.webp" class="mb-8" />

                <p class="pb-2">
                    「Next」をクリックし続けるとこの画面になるので待ちます。
                </p>
                <img src="/images/introduction/git5.webp" class="mb-8" />

                <p class="pb-2">
                    完了するとこの画面になるので、「Finish」をクリックして閉じてください。
                </p>
                <img src="/images/introduction/git6.webp" class="mb-8" />

                <h2 class="mb-4 font-bold text-lg border-b">3. Stable Diffusion WebUIをインストール</h2>
                <h3 class="font-bold mb-2">3.1. Git Bashを起動する</h3>
                <p class="pb-2">
                    Stable Diffusion WebUIをインストールしたいフォルダを開きます。<br>
                    (※この例では、Cドライブ直下にAIというフォルダを作成しています。)<br>
                    右クリックから「その他のオプションを表示」をクリックし、「Git Bash Here」をクリックします。
                </p>
                <img src="/images/introduction/webui1.webp" class="mb-8" />

                <h3 class="font-bold">3.2. Cloneとサブモジュールの初期化</h3>
                <p class="pb-2">
                    「git clone https://github.com/lshqqytiger/stable-diffusion-webui-directml」の文字をコピーして、Git Bashのウィンドウに右クリックで貼り付けします。
                </p>
                <img src="/images/introduction/webui2.webp" class="mb-4" />
                <img src="/images/introduction/webui3.webp" class="mb-8" />

                <p class="pb-2">
                    エンターキーを押してしばらく待つと以下の状態になります。
                </p>
                <img src="/images/introduction/webui4.webp" class="mb-8" />

                <p class="pb-2">
                    同様に以下の文字列もコピーしてGit Bashのウィンドウに貼り付けてエンターキーを押します。<br>
                    「cd stable-diffusion-webui-directml」<br>
                    「git submodule init」<br>
                    「git submodule update」
                </p>
                <img src="/images/introduction/webui5.webp" class="mb-8" />

                <p class="pb-2">
                    stable-diffusion-webui-directml というフォルダが作成されていれば成功です。
                </p>
                <img src="/images/introduction/webui6.webp" class="mb-8" />

                <h2 class="mb-4 font-bold text-lg border-b">4. Stable Diffusion WebUIを使ってみる</h2>
                <h3 class="font-bold mb-2">4.1. Stable Diffusion WebUIを起動する</h3>
                <p class="pb-2">
                    stable-diffusion-webui-directml フォルダを開いて、「webui-user.bat」をダブルクリックして起動します。
                </p>
                <img src="/images/introduction/start1.webp" class="mb-8" />

                <p class="pb-2">
                    初回起動時は5～10分くらい待ちます。
                </p>
                <img src="/images/introduction/start2.webp" class="mb-8" />

                <p class="pb-2">
                    http://127.0.0.1:7860 のような文字が表示されれば起動完了です。
                </p>
                <img src="/images/introduction/start3.webp" class="mb-8" />

                <p class="pb-2">
                    ブラウザに「http://127.0.0.1:7860」と入力すると、Stable Diffusion WebUIが開きます。
                </p>
                <img src="/images/introduction/start4.webp" class="mb-8" />

                <p class="pb-2">
                    プロンプトに「1 girl」と入力して「Generate」をクリックしてみましょう。<br>
                    画像が生成されれば成功です。
                </p>
                <img src="/images/introduction/start5.webp" class="mb-8" />


                <h2 class="font-bold text-lg border-b mb-2">5. おわりに</h2>
                <p class="pb-2">
                    画像を生成できるようになりましたが、アニメキャラのようなちびキャラは作れません。<br>
                    アニメキャラのような画風のイラストを生成するには、そのようなイラストを学習したモデルをインストールする必要があります。<br>
                    モデルのインストール方法は<a href="/add-model" class="underline">Stable Diffusion WebUI にモデルを追加する方法</a>で解説しています。
                </p>
            </div>
        </div>
    </div>
@endsection
@include('layouts.footer')
