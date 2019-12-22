@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">プロフィール編集</div>
                    <div class="card-body">
                        <form action="{{ url('users/' .$user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row align-items-center">
                                <label for="profile_image" class="col-md-4 col-form-label text-md-right">プロフィール画像</label>
                                <div class="col-md-6 d-flex align-items-center">
                                    <img src="{{ asset('https://s3-ap-northeast-1.amazonaws.com/virtualbookshelf/' .$user->profile_image) }}" class="mr-2 rounded-circle" width="50" height="50" alt="profile_image">
                                    <input type="file" name="profile_image" class="@error('profile_image') is-invalid @enderror" autocomplete="profile_image">
                                    @error('profile_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>                             

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">ユーザーネーム</label>
                                <div class="col-md-6">
                                    <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">メールアドレス</label>

                                <div class="col-md-6">
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}"  required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4 mt-3">
                                    <button class="btn btn-primary btn-lg" type="submit">更新する</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <form action="{{ url('users/' .$user->id) }}" method="POST" class="mt-5 d-flex">
                    @csrf
                    @method('DELETE')
                    <div class="form-group row mb-0 mx-auto">
                            <button class="btn btn-danger" type="submit" onclick="return confirm('アカウントを削除してもよろしいですか？');">アカウントを削除する</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection