use App\Http\Controllers\ShelterController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdoptionController;
use App\Http\Controllers\FavoriteController;

Route::apiResource('shelters', ShelterController::class);
Route::apiResource('pets', PetController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('adoptions', AdoptionController::class);
Route::apiResource('favorites', FavoriteController::class);
