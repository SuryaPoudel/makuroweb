<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['page' => 'API\PageController']);
Route::apiResources(['categories' => 'API\CategoryController']);
Route::apiResources(['post' => 'API\PostController']);
Route::apiResources(['draft' => 'API\DraftController']);
Route::apiResources(['header' => 'API\HeaderController']);
Route::apiResources(['gallery' => 'API\GalleryController']);
Route::apiResources(['slider' => 'API\SliderController']);
Route::apiResources(['footer' => 'API\FooterController']);
Route::apiResources(['popup' => 'API\PopupController']);
Route::apiResources(['topfooter' => 'API\BottomFooterController']);
Route::apiResources(['elements' => 'API\ElementsController']);
Route::apiResources(['controlpanelrole' => 'API\ControlPanelRoleController']);

Route::get('searchuser', 'API\ControlPanelRoleController@SearchUser');
Route::get('parent', 'API\PageController@GetPageDistinct');
Route::get('category', 'API\CategoryController@GetCategoryDistinct');
Route::get('searchpost', 'API\PostController@SearchPosts');
Route::get('searchgallery', 'API\GalleryController@SearchGallery');
Route::get('searchslider', 'API\SliderController@SearchSlider');
Route::post('browse', 'API\PostController@uploadfile');
Route::get('album', 'API\GalleryController@selectAlbum');
Route::get('slidertype', 'API\SliderController@selectSlidertype');
Route::post('changelogo', 'API\HeaderController@uploadlogo');
Route::post('changefooterlogo', 'API\FooterController@uploadlogo');
