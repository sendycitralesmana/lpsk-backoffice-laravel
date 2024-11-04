<?php

use App\Http\Controllers\ApplicationCategoryController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationCategoryController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// grup auth
Route::get('/verify/{token}', [AuthController::class, 'verify']);

// middleware guest
Route::group(['middleware' => 'guest'], function () {
    
    // grup auth
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginAction']);
    Route::get('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('forgot-password', [AuthController::class, 'forgotPasswordAction']);
    Route::get('reset-password/{token}', [AuthController::class, 'resetPassword']);
    Route::put('reset-password/{token}/action', [AuthController::class, 'resetPasswordAction']);
    
});

// middleware auth
Route::group(['middleware' => 'auth'], function () {

    // grup auth
    Route::get('/logout', [AuthController::class, 'logout']);

    // grup backoffice
    Route::group(['prefix' => 'backoffice'], function () {

        // grup dashboard
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('/', [DashboardController::class, 'index']);
        });

        // grup application
        Route::group(['prefix' => 'application'], function () {
            Route::get('/', [ApplicationController::class, 'index']);
            Route::post('/create', [ApplicationController::class, 'create']);

            // grup application_id
            Route::group(['prefix' => '{application_id}'], function () {
                Route::put('/update', [ApplicationController::class, 'update']);
                Route::get('/delete', [ApplicationController::class, 'delete']);
            });

        });

        // grup service
        Route::group(['prefix' => 'service'], function () {
            Route::get('/', [ServiceController::class, 'index']);
            Route::post('/create', [ServiceController::class, 'create']);

            // grup service_id
            Route::group(['prefix' => '{service_id}'], function () {
                Route::put('/update', [ServiceController::class, 'update']);
                Route::get('/delete', [ServiceController::class, 'delete']);
                Route::get('/preview', [ServiceController::class, 'preview']);
            });

        });

        // grup profile
        Route::group(['prefix' => 'profile'], function () {
            Route::get('/', [ProfileController::class, 'index']);
            Route::post('/create', [ProfileController::class, 'create']);

            // grup profile_id
            Route::group(['prefix' => '{profile_id}'], function () {
                Route::put('/update', [ProfileController::class, 'update']);
                Route::get('/delete', [ProfileController::class, 'delete']);
                Route::get('/preview', [ProfileController::class, 'preview']);
            });

        });

        // grup publication
        Route::group(['prefix' => 'publication'], function () {
            Route::get('/', [PublicationController::class, 'index']);
            Route::post('/create', [PublicationController::class, 'create']);

            // grup publication_id
            Route::group(['prefix' => '{publication_id}'], function () {
                Route::put('/update', [PublicationController::class, 'update']);
                Route::get('/delete', [PublicationController::class, 'delete']);
                Route::get('/preview', [PublicationController::class, 'preview']);
            });

        });

        // grup news
        Route::group(['prefix' => 'news'], function () {
            Route::get('/', [NewsController::class, 'index']);
            Route::post('/create', [NewsController::class, 'create']);

            // grup news_id
            Route::group(['prefix' => '{news_id}'], function () {
                Route::get('/detail', [NewsController::class, 'detail']);
                Route::put('/update', [NewsController::class, 'update']);
                Route::get('/delete', [NewsController::class, 'delete']);
                Route::get('/preview', [NewsController::class, 'preview']);

                // grup news_image
                Route::group(['prefix' => 'image'], function () {
                    Route::post('/create', [NewsController::class, 'createImage']);
                    Route::get('/delete-all', [NewsController::class, 'deleteAllImage']);
                    
                    // grup news_image_id
                    Route::group(['prefix' => '{news_image_id}'], function () {
                        Route::get('/delete', [NewsController::class, 'deleteImage']);
                        Route::put('/update', [NewsController::class, 'updateImage']);
                    });
                });

                // grup news_video
                Route::group(['prefix' => 'video'], function () {
                    Route::post('/create', [NewsController::class, 'createVideo']);
                    Route::get('/delete-all', [NewsController::class, 'deleteAllVideo']);

                    // grup news_video_id
                    Route::group(['prefix' => '{news_video_id}'], function () {
                        Route::get('/delete', [NewsController::class, 'deleteVideo']);
                        Route::put('/update', [NewsController::class, 'updateVideo']);
                    });
                });

                // grup news_document
                Route::group(['prefix' => 'document'], function () {
                    Route::post('/create', [NewsController::class, 'createDocument']);
                    Route::get('/delete-all', [NewsController::class, 'deleteAllDocument']);

                    // grup news_document_id
                    Route::group(['prefix' => '{news_document_id}'], function () {
                        Route::get('/delete', [NewsController::class, 'deleteDocument']);
                        Route::put('/update', [NewsController::class, 'updateDocument']);
                    });
                });

            });

        });

        // grup user data
        Route::group(['prefix' => 'user-data'], function () {
            
            // grup role
            Route::group(['prefix' => 'role'], function () {
                Route::get('/', [RoleController::class, 'index']);
                Route::post('/create', [RoleController::class, 'create']);

                // grup role_id
                Route::group(['prefix' => '{role_id}'], function () {
                    Route::put('/update', [RoleController::class, 'update']);
                    Route::get('/delete', [RoleController::class, 'delete']);
                });

            });

            // grup user
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', [UserController::class, 'index']);
                Route::get('/create', [UserController::class, 'create']);
                Route::post('/create', [UserController::class, 'createAction']);
    
                // grup user_id
                Route::group(['prefix' => '{user_id}'], function () {
                    Route::put('/update', [UserController::class, 'update']);
                    Route::get('/profile', [UserController::class, 'profile']);
                    Route::get('/edit-data', [UserController::class, 'editData']);
                    Route::get('/edit-password', [UserController::class, 'editPassword']);
                    Route::post('/update-data', [UserController::class, 'updateData']);
                    Route::post('/update-password', [UserController::class, 'updatePassword']);
                    Route::get('/delete', [UserController::class, 'delete']);
                });
    
            });

        });

        // grup category data
        Route::group(['prefix' => 'category-data'], function () {
            
            // grup application
            Route::group(['prefix' => 'application'], function () {
                Route::get('/', [ApplicationCategoryController::class, 'index']);
                Route::post('/create', [ApplicationCategoryController::class, 'create']);

                // grup application_id
                Route::group(['prefix' => '{application_id}'], function () {
                    Route::put('/update', [ApplicationCategoryController::class, 'update']);
                    Route::get('/delete', [ApplicationCategoryController::class, 'delete']);
                });

            });

            // grup service
            Route::group(['prefix' => 'service'], function () {
                Route::get('/', [ServiceCategoryController::class, 'index']);
                Route::post('/create', [ServiceCategoryController::class, 'create']);

                // grup service_id
                Route::group(['prefix' => '{service_id}'], function () {
                    Route::put('/update', [ServiceCategoryController::class, 'update']);
                    Route::get('/delete', [ServiceCategoryController::class, 'delete']);
                });

            });

            // grup profile
            Route::group(['prefix' => 'profile'], function () {
                Route::get('/', [ProfileCategoryController::class, 'index']);
                Route::post('/create', [ProfileCategoryController::class, 'create']);

                // grup profile_id
                Route::group(['prefix' => '{profile_id}'], function () {
                    Route::put('/update', [ProfileCategoryController::class, 'update']);
                    Route::get('/delete', [ProfileCategoryController::class, 'delete']);
                });

            });
            
            // grup publication
            Route::group(['prefix' => 'publication'], function () {
                Route::get('/', [PublicationCategoryController::class, 'index']);
                Route::post('/create', [PublicationCategoryController::class, 'create']);

                // grup publication_id
                Route::group(['prefix' => '{publication_id}'], function () {
                    Route::put('/update', [PublicationCategoryController::class, 'update']);
                    Route::get('/delete', [PublicationCategoryController::class, 'delete']);
                });

            });
            
            // grup news
            Route::group(['prefix' => 'news'], function () {
                Route::get('/', [NewsCategoryController::class, 'index']);
                Route::post('/create', [NewsCategoryController::class, 'create']);

                // grup news_id
                Route::group(['prefix' => '{news_id}'], function () {
                    Route::put('/update', [NewsCategoryController::class, 'update']);
                    Route::get('/delete', [NewsCategoryController::class, 'delete']);
                });

            });

        });

    });

});