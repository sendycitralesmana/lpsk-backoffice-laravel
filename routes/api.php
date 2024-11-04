<?php

use App\Http\Controllers\Api\ApplicationCategoryController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\NewsCategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ProfileCategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PublicationCategoryController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\ServiceCategoryController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// grup application category
Route::group(['prefix' => 'application-category'], function () {
    Route::get('/', [ApplicationCategoryController::class, 'getAllApi']);
    
    // grup application category_id
    Route::group(['prefix' => '{application_category_id}'], function () {
        Route::get('/', [ApplicationCategoryController::class, 'getApi']);
    });
});

// grup application
Route::group(['prefix' => 'application'], function () {
    Route::get('/', [ApplicationController::class, 'getAllApi']);
    
    // grup application_id
    Route::group(['prefix' => '{application_id}'], function () {
        Route::get('/', [ApplicationController::class, 'getApi']);
    });
});

// grup service category
Route::group(['prefix' => 'service-category'], function () {
    Route::get('/', [ServiceCategoryController::class, 'getAllApi']);
    
    // grup service category_id
    Route::group(['prefix' => '{service_category_id}'], function () {
        Route::get('/', [ServiceCategoryController::class, 'getApi']);
    });
});

//  grup service
Route::group(['prefix' => 'service'], function () {
    Route::get('/', [ServiceController::class, 'getAllApi']);
    
    // grup service_id
    Route::group(['prefix' => '{service_id}'], function () {
        Route::get('/', [ServiceController::class, 'getApi']);
    });
});

// grup profile category
Route::group(['prefix' => 'profile-category'], function () {
    Route::get('/', [ProfileCategoryController::class, 'getAllApi']);
    
    // grup profile category_id
    Route::group(['prefix' => '{profile_category_id}'], function () {
        Route::get('/', [ProfileCategoryController::class, 'getApi']);
    });
});

// grup profile
Route::group(['prefix' => 'profile'], function () {
    Route::get('/', [ProfileController::class, 'getAllApi']);
    
    // grup profile_id
    Route::group(['prefix' => '{profile_id}'], function () {
        Route::get('/', [ProfileController::class, 'getApi']);
    });
});

// grup publication category
Route::group(['prefix' => 'publication-category'], function () {
    Route::get('/', [PublicationCategoryController::class, 'getAllApi']);
    
    // grup publication category_id
    Route::group(['prefix' => '{publication_category_id}'], function () {
        Route::get('/', [PublicationCategoryController::class, 'getApi']);
    });
});

// grup publication
Route::group(['prefix' => 'publication'], function () {
    Route::get('/', [PublicationController::class, 'getAllApi']);
    
    // grup publication_id
    Route::group(['prefix' => '{publication_id}'], function () {
        Route::get('/', [PublicationController::class, 'getApi']);
    });
});

// grup news category
Route::group(['prefix' => 'news-category'], function () {
    Route::get('/', [NewsCategoryController::class, 'getAllApi']);
    
    // grup news category_id
    Route::group(['prefix' => '{news_category_id}'], function () {
        Route::get('/', [NewsCategoryController::class, 'getApi']);
    });
});

// grup news
Route::group(['prefix' => 'news'], function () {
    Route::get('/', [NewsController::class, 'getAllApi']);
    
    // grup news_id
    Route::group(['prefix' => '{news_id}'], function () {
        Route::get('/', [NewsController::class, 'getApi']);
    });
});