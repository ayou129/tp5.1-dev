<?php
use think\facade\Route;

// -------------------------- Base -----------------------------------
Route::miss('api/Base/miss');
Route::get('/', 'api/Base/home');
// -------------------------- Base -----------------------------------


// -------------------------- Resource -----------------------------------
Route::group(':version/resource', function () {
    Route::get('types', 'api/:version.resource/getResourceTypes');//登录
    Route::get('download/:resource_type_id', 'api/:version.resource/downloadResource')->pattern(['resource_type_id' => '\d+']);;//修改密码
});
// -------------------------- Resource -----------------------------------


// -------------------------- Site -----------------------------------
//Route::group('site', function () {
//    Route::get('list', 'api/resource/getSiteList');//获取siteList
//});
// -------------------------- Site -----------------------------------


return [

];
