<?php

namespace App\Http\Controllers;

use EasyWeChat\Payment\Application;
use Illuminate\Http\Request;
use Yansongda\Pay\Pay;

class IndexController extends Controller
{
    /**
     * demo例子
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function demo(Request $request,Application $application)
    {
        if($request->isMethod('post')){
            $code = $request->input('code');
            $result = $application->authCodeToOpenid($code);
            $result = $application->pay([
                'body' => '乘车支付demo',
                'out_trade_no' => '1217752501201407033233368018'.rand(1000,9999),
                'total_fee' => 1,
                'auth_code' => $code,
            ]);
            dd($result);
            dd('111');
        }
        return view('demo');
    }

    /**
     * 支付宝测试
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ali_demo(Request $request)
    {
        if ($request->isMethod('post')) {
            $code = $request->input('code');
            $order = [
                'out_trade_no' => time(),
                'total_amount' => '0.01',
                'subject'      => '乘车支付demo',
                'auth_code' => $code,
            ];
            $config =  config('pay.alipay');
            $alipay = Pay::alipay($config);
            dd($alipay->pos($order)->send());
        }
        return view('demo');
    }
}
