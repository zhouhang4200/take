<?php

/**
 * 生成订单号
 * @return string
 */
function generateOrderNo()
{
    // 14位长度当前的时间 20150709105750
    $orderDate = date('YmdHis');
    // 今日订单数量
    $orderQuantity = cache()->increment(config('redis_key.order.quantity') . date('Ymd'));
    return $orderDate . str_pad($orderQuantity, 8, 0, STR_PAD_LEFT);
}

/**
 * 将秒转成: (天\小时\分\秒) 形式
 *
 * @param      $seconds
 * @param bool $showSeconds
 *
 * @return bool|string
 */
function sec2Time($seconds, $showSeconds = false)
{
    if (is_numeric($seconds)) {
        $value = array(
            'years' => 0, 'days' => 0, 'hours' => 0,
            'minutes' => 0, 'seconds' => 0,
        );
        if ($seconds >= 31556926) {
            $value['years'] = floor($seconds / 31556926);
            $seconds = ($seconds % 31556926);
        }
        if ($seconds >= 86400) {
            $value['days'] = floor($seconds / 86400);
            $seconds = ($seconds % 86400);
        }
        if ($seconds >= 3600) {
            $value['hours'] = floor($seconds / 3600);
            $seconds = ($seconds % 3600);
        }
        if ($seconds >= 60) {
            $value['minutes'] = floor($seconds / 60);
            $seconds = ($seconds % 60);
        }
        $value['seconds'] = floor($seconds);

        $t = '';
        if ($value['years'] > 0) {
            $t .= $value['years'] . '年';
        }
        if ($value['days'] > 0) {
            $t .= $value['days'] . ' 天 ';
        }
        if ($value['hours'] > 0) {
            $t .= $value['hours'] . ' 小时 ';
        }
        if ($value['minutes'] > 0) {
            $t .= $value['minutes'] . ' 分 ';
        }
        if ($value['seconds'] > 0 || $showSeconds) {
            $t .= $value['seconds'] . ' 秒';
        }
        Return $t;
    } else {
        return (bool)FALSE;
    }
}


if (!function_exists('hasEmployees')) {
    /**
     * 获取某个岗位有哪些员工
     * @param string $prefix
     * @return string
     */
    function hasEmployees($userRole)
    {
        $userNames = $userRole->users ? $userRole->users->pluck('name')->toArray() : '';

        if ($userNames) {
            return implode($userNames, '、');
        }
        return '';
    }
}

if(!function_exists('clientRSADecrypt')){
    /**
     * 前端传输数据解密
     * @param $hexEncryptData
     * @return mixed
     */
    function clientRSADecrypt($hexEncryptData)
    {
        $privateKey = "-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQCpaqa1W3o3nu1BbA33xmbCp52cxdpduvayixPGMYeF33ccAtpa
gdjToIo8f/bh5JGAIZIihOx/UPl7NtcqjZ0O6cG8EuoPJ1Gdo/Qe+uNtzSWmI/S1
IwDW0GAW5lTP1X8NO9u4NVxebXfr1be6xZpnluhEMp2SKQEZrA89dx/15wIDAQAB
AoGBAIYK8T3609dgMl4Z7W9GlhWbYxQgYybX/8rCSXH9zDl61pXeF/+WTwUaN2Wo
5aBTJWAYr7QKMciGO+5mNJXhmApjoP5edlqp86i4yErd3kukwaXgc6n3pmCsYR9C
TWYdD3X726DQt+5dee8Pw42RLfcvC/xGhuaPuEGBcp6eFRBxAkEA21VedrlJZovj
bx5UrcaGvxpgGy0B58nW/k83COQmo1w+CX+P4yekmsAgZyt1iRVRkoknEmld3rnD
/ubzaMXnjwJBAMW9CChee90mGtTyrvlUpOIv2pbSIARtR8duu/SzPBmWEbJttdRg
hZojWGP8DZowBOU30DqdvidcI2JhZUfEICkCQGFHZMVNerOjubTQBAiq85qQzS1g
cebnC5bxdVxZLJXp1I4L6Lp8G7KTIgwAJ3osXWibshulZf/h7n8A2daPaBsCQDp1
UycUH8xWipIwGPiPRJu2CAqUnnCQmirkmt6R6o+p5Rt6AcqCqpzSHDya9K6Dyb62
THI31lKuk6tvHdEks1kCQQCX5XtcAsLKa9Vd1BvZcNWLXYXCeJX3cOQg5obrXuNa
fgMCzgxMM0hmL1eC3kSxtd4z5gUAHLUxwuzrG+JroHpk
-----END RSA PRIVATE KEY-----";

        $encryptData = pack("H*", $hexEncryptData);
        openssl_private_decrypt($encryptData, $decryptData, $privateKey);
        return $decryptData;
    }
}

if (!function_exists('base64ToImg')) {

    /**
     * 将base64图片存为图片到resources 指定目录
     * @param $base64Str string
     * @param $path string 指定的目录
     * @return array
     */
    function base64ToImg($base64Str, $path)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64Str, $result)) {
            $imgDir = '/resources/' . $path . '/';
            if (!is_dir(public_path($imgDir))) {
                mkdir(public_path($imgDir), 0777);
            }
            $imageName = uniqid() . '.png';
            $imgPath = $imgDir .  $imageName;
            if (file_put_contents(public_path($imgPath), base64_decode(str_replace($result[1], '', $base64Str)))) {
                return [
                    'mime_type' => 'image/png',
                    'name' => $imageName,
                    'path' => $imgPath,
                ];
            }
        }
    }
}
