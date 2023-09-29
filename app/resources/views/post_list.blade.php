@extends('layouts.app')
<style>
    .container {
        margin-bottom: 100px;
    }
    
</style>
@section('content')
<div class="container">
    <h1 class="text-center text-white">VALOPARTY募集掲示板</h1>

    <div class="d-flex justify-content-end mt-4 mb-4">
        <button class="btn btn-primary" onclick="location.href='{{ route('post_form') }}'">新規投稿</button>
    </div>

    <div class="row">
        <div class="col-md-2 category-selection">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('post_list') }}">
                        @csrf
                        <h5 class="card-title">カテゴリー選択</h5>
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="category_ids[]" value="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    <span class="badge badge-primary">{{ $category->name }}</span>
                                </label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary mt-3">フィルター</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-10">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $post->recruit_title }}</h5>
                            <div class="text-center mb-3">
                                @foreach($post->categories as $category)
                                    <span class="badge badge-primary">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <p class="card-text">
                                <strong>ゲームID:</strong> {{ $post->game_id }}<br>
                                <div class="text-center">
                                    {{ $post->comment }}<br>
                                </div>
                            </p>
                            <div class="text-center">
                                <!-- 参加ボタン -->
                                <a href="{{ $post->discord_url }}" target="_blank"><button class="btn btn-success">参加</button></a>
                            </div>
                        </div>
                        <!-- 投稿日時 -->
                        <div class="card-footer text-muted text-center" style="font-size: 0.7vw;">
                            投稿日時: {{ $post->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
