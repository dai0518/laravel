
<!DOCTYPE html>
<html lang="jg" dir="ltr">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'valoparty')</title>
    <!-- BootstrapのCSSを読み込む -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
</head>

<body class="bg-dark ">
    <!-- ナビゲーションバー -->
    <!-- ナビゲーションバー -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><img src="{{ asset('images/valoparty.png') }}"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">ホーム</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('post_list') }}">募集掲示板</a>
                </li>
            </ul>
            <ul class="navbar-nav" style="margin-left: auto;">
                <li class="nav-item">
                    @auth
                        <a class="nav-link" href="{{ route('mypage') }}">
                            <!-- ユーザーアイコンを追加 -->
                            <img src="{{ asset('uploads/avatars/' . Auth::user()->image) }}" alt="ユーザーアイコン" class="img-fluid rounded-circle"  style="width: 30px; height: 30px; margin-right: 5px;">
                            マイページ
                        </a>
                    @else
                        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div>
        @yield('content')
    </div>
    
    <!-- JavaScriptファイルを読み込む -->
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
