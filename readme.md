# 当プラグインについて

当プラグインには、phpファイル以外に、jsファイルとcssファイルが含まれます。
プラグイン用に特別なテーブルの作成は行いません。
キャストの日記機能を利用するには別途Postieというプラグインを導入して設定してください。


# 機能一覧

* キャスト管理機能を追加できます。
* キャストのスケジュール管理ができます。
* Postieプラグインと連携して、キャストの日記投稿ができます。

# Help

URL:https://github.com/jirentaicho/SuperNightPlugin


# singleページの作成

キャストのプロフィールページを作成するには、singleページを作成してください。
キャストの情報は全てカスタムフィールドにて作成します。
キャストのカスタムフィールド情報はAPIから取得できます。

必要となるsingleページ

* single-cast.php
* single-mailpost.php


# Postieとの連携

キャスト個別投稿を利用するにはPostieプラグインを別途インストールしてください。
キャストの投稿はカスタム投稿タイプを利用します。
キャスト個別投稿の記事取得は、APIから取得できます。

ユーザーを追加する必要はありません。キャストの登録時にメールアドレスを入力してください。

# キャストの登録

キャストの登録では、必要なカスタムフィールドを設定します。
Postieプラグインを導入していれば、自動的に入力したメールアドレスがPostie側にも登録されます。

# APIの利用

APIを利用してテーマを拡張します。

APIのインスタンスがglobalの$super_night_apiに登録されています。

APIを利用したいファイルで以下を実行することでAPIの実行テストが行えます。
~~~
global $super_night_api;
$super_night_api->superNightApiTest();
~~~

## API

テーマの作成にAPIをお使いください。

* キャストIDからカスタムフィールドを取得
* キャストIDからemailを取得
* キャストIDから、そのキャストのメール投稿記事一覧を取得
* キャストIDから、そのキャストのスケジュール連想配列を取得



### 使用例

#### 画像を表示する
~~~
global $super_night_api;
$fields = $super_night_api->getCastField($post_obj->ID);
var_dump($fields);
echo '<div id="main_image_preview">' . wp_get_attachment_image($fields['image'], 'small') . '</div>';
~~~

### メール投稿記事一覧を表示する


~~~
global $super_night_api;
$result = $super_night_api->getAllMailPost();

foreach ( $result as $post ){
    echo '<P>';
    $url = get_permalink($post->ID);
    echo '<a href="' . $url . '"> ' . $post->post_title . '</a>';
    echo '</P>';
}
~~~



# API一覧

~~~
getAllMailPost()

getMailPostByMail($email)

getCastEmail($id)

getCastField($id)

getMailPostById($id)

getScheduleById($id)

getScheduleKey($id)

getScheduleString($index,$from,$to)

superNightApiTest()
~~~

# キャストカスタムフィールドについて

~~~
    $cast_name = get_post_meta($id, 'cast_name', true); 
    $cast_age = get_post_meta($id,'cast_age', true);
    $cast_isnew = get_post_meta($id,'cast_isnew', true); // newの場合は"1"
    $cast_email = get_post_meta($id, 'cast_email', true);
    $cast_image = get_post_meta($id, 'main_image', true);
    $cast_schedule = get_post_meta($id, 'myschedule', true); // Array
~~~


## 作者

Twitter : https://twitter.com/keisukesiratori
ブログ : https://volkruss.com/