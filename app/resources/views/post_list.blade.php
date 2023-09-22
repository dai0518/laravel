@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center text-white">VALOPARTY募集掲示板</h1>

    <div class="d-flex justify-content-end mt-4 mb-4">
        <button class="btn btn-primary" onclick="location.href='{{ route('post_form') }}'">新規投稿</button>
    </div>

    <!-- カテゴリーボタン一覧 -->
    <!-- カテゴリー検索機能　未実装 -->
    <div class="d-flex flex-wrap mb-2">
        @foreach($categories as $category)
            <button class="btn btn-secondary ml-2 category-button" data-category="{{ $category->name }}" onclick="selectCategory('{{ $category->name }}')">{{ $category->name }}</button>
        @endforeach
        </div>

    <div id="search-form" style="display: none;">
        <form method="POST" action="{{ route('post_list') }}">
            @csrf
            <input type="hidden" id="search-category" name="search">
        </form>
    </div>

    <div class="row">   
        <!-- ここは後日レイアウト調整 -->
        @foreach($posts as $post)
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $post->recruit_title }}</h5>
                        <p class="card-text">
                            <strong>カテゴリー:</strong> 
                            @foreach($post->categories as $category)
                                {{ $category->name }}
                            @endforeach
                            <br>
                            <strong>ゲームID:</strong> {{ $post->game_id }}<br>
                            <strong>コメント:</strong> {{ $post->comment }}<br>
                            <div class="text-center">
                            <!-- <strong>Discord URL:</strong>--> 
                            <a href="{{ $post->discord_url }}" target="_blank"><button class="btn btn-success">参加</button></a><br> 
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
</div>


<script>
    // カテゴリーボタンがクリックされたときの処理
    const categoryButtons = document.querySelectorAll('.category-button');
    
    categoryButtons.forEach(button => {
        button.addEventListener('click', function() {
            selectCategory(button.dataset.category);
        });
    });

    function selectCategory(category) {
    document.getElementById('search-category').value = category;
    document.querySelector('form').submit();
}
</script>

@endsection
