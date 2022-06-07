<?php
use think\Route;
//v1
Route::group('v1',function(){
	Route::post('login','v1/common.Login/exeLogin');
	Route::post('upload','v1/service.upload/getFile');
	Route::post('getWeb','v1/service.WebAction/getWeb');
	Route::post('getAllArticle','v1/portal.Article/getAllArticle');
	Route::post('saveArt','v1/portal.Article/saveArt');
	Route::post('getOneArticle','v1/portal.Article/getOneArticle');
	Route::post('deleteArticle','v1/portal.Article/deleteArticle');
	Route::post('articleStatus','v1/portal.Article/articleStatus');

	Route::post('getAllCol','v1/portal.Col/getAllCol');
	Route::post('saveCon','v1/portal.Col/saveCon');
	Route::post('deleteCol','v1/portal.Col/deleteCol');

	//web
	Route::get('getArticles/:col','v1/web.Article/getArticles',[],['col'=>'\d+']);
	Route::get('getCols','v1/web.Article/getCols');
});