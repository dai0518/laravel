@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    マイページ
                    <a href="{{ route('logout') }}" class="btn btn-primary float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
                <div class="card-body">
                    <div class="user-profile d-flex">
                        <div class="user-avatar" id="user-avatar">
                            <img src="{{ asset('uploads/avatars/' . Auth::user()->image) }}" alt="ユーザーアイコン" class="img-fluid rounded-circle" id="user-icon">
                        </div>
                        <div class="user-form">
                            <!-- 画像変更フォーム -->
                            <form id="avatar-form" action="{{ route('changeAvatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="avatar">
                                <button type="submit">アップロード</button>
                            </form>
                        </div>
                    </div>
                    <!-- ユーザー名表示部分 -->
                    <div class="user-name mt-3 d-flex align-items-center">
                        <h2 id="username">{{ Auth::user()->name }}</h2>
                        <button id="change-username-btn" class="btn btn-sm btn-link ml-2">変更</button>
                    </div>
                    <!-- ユーザー名変更フォーム -->
                    <form id="username-form" action="{{ route('changeUsername') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="text" name="username" id="username-input">
                        <button type="submit" class="btn btn-sm btn-link ml-2" id="submit-username">変更</button>
                    </form>

                    @if(count($posts) > 0)
                        <h3 class="mt-5">投稿一覧</h3>
                        <div class="row" id="post-list">
                            <!-- 3つのカードを表示 -->
                            @foreach($posts->take(3) as $post)
                                <div class="col-md-4 mb-2" id="post{{ $post->id }}">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $post->recruit_title }}</h5>
                                            <div class="text-center mb-3">
                                                @if($post->categories)
                                                    @foreach($post->categories as $category)
                                                        <span class="badge badge-primary">{{ $category->name }}</span>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <p class="card-text">
                                                <strong>ゲームID:</strong> {{ $post->game_id }}<br>
                                            </p>
                                            <p class="card-text text-center">
                                                {{ $post->comment }}<br>
                                            </p>
                                        </div>
                                        <!-- 投稿日時 -->
                                        <div class="card-footer text-muted text-center small">
                                            投稿日時: {{ $post->created_at->format('Y-m-d H:i') }}
                                            <button class="btn btn-danger btn-sm float-right" onclick="deletePost({{ $post->id }})">削除</button>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(count($posts) > 3)
                            <!-- もっとみるリンク -->
                            <div class="text-center mt-3">
                                <a href="#" id="load-more" class="btn btn-primary">もっとみる</a>
                            </div>
                        @endif
                    @else
                        <p class="mt-4 text-center">投稿はありません。</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        var offset = 3;

        // もっとみるリンクがクリックされたときの処理
        $('#load-more').click(function(e) {
            e.preventDefault();

            $.ajax({
                url: '/mypage/load-more', 
                type: 'GET',
                data: { offset: offset },
                success: function(data) {
                    if (data.posts.length > 0) {
                        data.posts.forEach(function(post) {
                            var cardHtml = `
                                <div class="col-md-4 mb-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">${post.recruit_title}</h5>
                                            <div class="text-center mb-3">
                                                <!-- カテゴリーの表示 -->
                                                ${post.categories ? post.categories.map(category => `<span class="badge badge-primary mr-1">${category.name}</span>`).join('') : ''}
                                            </div>
                                            <p class="card-text">
                                                <strong>ゲームID:</strong> ${post.game_id}<br>
                                            </p>
                                            <p class="card-text text-center">
                                                ${post.comment}<br>
                                            </p>
                                        </div>
                                        <!-- 投稿日時 -->
                                        <div class="card-footer text-muted text-center small">
                                            投稿日時: ${post.created_at}
                                            <button class="btn btn-danger btn-sm float-right" onclick="deletePost(${post.id})">削除</button>
                                        </div>
                                    </div>
                                </div>
                            `;

                            $('#post-list').append(cardHtml);
                        });

                        offset += data.posts.length;
                    } else {
                        // もっと表示する投稿がないとき、もっとみるリンクを非表示にする
                        $('#load-more').hide();
                    }
                },
            });
        });

        // ユーザーアバター画像をクリックしたときの処理
        $('#user-avatar').click(function() {
            $('#avatar-form').toggle();
        });

        // ユーザー名変更ボタンがクリックされたときの処理
        $('#change-username-btn').click(function() {
            $('#username').hide();
            $('#username-input').val($('#username').text());
            $('#username-form').show();
        });

        // ユーザー名表示部分をクリックしたときの処理
        $('#username').click(function() {
            $('#username-form').toggle();
        });
    });

    function deletePost(postId) {
        if (confirm("本当に削除しますか？")) {
            var csrfToken = '{{ csrf_token() }}';

            // 削除のためのAjaxリクエストを送信
            $.ajax({
                url: '{{ route("deletePost", ["id" => "__postId__"]) }}'.replace('__postId__', postId),
                type: 'POST',
                data: {
                    _token: csrfToken,
                },
                success: function(response) {
                    if (response.success) {
                        // 論理削除に成功したら投稿を非表示にする
                        $('#post' + postId).hide();
                    } else {
                        alert('削除に失敗しました。');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('エラーが発生しました:', error);
                    alert('エラーが発生しました。');
                }
            });
        }
    }

</script>

<style>
    .container {
        margin-bottom: 120px;
    }

    #avatar-form {
        display: none; 
    }

    #user-icon {
        width: 150px;
        height: 150px;
    }

    .user-profile {
        align-items: flex-start; 
    }

    .user-avatar {
        margin-right: 20px;
    }
</style>
@endsection
