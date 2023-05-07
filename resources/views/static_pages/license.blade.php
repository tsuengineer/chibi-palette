@extends('layouts.common')
@include('layouts.header')
@section('title')
    免許証ジェネレータ｜{{ config('app.name') }}
@endsection

@section('content')
  <style>
    article svg {
      width: 100%;
    }
  </style>
  <div class="pt-4 pb-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      @php
          $breadcrumbs = [
              ['name' => 'トップ', 'url' => '/'],
              ['name' => '免許証ジェネレータ', 'url' => ''],
          ];
      @endphp
      <div class="px-2 pb-8">
          <x-navigation.breadcrumbs :breadcrumbs="$breadcrumbs"></x-navigation.breadcrumbs>
      </div>

      <h1 class="px-2 font-bold">免許証ジェネレータ</h1>

      <h2 class="px-2 font-bold mt-2">使い方</h2>
      <p class="px-2">初期値が設定されています。<br>値を変更して「変更を反映」ボタンを押してください。<br>作成した画像は「画像を保存」ボタンを押すことで保存できます。</p>


      <x-text.aside type="warning" class="mb-4 mx-2 md:text-base text-xs my-4">
        このツールで作成した画像はちびキャラパレットに投稿しないでください。<br>
        TwitterやInstagramなどのSNSに投稿してお使いください。
      </x-text.aside>

      <div class="p-4 bg-gray-300">
        <article></article>
      </div>

      <div class="flex">
        <div class="py-2 m-2 w-32 bg-gray-900 hover:bg-gray-400 text-white text-center text-sm sm:text-base rounded-lg shadow-lg">
          <button id="generate" type="button" onclick="createLicenseSvg();">変更を反映</button>
        </div>

        <div class="py-2 m-2 w-32 bg-gray-900 hover:bg-gray-400 text-white text-center text-sm sm:text-base rounded-lg shadow-lg">
          <button onclick="downloadSvg(this);">画像を保存</button>
        </div>

        <div class="flex items-center justify-center rounded-lg shadow-lg py-2 px-4 m-2  text-sm sm:text-base text-white bg-blue-500 hover:bg-blue-400">
          <a class="whitespace-nowrap" href="https://twitter.com/intent/tweet?text=ちびキャラパレットで免許証を作成しました。&amp;url=https://chibipalette.com/license" rel="nofollow noopener" target="_blank">
            <i class="fa-brands fa-twitter pr-2"></i>ツイート
          </a>
        </div>
      </div>

      <div class="flex justify-between w-full mx-2 my-8 text-xs sm:text-sm md:text-base  text-center">
        <div id="pictureTab" class="tab py-2 w-full border-b-2 border-gray-900">写真</div>
        <div id="userTab" class="tab py-2 w-full border-b-2 border-gray-300">ユーザー</div>
        <div id="addressTab" class="tab py-2 w-full border-b-2 border-gray-300">住所/交付</div>
        <div id="conditionsTab" class="tab py-2 w-full border-b-2 border-gray-300">条件</div>
        <div id="licenseDateTab" class="tab py-2 w-full border-b-2 border-gray-300">取得日</div>
        <div id="licenseKindTab" class="tab py-2 w-full border-b-2 border-gray-300">種類</div>
        <div id="otherTab" class="tab py-2 w-full border-b-2 border-gray-300">その他</div>
      </div>

      <form>
        <div id="userTabContent" class="tab-content m-2 hidden">
          <x-input-label for="name" value="氏名" />
          <x-text-input id="name" name="name" type="text" class="mt-1 mb-8 block w-96" value="ちびパレ" placeholder="ちびパレ" maxlength="100" />

          <x-input-label for="birth" value="生年月日" />
          <x-text-input id="birthDay" name="birthDay" type="text" class="mt-1 w-24 w-96" value="令和05 年  05 月  23 日生" placeholder="令和05 年  05 月  23 日生" maxlength="30" />
        </div>

        <div id="addressTabContent" class="tab-content m-2 hidden">
          <x-input-label for="address" value="住所" />
          <x-text-input id="address" name="address" type="text" class="mt-1 mb-8 block w-96" value="東京都新宿区西新宿2-8-1" placeholder="東京都新宿区西新宿2-8-1" maxlength="100" />

          <x-input-label for="issueYmd" value="交付年月日" />
          <x-text-input id="issueDay" name="issueDay" type="text" class="mt-1 mb-8 w-24 w-96" value="令和05 年  05 月  04 日" placeholder="令和05 年  05 月  04 日" maxlength="30" />

          <x-input-label for="issueNumber" value="交付番号" />
          <x-text-input id="issueNumber" name="issueNumber" type="text" class="mt-1 mb-8 w-24 w-96" value="12345" placeholder="12345" maxlength="20" />

          <x-input-label for="expirationDate" value="期限の文言" />
          <x-text-input id="expirationDate" name="expirationDate" type="text" class="mt-1 mb-8 w-96" value="2025年(令和07年)05月04日まで有効" placeholder="2025年(令和07年)10月01日まで有効" maxlength="30" />

          <x-input-label for="licenseColor" value="免許の色" />
          <input type="radio" id="gold" name="licenseColor" value="#b29e59" checked>
          <label for="gold">金</label>
          <input type="radio" id="blue" name="licenseColor" value="#2da6df">
          <label for="blue">青</label>
          <input type="radio" id="green" name="licenseColor" value="#a1e04b">
          <label for="green">緑</label><br>

          <x-input-label for="licenseNumber" value="免許番号" class="mt-8" />
          <x-text-input id="licenseNumber" name="licenseNumber" type="text" class="mt-1 w-96" value="123456789012" placeholder="123456789012" maxlength="20" />
        </div>

        <div id="conditionsTabContent" class="tab-content m-2 hidden">
          <x-input-label for="licenseConditions" value="免許の条件" />
          <x-text-input id="licenseConditions1" name="licenseConditions1" type="text" class="mt-1 w-96 block" value="小型車はお買い物カートに限る" placeholder="中型車は中型車(8t)に限る" maxlength="30" />
          <x-text-input id="licenseConditions2" name="licenseConditions2" type="text" class="mt-1 w-96 block" value="" placeholder="中型車(8t)と普通車はAT車に限る" maxlength="30" />
          <x-text-input id="licenseConditions3" name="licenseConditions3" type="text" class="mt-1 w-96 block" value="" placeholder="大型車は自衛隊用自動車に限る" maxlength="30" />
          <x-text-input id="licenseConditions4" name="licenseConditions4" type="text" class="mt-1 w-96 block" value="" placeholder="眼鏡等" maxlength="30" />
        </div>

        <div id="licenseDateTabContent" class="tab-content m-2 hidden">
          <x-input-label for="bikeLicenseDay" value="二・小・原 取得年月日" />
          <x-text-input id="bikeLicenseDay" name="bikeLicenseDay" type="text" class="mt-1 w-96" value="令和00年 00月 00日" placeholder="令和00年 00月 00日" maxlength="30" />

          <x-input-label for="otherLicenseDay" value="他 取得年月日" class="mt-8" />
          <x-text-input id="otherLicenseDay" name="otherLicenseDay" type="text" class="mt-1 w-96" value="令和00年 00月 00日" placeholder="令和00年 00月 00日" maxlength="30" />

          <x-input-label for="secondClassLicenseDay" value="二種 取得年月日" class="mt-8" />
          <x-text-input id="secondClassLicenseDay" name="secondClassLicenseDay" type="text" class="mt-1 w-96" value="令和00年 00月 00日" placeholder="令和00年 00月 00日" maxlength="30" />
        </div>

        <div id="otherTabContent" class="tab-content m-2 hidden">
          <x-input-label for="organization" value="組織名" />
          <x-text-input id="org1" name="org1" type="text" class="mt-1 w-32" value="イラス都" placeholder="イラス都" maxlength="30" />
          <x-text-input id="org2" name="org2" type="text" class="mt-1 mb-8 w-32" value="公安委員会" placeholder="公安委員会" maxlength="30" />

          <x-input-label for="licenseName" value="免許の名前" />
          <x-text-input id="licenseName" name="licenseName" type="text" class="mt-1 w-32" value="イラスト免許証" placeholder="イラスト免許証" maxlength="30" />
        </div>

        <div id="licenseKindTabContent" class="tab-content m-2 hidden">
          <x-input-label for="licenseKinds" value="免許の種類" />
          <label><input type="checkbox" id="licenseKinds1" value="大型" class="sm:m-2">大型</label>
          <label><input type="checkbox" id="licenseKinds2" value="中型" class="sm:m-2">中型</label>
          <label><input type="checkbox" id="licenseKinds3" value="準中型" class="sm:m-2">準中型</label>
          <label><input type="checkbox" id="licenseKinds4" value="普通" class="sm:m-2">普通</label>
          <label><input type="checkbox" id="licenseKinds5" value="大特" class="sm:m-2">大特</label>
          <label><input type="checkbox" id="licenseKinds6" value="大自二" class="sm:m-2">大自二</label>
          <label><input type="checkbox" id="licenseKinds7" value="普自二" class="sm:m-2">普自二</label><br>
          <label><input type="checkbox" id="licenseKinds8" value="小特" class="sm:m-2">小特</label>
          <label><input type="checkbox" id="licenseKinds9" value="原付" class="sm:m-2">原付</label>
          <label><input type="checkbox" id="licenseKinds10" value="大二" class="sm:m-2">大二</label>
          <label><input type="checkbox" id="licenseKinds11" value="中二" class="sm:m-2">中二</label>
          <label><input type="checkbox" id="licenseKinds12" value="普二" class="sm:m-2">普二</label>
          <label><input type="checkbox" id="licenseKinds13" value="大特二" class="sm:m-2">大特二</label>
          <label><input type="checkbox" id="licenseKinds14" value="引引二" class="sm:m-2">引引二</label>        </div>

        <div id="pictureTabContent" class="tab-content m-2">
          <x-input-label for="image" value="写真" />
          <input id="image" type="file" name="image" onchange="previewImage(this);" class="my-4">
          <div>
            <img id="preview" alt="プレビュー" style="display: none;">
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="../js/createLicenseSvg.js?202205052000"></script>
  <script>
    // 初回表示時
    createLicenseSvg();

    const previewImage = (input) => {
      const img = document.getElementById('preview');
      const reader = new FileReader();
      reader.onload = (e) => {
        img.src = e.target.result;
        img.onload = () => {
          const aspectRatio = img.width / img.height;
          if (aspectRatio > 5 / 6) {
            const newWidth = img.height * 5 / 6;
            const trimLeft = (img.width - newWidth) / 2;
            const trimmedCanvas = document.createElement('canvas');
            trimmedCanvas.width = newWidth;
            trimmedCanvas.height = img.height;
            const trimmedCtx = trimmedCanvas.getContext('2d');
            trimmedCtx.drawImage(img, trimLeft, 0, newWidth, img.height, 0, 0, newWidth, img.height);
            img.src = trimmedCanvas.toDataURL();
          } else {
            const newHeight = img.width * 6 / 5;
            const trimTop = (img.height - newHeight) / 2;
            const trimmedCanvas = document.createElement('canvas');
            trimmedCanvas.width = img.width;
            trimmedCanvas.height = newHeight;
            const trimmedCtx = trimmedCanvas.getContext('2d');
            trimmedCtx.drawImage(img, 0, trimTop, img.width, newHeight, 0, 0, img.width, newHeight);
            img.src = trimmedCanvas.toDataURL();
          }
          img.style.display = 'block';
        };
      };
      reader.readAsDataURL(input.files[0]);
    };

    const downloadSvg = () => {
        const svg = (document.getElementsByClassName('license-svg'))[0];

        let canvas = document.createElement('canvas')
        canvas.width = svg.width.baseVal.value
        canvas.height = svg.height.baseVal.value

        const ctx = canvas.getContext('2d')
        let image = new Image()

        image.onload = () => {
          // SVGデータをPNG形式に変換する
          ctx.drawImage(image, 0, 0, image.width, image.height)

          // ローカルにダウンロード
          let link = document.createElement("a")
          link.href = canvas.toDataURL() // 描画した画像のURIを返す data:image/png;base64
          link.download = "license.png"
          link.click()
        }
        image.onerror = (error) => {
          console.log(error)
        }

        // SVGデータをXMLで取り出す
        const svgData = new XMLSerializer().serializeToString(svg)
        image.src = 'data:image/svg+xml;charset=utf-8;base64,' + btoa(unescape(encodeURIComponent(svgData)))
    }

    const tab = document.getElementsByClassName("tab");
    const tabs = Array.from(tab);
    tabs.forEach(function(target) {
      target.addEventListener('click', function() {
        // タブを全部非アクティブにする(classListにhiddenを設定する)
        tabs.forEach(function(tab) {
          tab.classList.remove('border-gray-900');
          tab.classList.add('border-gray-300');
        });
        // クリックしたタブをアクティブにする(classListからhiddenを削除する)
        target.classList.remove('border-gray-300');
        target.classList.add('border-gray-900');

        // 全てのtabコンテンツを非表示にする(classListにhiddenを設定する)
        const tabContents = document.getElementsByClassName('tab-content');
        Array.from(tabContents).forEach(function(content) {
          content.classList.add('hidden');
        });
        // クリックされたタブのコンテンツを表示する(classListからhiddenを削除する)
        const tabContentId = target.id + 'Content';
        const activeContent = document.getElementById(tabContentId);
        activeContent.classList.remove('hidden');
      });
    });
  </script>
@endsection
@include('layouts.footer')
