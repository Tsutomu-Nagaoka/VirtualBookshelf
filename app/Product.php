<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    // ページネーションのアイテム数
    protected $perPage = 6;

    // プライマリーキーの型
    protected $keyType = 'string';

    // リレーション
    // ユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // コメント
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    // 読みたい本
    public function favorite()
    {
        return $this->belongsToMany('App\User', 'favorite');
    }

    // 投稿者
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    // タイムライン
    public function getUserTimeLine(Int $user_id)
    {
        return $this->where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(6);
    }

    // 投稿した本の数
    public function getProductCount(Int $user_id)
    {
        return $this->where('user_id', $user_id)->count();
    }

    // IDの桁数
    const ID_LENGTH = 12;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(!Arr::get($this->attributes, 'id')) {
            $this->setId();
        }
    }

    // ランダムなIDを代入
    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }

    // ランダムなIDを作成
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $id = "";

        for($i = 0;$i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }

    // 本の投稿機能
    public function productStore(Int $user_id, Array $data)
    {
        // $file_name = $data['product_image']->store('public/product_image');

        $this->user_id = $user_id;
        $this->title = $data['title'];
        $this->author = $data['author'];
        $this->recommend = $data['recommend'];
        $this->text = $data['text'];
        $this->product_image = $data['product_image'];
        $this->save();

        return;
    }

    // S3のURL取得（独自属性）
    public function getUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['product_image']);
    }

    public function getFavoriteCountAttribute()
    {
        return $this->favorite->count();
    }

    public function getFavoritedByUserAttribute()
    {
        if(Auth::guest()) {
            return false;
        }

        // ログインユーザーのIDと合致するfavoriteが含まれているか
        return $this->favorite->contains(function($user) {
            return $user->id === Auth::user()->id;
        });
    }


    protected $appends = [ // モデルの項目、ユーザー定義のアクセサ（デフォルトではJSONに含まれない）
        'url', 'favorite_count', 'favorited_by_user',
    ];

    protected $visible = [ // JSONに含める属性
        'id', 'owner', 'url', 'comments', 'favorite_count', 'favorited_by_user',
    ];
}