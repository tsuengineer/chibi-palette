# バージョン
- PHP 8.1
- Laravel 10
- npm 9.19.2
- node v18.12.0

# 環境構築手順

- `sail up`
- `sail artisan migrate`
- `npm run dev` 

# 本番環境デプロイ(ロリポップ)

ssh接続
```
$ ssh -oHostKeyAlgorithms=+ssh-dss sub.jp-[ロリポップのID]@ssh.lolipop.jp -p 2222
```

PHP8.1を使う(初回だけ)
```
PATH=/usr/local/php8.1/bin:$PATH
export PATH
```

変更を反映する(初回だけ)
```
source ~/.bash_profile
```

GitHubからソースコードをとってくる(初回だけ)
```
git clone git@github.com:tsuengineer/chibi-palette.git
```

vendorディレクトリを作成する
```
composer install
```

パーミッションを設定する
```
chmod -R 777 storage
chmod -R 775 bootstrap/cache
```

.envを修正する
```
APP_NAME=project-name
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://chibipalette.com

DB_CONNECTION=mysql
DB_HOST=mysql***.phy.lolipop.lan
DB_PORT=3306
DB_DATABASE=LAA*******-***
DB_USERNAME=LAA*******
DB_PASSWORD=**********
```

キーとDBを作成する(初回だけ)
```
php artisan key:generate
php artisan migrate
```

ロリポップの管理画面で公開フォルダを設定する(初回だけ)
```
chibi-palette/public を指定する
```
