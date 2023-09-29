@extends('layouts.app')

@section('content')
<div class="container text-dark"> <!-- text-dark に変更 -->
    <h1 class="text-center">新規投稿フォーム</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('post.store') }}">
                @csrf
                <div class="form-group">
                    @if($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <label for="recruit_title">投稿タイトル:</label>
                    <input type="text" id="recruit_title" name="recruit_title" class="form-control">
                </div>

                <div class="form-group">
                    <label for="categories">カテゴリーを選択:</label>
                    @foreach($categories as $category)
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input category-checkbox" name="category_ids[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                            <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- JavaScriptで選択されたカテゴリーを保持する隠しフィールド -->
                <input type="hidden" id="selected-categories" name="category_ids" value="">

                <div class="form-group">
                    <label for="game_id">ゲーム内ID:</label>
                    <input type="text" id="game_id" name="game_id" class="form-control">
                </div>

                <div class="form-group">
                    <label for="discord_url">Discord招待URL:</label>
                    <input type="text" id="discord_url" name="discord_url" class="form-control">
                </div>

                <div class="form-group">
                    <label for="comment">投稿本文:</label>
                    <textarea id="comment" name="comment" class="form-control"></textarea>
                </div>

                <button type="submit" class="btn btn-primary ">投稿する</button>
            </form>
        </div>
    </div>

    <script>
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        const selectedCategoriesInput = document.getElementById('selected-categories');

        // チェックボックスが変更されたときに呼び出す関数
        function updateSelectedCategories() {
            const selectedCategoryIds = Array.from(categoryCheckboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => parseInt(checkbox.value)); // 値を整数に変換

            // カテゴリーIDの配列を hidden フィールドに設定
            selectedCategoriesInput.value = JSON.stringify(selectedCategoryIds);
        }

        // チェックボックスの変更イベントにリスナーを追加
        categoryCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedCategories);
        });

    </script>
</div>
@endsection
