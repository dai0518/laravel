@extends('layouts.app')

@section('content')
<div class="container">
    <div class="position-relative">
        <!-- サイトロゴ -->
        <img src="images/header.png" alt="home image" style="width: 100%; height: 600px;">

        <div class="search-form position-absolute top-50 start-50 translate-middle" style="transform: translate(55%, -300%);">
            <form action="" method="get" class="d-flex align-items-center">
                @csrf
                <input type="text" name="player_username" class="form-control me-2" placeholder="プレイヤー名 + #tag を入力" style="width: 450px;">
                <button type="submit" class="btn btn-primary">検索</button>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Bootstrap 5のJavaScriptとPopper.jsを読み込む -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.1/umd/popper.min.js"></script>
</body>
