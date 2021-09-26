<?php

namespace Database\Seeders;

use App\Models\Bread;
use Illuminate\Database\Seeder;

class BreadSeeder extends Seeder
{

    public function run()
    {
        $breads = [
            [
                "name" => "banana lekker",
                "img" => "breads/banana_lekker.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ],
            [
                "name" => "chocolate almond croissant",
                "img" => "breads/chocolate_almond_croissant.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ],
            [
                "name" => "chocolate puff",
                "img" => "breads/chocolate_puff.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ],
            [
                "name" => "pizza bread",
                "img" => "breads/pizza_bread.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ],
            [
                "name" => "salted egg bread",
                "img" => "breads/salted_egg_bread.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ],
            [
                "name" => "sasame artisan",
                "img" => "breads/sasame_artisan.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ],
            [
                "name" => "spicy floss bread",
                "img" => "breads/spicy_floss_bread.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ],
            [
                "name" => "whole wheat sourdough",
                "img" => "breads/whole_wheat_sourdough.jpg",
                "rating" => $this->getRandomStar(),
                "price" => $this->getRandomPrice(),
                "views" => $this->getRandomView()
            ]
        ];

        foreach ($breads as $bread){
            Bread::create($bread);
        }

    }

    function getRandomView()
    {
        return rand(1000, 5000);
    }

    function getRandomPrice()
    {
        return (double)rand(100, 300) * 1000;
    }

    function getRandomStar()
    {
        return (double)rand(30, 50) / 10;
    }
}
