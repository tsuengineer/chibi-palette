@section('title-guest', '新規ユーザー登録')

<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Slug -->
        <div>
            <x-input-label for="slug" value="ユーザーID (半角の英数字、ハイフン「-」、アンダースコア「_」が使えます)" />
            <x-text-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" pattern="[a-zA-Z0-9_-]+" required autofocus autocomplete="slug" />
            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" value="ユーザー名" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="メールアドレス" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="パスワード" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="パスワード(再入力)" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                すでに登録済みの方はこちら
            </a>

            <x-primary-button class="ml-4">
                登録する
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
