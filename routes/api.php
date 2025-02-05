<?php

use App\Http\Controllers\Api\ApplicationCategoryController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\HighlightCategoryController;
use App\Http\Controllers\Api\HighlightController;
use App\Http\Controllers\Api\InformationCategoryController;
use App\Http\Controllers\Api\InformationController;
use App\Http\Controllers\Api\NewsCategoryController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ProfileCategoryController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PublicationCategoryController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\RoadMapController;
use App\Http\Controllers\Api\ServiceCategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SettingCategoryController;
use App\Http\Controllers\Api\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// grup backoffice
// Route::group(['prefix' => 'backoffice'], function () {

    // grup application category
    Route::group(['prefix' => 'application_category'], function () {
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
    Route::group(['prefix' => 'service_category'], function () {
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
    Route::group(['prefix' => 'profile_category'], function () {
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
    Route::group(['prefix' => 'publication_category'], function () {
        Route::get('/', [PublicationCategoryController::class, 'getAllApi']);
        Route::get('/publication', [PublicationCategoryController::class, 'categoryPublicationApi']);
        
        // grup publication category_id
        Route::group(['prefix' => '{publication_category_id}'], function () {
            Route::get('/', [PublicationCategoryController::class, 'getApi']);
        });
    });

    // grup publication
    Route::group(['prefix' => 'publication'], function () {
        Route::get('/', [PublicationController::class, 'getAllApi']);
        Route::get('/bukuTerbaru', [PublicationController::class, 'getBukuTerbaruApi']);
        Route::get('/laporanTerbaru', [PublicationController::class, 'getLaporanTerbaruApi']);
        Route::get('/jurnalTerbaru', [PublicationController::class, 'getJurnalTerbaruApi']);
        Route::get('/buletinTerbaru', [PublicationController::class, 'getBuletinTerbaruApi']);
        
        // grup publication_id
        Route::group(['prefix' => '{publication_id}'], function () {
            Route::get('/', [PublicationController::class, 'getApi']);
        });
    });

    // grup news category
    Route::group(['prefix' => 'news_category'], function () {
        Route::get('/', [NewsCategoryController::class, 'getAllApi']);
        Route::get('/news', [NewsCategoryController::class, 'categoryNewsApi']);
        
        // grup news category_id
        Route::group(['prefix' => '{news_category_id}'], function () {
            Route::get('/', [NewsCategoryController::class, 'getApi']);
        });
    });

    // grup news
    Route::group(['prefix' => 'news'], function () {
        Route::get('/', [NewsController::class, 'getAllApi']);
        Route::get('/latestArtikel', [NewsController::class, 'getLatestArtikelApi']);
        Route::get('/latestInformasi', [NewsController::class, 'getLatestInformasiApi']);
        
        // grup news_id
        Route::group(['prefix' => '{news_id}'], function () {
            Route::get('/', [NewsController::class, 'getApi']);
        });
    });

    // grup information category
    Route::group(['prefix' => 'information_category'], function () {
        Route::get('/', [InformationCategoryController::class, 'getAllApi']);
        
        // grup information category_id
        Route::group(['prefix' => '{information_category_id}'], function () {
            Route::get('/', [InformationCategoryController::class, 'getApi']);
        });
    });

    // grup information
    Route::group(['prefix' => 'information'], function () {
        Route::get('/', [InformationController::class, 'getAllApi']);
        Route::get('/latest', [InformationController::class, 'getLatestApi']);
        
        // grup information_id
        Route::group(['prefix' => '{information_id}'], function () {
            Route::get('/', [InformationController::class, 'getApi']);
        });
    });

    // grup highlight category
    Route::group(['prefix' => 'highlight_category'], function () {
        Route::get('/', [HighlightCategoryController::class, 'getAllApi']);
        
        // grup highlight category_id
        Route::group(['prefix' => '{highlight_category_id}'], function () {
            Route::get('/', [HighlightCategoryController::class, 'getApi']);
        });
    });

    // grup setting category
    Route::group(['prefix' => 'setting_category'], function () {
        Route::get('/', [SettingCategoryController::class, 'getAllApi']);
        
        // grup setting category_id
        Route::group(['prefix' => '{setting_category_id}'], function () {
            Route::get('/', [SettingCategoryController::class, 'getApi']);
        });
    });

    // grup setting
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', [SettingController::class, 'getAllApi']);
        
        // grup setting_id
        Route::group(['prefix' => '{setting_id}'], function () {
            Route::get('/', [SettingController::class, 'getApi']);
        });
    });

    // grup highlight
    Route::group(['prefix' => 'highlight'], function () {
        Route::get('/', [HighlightController::class, 'getAllApi']);
        
        // grup highlight_id
        Route::group(['prefix' => '{highlight_id}'], function () {
            Route::get('/', [HighlightController::class, 'getApi']);
        });
    });

    // grup roadmap
    Route::group(['prefix' => 'roadmap'], function () {
        Route::get('/', [RoadMapController::class, 'getAllApi']);
        
        // grup roadmap_id
        Route::group(['prefix' => '{roadmap_id}'], function () {
            Route::get('/', [RoadMapController::class, 'getApi']);
        });
    });

    // grup report
    Route::group(['prefix' => 'report'], function () {
        Route::get('/', [ReportController::class, 'getAllApi']);
        Route::post('/create', [ReportController::class, 'storeApi']);
        
        // grup report_id
        Route::group(['prefix' => '{report_id}'], function () {
            Route::get('/', [ReportController::class, 'getApi']);
        });
    });

// });