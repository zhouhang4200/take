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

Route::namespace('Api')->group(function () {
    // 小程序接口
    Route::middleware('auth:api')->prefix('v1')->group(function () {
        Route::post('register', 'RegisterController@register'); // 注册
        Route::post('login', 'LoginController@login'); // 登录
        Route::prefix('profile')->group(function () {
            Route::get('/', 'ProfileController@index'); // 个人资料首页
        });
        Route::prefix('order')->group(function () {

        });
        Route::prefix('finance')->group(function () {

        });
        Route::prefix('setting')->group(function () {

        });
        Route::prefix('help')->group(function () {

        });
        Route::prefix('notice')->group(function () {

        });

        // 订单操作(小程序)
        Route::prefix('order')->group(function () {
            Route::post('apply-consult', 'OrderController@applyConsult'); // 申请协商
            Route::post('cancel-consult', 'OrderController@cancelConsult'); // 取消协商
            Route::post('agree-consult', 'OrderController@agreeConsult'); // 同意协商
            Route::post('reject-consult', 'OrderController@rejectConsult'); // 不同意协商
            Route::post('apply-complain', 'OrderController@applyComplain'); // 申请仲裁
            Route::post('cancel-complain', 'OrderController@cancelComplain'); // 取消仲裁
            Route::post('detail', 'OrderController@detail'); // 详情
            Route::post('apply-complete-image', 'OrderController@applyCompleteImage'); // 发送完成截图
            Route::post('complain-message', 'OrderController@complainMessage'); // 发送仲裁证据
            Route::post('get-message', 'OrderController@getMessage'); // 获取留言
            Route::post('send-message', 'OrderController@sendMessage'); // 发送留言
            Route::post('get-complain-info', 'OrderController@getComplainInfo'); // 仲裁详情
        });
    });
    // 订单操作(天猫发单器)
    Route::prefix('tm')->middleware('api.auth')->group(function () {
        Route::post('onsale', 'TmOrderController@onSale'); // 上架
        Route::post('offsale', 'TmOrderController@offSale'); // 下架
        Route::post('delete', 'TmOrderController@delete'); // 撤单
        Route::post('lock', 'TmOrderController@lock'); // 锁定
        Route::post('cancel-lock', 'TmOrderController@cancelLock'); // 取消锁定
        Route::post('complete', 'TmOrderController@complete'); // 完成
        Route::post('apply-consult', 'TmOrderController@applyConsult'); // 申请协商
        Route::post('cancel-consult', 'TmOrderController@cancelConsult'); // 取消协商
        Route::post('agree-consult', 'TmOrderController@agreeConsult'); // 同意协商
        Route::post('reject-consult', 'TmOrderController@rejectConsult'); // 不同意协商
        Route::post('apply-complain', 'TmOrderController@applyComplain'); // 申请仲裁
        Route::post('cancel-complain', 'TmOrderController@cancelComplain'); // 取消仲裁
        Route::post('detail', 'TmOrderController@detail'); // 详情
        Route::post('add-time', 'TmOrderController@addTime'); // 加时
        Route::post('add-money', 'TmOrderController@addMoney'); // 加价
        Route::post('update-account-password', 'TmOrderController@updateAccountPassword'); // 修改账号密码
        Route::post('apply-complete-image', 'TmOrderController@applyCompleteImage'); // 完成的截图
        Route::post('complain-message', 'TmOrderController@complainMessage'); // 仲裁证据
        Route::post('get-message', 'TmOrderController@getMessage'); // 获取留言
        Route::post('send-message', 'TmOrderController@sendMessage'); // 发送留言
        Route::post('get-complain-info', 'TmOrderController@getComplainInfo'); // 仲裁详情
    });
    Route::post('update', 'TmOrderController@update'); // 修改订单
    Route::post('place-order', 'TmOrderController@placeOrder'); // 下单
});
