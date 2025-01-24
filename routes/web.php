<?php

use App\Http\Controllers\ApplicationCategoryController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HighlightCategoryController;
use App\Http\Controllers\HighlightController;
use App\Http\Controllers\InformationCategoryController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicationCategoryController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoadMapController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingCategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/backoffice/login');
});

// grup auth
Route::get('/backoffice/verify/{token}', [AuthController::class, 'verify']);

// middleware guest
Route::group(['middleware' => 'guest'], function () {

    // grup backoffice
    Route::group(['prefix' => 'backoffice'], function () {
    
        // grup auth
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'loginAction']);
        Route::get('/forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPasswordAction']);
        Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword']);
        Route::put('/reset-password/{token}/action', [AuthController::class, 'resetPasswordAction']);

    });
    
});

// middleware auth
Route::group(['middleware' => 'auth'], function () {

    // grup auth
    Route::get('/backoffice/logout', [AuthController::class, 'logout']);

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
                Route::get('/detail', [ProfileController::class, 'detail']);
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
                Route::get('/detail', [PublicationController::class, 'detail']);
            });

        });

        // grup highlight
        Route::group(['prefix' => 'highlight'], function () {
            Route::get('/', [HighlightController::class, 'index']);
            Route::post('/create', [HighlightController::class, 'create']);

            // grup highlight_id
            Route::group(['prefix' => '{highlight_id}'], function () {
                Route::put('/update', [HighlightController::class, 'update']);
                Route::get('/delete', [HighlightController::class, 'delete']);
            });

        });

        // grup report
        Route::group(['prefix' => 'report'], function () {
            Route::get('/', [ReportController::class, 'index']);
            Route::post('/create', [ReportController::class, 'create']);

            // grup report_id
            Route::group(['prefix' => '{report_id}'], function () {
                Route::put('/update', [ReportController::class, 'update']);
                Route::get('/delete', [ReportController::class, 'delete']);
            });
        });

        // grup news
        Route::group(['prefix' => 'news'], function () {
            Route::get('/', [NewsController::class, 'index']);
            Route::get('/add', [NewsController::class, 'add']);
            Route::post('/create', [NewsController::class, 'create']);

            // grup news_id
            Route::group(['prefix' => '{news_id}'], function () {
                Route::get('/detail', [NewsController::class, 'detail']);
                Route::get('/edit', [NewsController::class, 'edit']);
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
                        Route::get('/preview', [NewsController::class, 'previewDocument']);
                    });
                });

            });

        });

        // grup setting
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SettingController::class, 'index']);
            Route::get('/add', [SettingController::class, 'add']);
            Route::post('/create', [SettingController::class, 'create']);

            // grup setting_id
            Route::group(['prefix' => '{setting_id}'], function () {
                Route::get('/detail', [SettingController::class, 'detail']);
                Route::get('/edit', [SettingController::class, 'edit']);
                Route::put('/update', [SettingController::class, 'update']);
                Route::get('/delete', [SettingController::class, 'delete']);
                Route::get('/preview', [SettingController::class, 'preview']);

                // grup setting_image
                Route::group(['prefix' => 'image'], function () {
                    Route::post('/create', [SettingController::class, 'createImage']);
                    Route::get('/delete-all', [SettingController::class, 'deleteAllImage']);
                    
                    // grup setting_image_id
                    Route::group(['prefix' => '{setting_image_id}'], function () {
                        Route::get('/delete', [SettingController::class, 'deleteImage']);
                        Route::put('/update', [SettingController::class, 'updateImage']);
                    });
                });

                // grup setting_video
                Route::group(['prefix' => 'video'], function () {
                    Route::post('/create', [SettingController::class, 'createVideo']);
                    Route::get('/delete-all', [SettingController::class, 'deleteAllVideo']);

                    // grup setting_video_id
                    Route::group(['prefix' => '{setting_video_id}'], function () {
                        Route::get('/delete', [SettingController::class, 'deleteVideo']);
                        Route::put('/update', [SettingController::class, 'updateVideo']);
                    });
                });

                // grup setting_document
                Route::group(['prefix' => 'document'], function () {
                    Route::post('/create', [SettingController::class, 'createDocument']);
                    Route::get('/delete-all', [SettingController::class, 'deleteAllDocument']);

                    // grup setting_document_id
                    Route::group(['prefix' => '{setting_document_id}'], function () {
                        Route::get('/delete', [SettingController::class, 'deleteDocument']);
                        Route::put('/update', [SettingController::class, 'updateDocument']);
                        Route::get('/preview', [SettingController::class, 'previewDocument']);
                    });
                });

            });

        });

        // grup information
        Route::group(['prefix' => 'information'], function () {
            Route::get('/', [InformationController::class, 'index']);
            Route::get('/add', [InformationController::class, 'add']);
            Route::post('/create', [InformationController::class, 'create']);

            // grup information_id
            Route::group(['prefix' => '{information_id}'], function () {
                Route::get('/detail', [InformationController::class, 'detail']);
                Route::put('/update', [InformationController::class, 'update']);
                Route::get('/edit', [InformationController::class, 'edit']);
                Route::get('/delete', [InformationController::class, 'delete']);
                Route::get('/preview', [InformationController::class, 'preview']);

                // grup information_image
                Route::group(['prefix' => 'image'], function () {
                    Route::post('/create', [InformationController::class, 'createImage']);
                    Route::get('/delete-all', [InformationController::class, 'deleteAllImage']);
                    
                    // grup information_image_id
                    Route::group(['prefix' => '{information_image_id}'], function () {
                        Route::get('/delete', [InformationController::class, 'deleteImage']);
                        Route::put('/update', [InformationController::class, 'updateImage']);
                    });
                });

                // grup information_video
                Route::group(['prefix' => 'video'], function () {
                    Route::post('/create', [InformationController::class, 'createVideo']);
                    Route::get('/delete-all', [InformationController::class, 'deleteAllVideo']);

                    // grup information_video_id
                    Route::group(['prefix' => '{information_video_id}'], function () {
                        Route::get('/delete', [InformationController::class, 'deleteVideo']);
                        Route::put('/update', [InformationController::class, 'updateVideo']);
                    });
                });

                // grup information_document
                Route::group(['prefix' => 'document'], function () {
                    Route::post('/create', [InformationController::class, 'createDocument']);
                    Route::get('/delete-all', [InformationController::class, 'deleteAllDocument']);

                    // grup information_document_id
                    Route::group(['prefix' => '{information_document_id}'], function () {
                        Route::get('/delete', [InformationController::class, 'deleteDocument']);
                        Route::put('/update', [InformationController::class, 'updateDocument']);
                    });
                });

            });

        });

        // grup roadmap
        Route::group(['prefix' => 'roadmap'], function () {
            Route::get('/', [RoadMapController::class, 'index']);
            Route::get('/add', [RoadmapController::class, 'add']);
            Route::post('/create', [RoadmapController::class, 'create']);

            // grup roadmap_id
            Route::group(['prefix' => '{roadmap_id}'], function () {
                Route::get('/detail', [RoadmapController::class, 'detail']);
                Route::put('/update', [RoadmapController::class, 'update']);
                Route::get('/edit', [RoadmapController::class, 'edit']);
                Route::get('/delete', [RoadmapController::class, 'delete']);
                Route::get('/preview', [RoadmapController::class, 'preview']);

                // grup roadmap_image
                Route::group(['prefix' => 'image'], function () {
                    Route::post('/create', [RoadmapController::class, 'createImage']);
                    Route::get('/delete-all', [RoadmapController::class, 'deleteAllImage']);
                    
                    // grup roadmap_image_id
                    Route::group(['prefix' => '{roadmap_image_id}'], function () {
                        Route::get('/delete', [RoadmapController::class, 'deleteImage']);
                        Route::put('/update', [RoadmapController::class, 'updateImage']);
                    });
                });

                // grup roadmap_video
                Route::group(['prefix' => 'video'], function () {
                    Route::post('/create', [RoadmapController::class, 'createVideo']);
                    Route::get('/delete-all', [RoadmapController::class, 'deleteAllVideo']);

                    // grup roadmap_video_id
                    Route::group(['prefix' => '{roadmap_video_id}'], function () {
                        Route::get('/delete', [RoadmapController::class, 'deleteVideo']);
                        Route::put('/update', [RoadmapController::class, 'updateVideo']);
                    });
                });

                // grup roadmap_document
                Route::group(['prefix' => 'document'], function () {
                    Route::post('/create', [RoadmapController::class, 'createDocument']);
                    Route::get('/delete-all', [RoadmapController::class, 'deleteAllDocument']);

                    // grup roadmap_document_id
                    Route::group(['prefix' => '{roadmap_document_id}'], function () {
                        Route::get('/delete', [RoadmapController::class, 'deleteDocument']);
                        Route::put('/update', [RoadmapController::class, 'updateDocument']);
                        Route::get('/preview', [RoadmapController::class, 'previewDocument']);
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
                Route::post('/create', [UserController::class, 'create']);
    
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

            // grup information
            Route::group(['prefix' => 'information'], function () {
                Route::get('/', [InformationCategoryController::class, 'index']);
                Route::post('/create', [InformationCategoryController::class, 'create']);

                // grup information_id
                Route::group(['prefix' => '{information_id}'], function () {
                    Route::put('/update', [InformationCategoryController::class, 'update']);
                    Route::get('/delete', [InformationCategoryController::class, 'delete']);
                });

            });

            // grup highlight
            Route::group(['prefix' => 'highlight'], function () {
                Route::get('/', [HighlightCategoryController::class, 'index']);
                Route::post('/create', [HighlightCategoryController::class, 'create']);

                // grup highlight_id
                Route::group(['prefix' => '{highlight_id}'], function () {
                    Route::put('/update', [HighlightCategoryController::class, 'update']);
                    Route::get('/delete', [HighlightCategoryController::class, 'delete']);
                });

            });

            // grup setting
            Route::group(['prefix' => 'setting'], function () {
                Route::get('/', [SettingCategoryController::class, 'index']);
                Route::post('/create', [SettingCategoryController::class, 'create']);

                // grup setting_id
                Route::group(['prefix' => '{setting_id}'], function () {
                    Route::put('/update', [SettingCategoryController::class, 'update']);
                    Route::get('/delete', [SettingCategoryController::class, 'delete']);
                });

            });

        });

    });

});