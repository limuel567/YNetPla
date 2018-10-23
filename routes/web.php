<?php

Route::group(['middlewareGroups' => ['web']], function(){
	// Route::group(['middleware' => 'force'], function (){ // SSL
		Route::group(["prefix" => "admin", 'namespace' => 'Backend'], function(){
		Route::get('logout', 'MainController@getLogout');
		
		// Admin
			Route::group(['middleware' => 'admin'], function(){
                Route::group(["prefix" => "settings"], function(){
					Route::get('{slug}', 'SettingsController@getView');
					Route::post('default-cover', 'SettingsController@postDefaultCover');
					Route::post('default-avatar', 'SettingsController@postDefaultAvatar');
					Route::post('cloudinary', 'SettingsController@postCloudinary');
					Route::post('filestack', 'SettingsController@postFilestack');
					Route::post('social', 'SettingsController@postSocial');
					Route::post('general', 'SettingsController@postGeneral');
					Route::get('/', 'SettingsController@getIndex');
				});
				Route::group(["prefix" => "content-management"], function(){
					// ---------- Post Method ---------- //
					Route::post('/save', 'ContentManagementController@postSave');
					Route::post('/add' , 'ContentManagementController@postAdd');
					// ---------- Get Method ---------- //
					Route::get('/remove-repeater-fields', 'ContentManagementController@getRemoveRepeaterFields');
					Route::get('/repeater-fields'       , 'ContentManagementController@getRepeaterFields');
					Route::get('/edit-content/{id}'        , 'ContentManagementController@getEditPage');
					Route::get('/add'                   , 'ContentManagementController@getAdd');
					Route::get('/'                      , 'ContentManagementController@getIndex');
				});
				Route::group(["prefix" => "tv-series-trailer"], function(){
					Route::get('/', 'TrailerManagementController@getIndex');
					// Route::get('create', 'TrailerManagementController@getCreate');
					Route::get('edit/{id}', 'TrailerManagementController@getEdit');
					Route::get('null', 'TrailerManagementController@getNullTvSeries');
					Route::get('not-null', 'TrailerManagementController@getNotNullTvSeries');

					Route::post('create', 'TrailerManagementController@postCreate');
				});
				Route::group(["prefix" => "movies-trailer"], function(){
					Route::get('/', 'MovieTrailerController@getIndex');
					// Route::get('create', 'MovieTrailerController@getCreate');
					Route::get('edit/{id}', 'MovieTrailerController@getEdit');

					Route::post('edit', 'MovieTrailerController@postEdit');
				});
				Route::group(["prefix" => "editor-choice"], function(){
					Route::get('/', 'TopPicksController@getIndex');
					Route::get('create', 'TopPicksController@getCreate');
					Route::get('edit/{id}', 'TopPicksController@getEdit');

					Route::post('create/{id}', 'TopPicksController@postCreate');
				});
				Route::group(["prefix" => "season-premiere"], function(){
					Route::get('/', 'SeasonPremiereController@getIndex');
					Route::get('add', 'SeasonPremiereController@getCreate');
					Route::get('edit', 'SeasonPremiereController@getEdit');

					Route::post('add', 'SeasonPremiereController@postCreate');
				});
				Route::group(["prefix" => "article-management"], function(){
					Route::get('/', 'ArticleManagementController@getIndex');
					Route::get('create', 'ArticleManagementController@getCreate');
					Route::get('edit/{id}', 'ArticleManagementController@getEdit');
					Route::get('delete/{id}', 'ArticleManagementController@getDelete');

					Route::post('create', 'ArticleManagementController@postCreate');
				});
				Route::group(["prefix" => "subscription"], function(){
					Route::get('/', 'SubscriptionController@getIndex');
					Route::get('create', 'SubscriptionController@getCreate');
					Route::get('edit/{id}', 'SubscriptionController@getEdit');

					Route::post('create', 'SubscriptionController@postCreate');
				});
				Route::group(["prefix" => "users"], function(){
					// ---------- Post Method ---------- //
					Route::get('{slug}' , 'UsersManagementController@getView');
					Route::post('/edit'       	 , 'UsersManagementController@postEdit');
					// ---------- Get Method ---------- //
					Route::get('/edit/{id}'  , 'UsersManagementController@getEdit');
					Route::get('/delete/{id}', 'UsersManagementController@getDelete');
					Route::get('/view-user-details/{id}', 'UsersManagementController@getViewUserDetails');
					Route::get('/'           , 'UsersManagementController@getIndex');
				});
			});
			// UnAuthenticated for Backend
			Route::post('/reset-password' , 'MainController@postResetPassword');
			Route::post('/login'          , 'MainController@postLogin');
			Route::post('/forgot-password', 'MainController@postForgotPassword');
			// ---------- Get Method ---------- //
			Route::get('/reset-password' , 'MainController@getResetPassword');
			Route::get('/forgot-password', 'MainController@getForgotPassword');
			Route::get('/', 'MainController@getIndex');
		});
		Route::group(['namespace' => 'Frontend'], function(){
			Route::group(["prefix" => "popular-books"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('/', 'MainController@getPopularBooks');
			});
			Route::group(["prefix" => "popular-movies"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('/', 'MainController@getPopularMovies');
			});
			Route::group(["prefix" => "popular-tv-series"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('/', 'MainController@getPopularTVShow');
			});
			Route::group(["prefix" => "coming-soon-movies"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('/', 'MainController@getComingSoonMovies');
			});
			Route::group(["prefix" => "season-premieres"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('/', 'MainController@getSeasonPremieres');
			});
			Route::group(["prefix" => "movies"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('{id}', 'MainController@getInnerMovies');
			});
			Route::group(["prefix" => "schedule"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('/', 'MainController@getSchedule');
			});
			Route::group(["prefix" => "tv-series"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('{id}', 'MainController@getInnerTVShow');
			});
			Route::group(["prefix" => "articles"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('/', 'MainController@getArticle');
				Route::get('{id}', 'MainController@getArticleInner');
			});
			Route::group(["prefix" => "books"], function(){
				// ---------- Post Method ---------- //

				// ---------- Get Method ---------- //
				Route::get('{id}', 'MainController@getArticleInner');
			});
			// UnAuthenticated for user interface
			Route::get('/', 'MainController@getIndex');
            Route::get('/inner', 'MainController@getInner');
            Route::get('/api-testing', 'MainController@getApiTesting');
            Route::get('/api-testing-xml', 'MainController@getApiTestingXML');
		});
}); 