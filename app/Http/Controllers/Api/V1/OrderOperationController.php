<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use App\Exceptions\Order\OrderException;
use App\Exceptions\UserAsset\UserAssetException;
use App\Models\GameLevelingOrder;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

/**
 * 订单操作
 * Class OrderOperationController
 * @package App\Http\Controllers\Api\V1
 */
class OrderOperationController extends Controller
{
    /**
     * 接单
     * @return mixed
     * @throws \Exception
     */
    public function take()
    {
        if (! request('trade_no') || ! request('pay_password')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->take(request('pay_password'), request('take_password'));
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }
        return response()->apiJson(0);
    }

    /**
     * 申请验收
     * @return mixed
     */
    public function applyComplete()
    {
        if (! request('trade_no') || ! request('pay_password')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->applyComplete(request('images'));
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 查看验收图片
     * @return mixed
     */
    public function applyCompleteImage()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->applyCompleteImage();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 取消验收
     * @return mixed
     */
    public function cancelComplete()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->cancelComplete();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 申请撤销
     * @return mixed
     */
    public function applyConsult()
    {
        $validator = Validator::make(request()->all(), [
            'trade_no' => 'required',
            'amount' => 'required',
            'deposit' => 'required',
            'reason' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->apiJson(1001);
        }

        // 拆分保证金
        $deposit = GameLevelingOrder::deuceDeposit(request('trade_no'), request('deposit'));
        try {
            OrderService::init(request()->user()->id, request('trade_no'))
                ->applyConsult(request('amount'), $deposit['security_deposit'], $deposit['efficiency_deposit'], request('amount'));
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);

    }

    /**
     * 取消撤销
     * @return mixed
     */
    public function cancelConsult()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->cancelConsult();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 同意撤销
     * @return mixed
     */
    public function agreeConsult()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->agreeConsult();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 不同意撤销
     * @return mixed
     */
    public function rejectConsult()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->rejectConsult();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 申请仲裁
     * @return mixed
     */
    public function applyComplain()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->applyComplain(request('reason'), request('images'));
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 取消仲裁
     * @return mixed
     */
    public function cancelComplain()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->cancelComplain();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }
        return response()->apiJson(0);
    }

    /**
     * 获取仲裁信息
     * @return mixed
     */
    public function getComplainInfo()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->getComplainInfo();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 获取仲裁信息
     * @return mixed
     */
    public function sendComplainMessage()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))
                ->sendComplainMessage(request('images'), request('content'));
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }

    /**
     * 获取仲裁信息
     * @return mixed
     */
    public function getMessage()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->getMessage();
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }
        return response()->apiJson(0);
    }

    /**
     * 发送订单留言
     * @return mixed
     */
    public function sendMessage()
    {
        if (! request('trade_no')) {
            response()->apiJson(1001);
        }

        try {
            OrderService::init(request()->user()->id, request('trade_no'))->sendMessage(request('content'));
        } catch (UserAssetException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (OrderException $exception) {
            return response()->apiJson($exception->getCode());
        } catch (Exception $exception) {
            return response()->apiJson(1003);
        }

        return response()->apiJson(0);
    }
}
