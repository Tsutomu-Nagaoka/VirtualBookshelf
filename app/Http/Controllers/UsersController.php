<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\Follow;

class UsersController extends Controller
{
    // ユーザー一覧
    public function index(User $user)
    {
        $all_users = $user->getAllUsers(auth()->user()->id);

        return view('users.index', [
            'all_users' => $all_users
        ]);
    }

    // ユーザー詳細
    public function show(User $user, Product $product, Follow $follower)
    {
        $login_user = auth()->user();
        $is_following = $login_user->isFollowing($user->id);
        $is_followed = $login_user->isFollowed($user->id);
        $timelines = $product->getUserTimeLine($user->id);
        $product_count = $product->getProductCount($user->id);
        $follow_count = $follower->getFollowerCount($user->id);
        $follower_count = $follower->getFollowerCount($user->id);

        return view('users.show', [
            'user' => $user,
            'is_following' => $is_following,
            'is_followed' => $is_followed,
            'timelines' => $timelines,
            'product_count' => $product_count,
            'follow_count' => $follow_count,
            'follower_count' => $follower_count,
        ]);
    }

    // public function destroy(User $user)
    // {
    //     $user = auth()->user();
    //     $user->destroyUser($user->id);

    //     return response($user, 200);    
    // }

    // フォロー
    public function follow(User $user)
    {
        $follower = auth()->user();
        // フォローしているか
        $is_following = $follower->isFollowing($user->id);
        if(!$is_following) {
            // フォローしていなければフォローする
            $follower->follow($user->id);
            return back();
        }
    }

    // フォロー解除
    public function unFollow(User $user)
    {
        $follower = auth()->user();
        // フォローしているか
        $is_following = $follower->isFollowing($user->id);
        if($is_following) {
            // フォローしていればフォローを解除する
            $follower->unFollow($user->id);
            return back();
        }
    }
}