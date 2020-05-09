<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\ContentCategory;
use App\ContentTag;
use App\ContentPage;

class ContentCategoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = ContentCategory::find(1);

        $page = ContentPage::find(1);

        $page->categories()->save($category);

        $category = ContentCategory::find(2);

        $page = ContentPage::find(2);

        $page->categories()->save($category);

        $category = ContentCategory::find(3);

        $page = ContentPage::find(3);

        $page->categories()->save($category);

        $category = ContentCategory::find(4);

        $page = ContentPage::find(4);

        $page->categories()->save($category);




        $tag = ContentTag::find(1);

        $page = ContentPage::find(1);

        $page->tags()->save($tag);

        $tag = ContentTag::find(2);

        $page = ContentPage::find(2);

        $page->tags()->save($tag);

        $tag = ContentTag::find(3);

        $page = ContentPage::find(3);

        $page->tags()->save($tag);

        $tag = ContentTag::find(4);

        $page = ContentPage::find(4);

        $page->tags()->save($tag);

        //$page->save();
        
    }
}
