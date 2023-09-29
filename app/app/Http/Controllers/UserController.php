<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function changeAvatar(Request $request)
    {
        // リクエストを検証
        $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 必要に応じてバリデーションルールを調整
        ]);

        // リクエストにアバターが含まれているか確認
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');

            // ユニークなファイル名を生成（例: user_id_timestamp.extension）
            $fileName = Auth::user()->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();

            // アップロード先のパスを指定
            $uploadPath = public_path('uploads/avatars');

            // アップロードされたファイルを指定のパスに移動
            $avatar->move($uploadPath, $fileName);

            // ユーザーモデルを新しいファイル名で更新
            Auth::user()->update(['image' => $fileName]);

            // プロフィール画像の保存と同じように、updateProfileImage メソッドの要素を追加
            auth()->user()->update([
                'image' => $fileName,
            ]);

            // ユーザーのプロフィールページにリダイレクトし、成功メッセージを表示
            return redirect('/mypage')->with('success', 'アバターが更新されました。');
        }

        // アバターが提供されなかった場合の処理
        // マイページにリダイレクト
        return redirect('/mypage');
    }
    public function changeUsername(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:20',
        ]);

        // ユーザー名を更新
        Auth::user()->update(['name' => $request->input('username')]);

        // マイページにリダイレクト
        return redirect('/mypage')->with('success', 'ユーザー名が更新されました。');
    }
}
