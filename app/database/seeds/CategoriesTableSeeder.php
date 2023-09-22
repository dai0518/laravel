<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Category;
class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // カテゴリーデータを挿入する
        DB::table('categories')->insert([
            ['name' => 'エンジョイ勢'],
            ['name' => 'ガチ勢'],
            ['name' => 'アイアン'],
            ['name' => 'シルバー'],
            ['name' => 'ゴールド'],
            ['name' => 'プラチナ'],
            ['name' => 'ダイヤモンド'],
            ['name' => 'アセンダント'],
            ['name' => 'イモータル'],
            ['name' => 'レディアント'],
        ]);
    }
}
