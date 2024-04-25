<?php
namespace app\commands;

use yii\console\Controller;
use yii\helpers\Console;
use app\models\Category;
use app\models\Product;
use app\models\Image;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $this->seedCategories();
        $this->seedProducts();
        $this->seedImages();
        Console::output("Data seeding completed!");
    }

    protected function seedCategories()
    {
        Console::output("Seeding categories...");

        $categories = [
            ['title' => 'Electronics', 'parent_id' => null],
            ['title' => 'Laptops', 'parent_id' => 1],
            ['title' => 'Phones', 'parent_id' => 1],
            ['title' => 'Fashion', 'parent_id' => null],
            ['title' => 'Men', 'parent_id' => 4],
            ['title' => 'Women', 'parent_id' => 4],
        ];

        foreach ($categories as $category) {
            $cat = new Category();
            $cat->title = $category['title'];
            $cat->parent_id = $category['parent_id'];
            $cat->save();
        }
    }

    protected function seedProducts()
    {
        Console::output("Seeding products...");

        for ($i = 1; $i <= 100; $i++) {
            $product = new Product();
            $product->title = "Product $i";
            $product->description = "Description for product $i";
            $product->price = rand(100, 1000);
            $product->price_discount = rand(50, 99);
            $product->quantity = rand(1, 100);
            $product->category_id = rand(1, 6);
            $product->created_at = date('Y-m-d H:i:s');
            $product->updated_at = date('Y-m-d H:i:s');
            $product->save();
        }
    }

    protected function seedImages()
    {
        Console::output("Seeding images...");

        for ($i = 1; $i <= 100; $i++) {
            for ($j = 0; $j < rand(1, 5); $j++) {
                $image = new Image();
                $image->product_id = $i;
                $image->filename = "image{$i}_{$j}.jpg";
                $image->position = $j;
                $image->save();
            }
        }
    }
}
