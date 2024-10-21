<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoriteSeeder extends Seeder
{
    public function run()
    {
        // Llamamos al método del modelo para generar favoritos
        Favorite::generateFavoritesForUser(1);
    }
}
