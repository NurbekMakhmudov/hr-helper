<?php

if (!function_exists('d')) {
    /**
     * Debug function
     * d($var);
     */
    function d($var, $caller = null)
    {
        if (!isset($caller)) {
            $array = debug_backtrace(1);
            $caller = array_shift($array);
        }
        echo '<code>File: ' . $caller['file'] . ' / Line: ' . $caller['line'] . '</code>';
        echo '<pre>';
        yii\helpers\VarDumper::dump($var, 10, true);
        echo '</pre>';
    }
}

if (!function_exists('dd')) {

    /**
     * Debug function with die() after
     * dd($var);
     */
    function dd($var)
    {
        $array = debug_backtrace(1);
        $caller = array_shift($array);
        d($var, $caller);
        die();
    }
}


if (!function_exists('_lang')) {

    /**
     * @return mixed
     */
    function _lang()
    {
        $lang = explode('-', Yii::$app->language);
        return $lang[0];
    }
}

if (!function_exists('_langFull')) {

    /**
     * @return mixed
     */
    function _langFull()
    {
        return Yii::$app->language;
    }
}


if (!function_exists('isNullObject')) {

    function isNullObject($object)
    {
        if ($object == null || empty($object) || $object == '')
            return true;

        return false;
    }
}

if (!function_exists('isFalseObject')) {

    function isFalseObject($object)
    {
        if ($object == false)
            return true;

        return false;
    }
}


if (!function_exists('randNum')) {

    function randNum()
    {
        return rand(1, 1000000);
    }
}


if (!function_exists('clearPhone')) {
    /**
     * @param $phone
     * @return bool|string
     */
    function clearPhone($phone)
    {
        $number = preg_replace('/\D/', '', $phone);
        if (strlen($number) < 9)
            return false;
        return substr($number, -9);
    }
}


if (!function_exists('getPhoneWithoutCode')) {
    /**
     * @param $phone
     * @return bool|string
     */
    function getPhoneWithoutCode($phone)
    {
        $number = preg_replace('/\D/', '', $phone);
        if (strlen($number) > 9)
            return substr($number, -9);
        else
            return $number;
    }
}


if (!function_exists('clearPhoneFull')) {
    /**
     * @param $phone
     * @return bool|string
     */
    function clearPhoneFull($phone)
    {
        $number = preg_replace('/\D/', '', $phone);
        if ($number && ctype_digit($number) && strlen($number) === 9) {
            $number = '998' . substr($number, -9);
        }
        return $number;
    }
}


if (!function_exists('addPhoneMask')) {
    /**
     * @param $phone
     * @return bool|string
     */
    function addPhoneMask($phone)
    {
        $data = clearPhoneFull($phone);
        if (preg_match('/(\d{3})(\d{2})(\d{3})(\d{2})(\d{2})/', $data, $matches)) {
            $result = '+' . $matches[1] . $matches[2] . '-' . $matches[3] . '-' . $matches[4] . $matches[5];
            return $result;
        }
    }
}


if (!function_exists('clearCard')) {
    /**
     * @param $cardNumber
     * @return bool|string
     */
    function clearCard($cardNumber)
    {
        $number = preg_replace('/\D/', '', $cardNumber);
        if (strlen($number) < 16)
            return false;
        return substr($number, -16);
    }
}

if (!function_exists('clearCardExpire')) {
    /**
     * @return bool|string
     */
    function clearCardExpire($cardExpire)
    {
        $card_expire = preg_replace('/\D/', '', $cardExpire);
        if (strlen($card_expire) < 4)
            return false;
        return substr($card_expire, -4);
    }
}

if (!function_exists('priceAddSumName')) {
    /**
     * @return bool|string
     */
    function priceAddSumName($price)
    {
        $p = $price * ProductDollarRate::getDollarRate();
        return number_format((float)$p, 2, '.', ' ') . Yii::t('functions', ' сум');
    }
}

if (!function_exists('priceSumName')) {
    /**
     * @return bool|string
     */
    function priceSumName($price)
    {
        return number_format((float)$price, 2, '.', ' ');
    }
}


if (!function_exists('priceDollarName')) {
    /**
     * @return bool|string
     */
    function priceDollarName($price)
    {
        return Yii::t('functions', '$ ') . number_format((float)$price, 2, '.', ' ');
    }
}


if (!function_exists('priceAddSumNameNotSumm')) {

    function priceAddSumNameNotSumm($price)
    {
        return number_format(Product::getPriceBySumStatic((float)$price), 0, '.', ' ') . Yii::t('functions', "");
    }
}


if (!function_exists('generateErrors')) {

    function generateErrors($errors = [])
    {
        $flash_errors = null;
        $index = 0;
        if (is_array($errors)) {
            foreach ($errors as $model_error) {
                if (is_array($model_error)) {
                    foreach ($model_error as $error) {
                        $flash_errors[$index++] = $error;
                    }
                } else {
                    $flash_errors[$index++] = $model_error;
                }
            }
        } else {
            $flash_errors = [$errors];
        }

        return $flash_errors;
    }
}


if (!function_exists('setFlash')) {

    function setFlash($key, $messages, $params = [])
    {
        if (is_array($messages)) {
            foreach ($messages as $message => $item) {
                session()->setFlash($key, $item);
            }
        } else
            session()->setFlash($key, $messages);
    }
}


if (!function_exists('session')) {

    function session()
    {
        $session = Yii::$app->session;
        if (!$session->isActive) $session->open();
        return $session;
    }
}

if (!function_exists('setSession')) {

    function setSession($key, $value)
    {
        session()->set($key, $value);
    }
}

if (!function_exists('getSession')) {

    function getSession($key, $defaultValue = null)
    {
        if (session()->has($key))
            return session()->get($key, $defaultValue);
    }
}

if (!function_exists('removeSession')) {

    function removeSession($key, $all = false)
    {
        if ($all)
            session()->removeAll();
        else {
            if (session()->has($key))
                session()->remove($key);
        }
    }
}

if (!function_exists('createFolder')) {

    function createFolder($path)
    {
        if (!file_exists($path)) {
            \yii\helpers\FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
        }

        if (file_exists($path)) {
            return $path;
        }
    }
}


if (!function_exists('cname')) {        // get class name without namespace

    function cname($class)
    {
        $path = explode('\\', $class);
        return array_pop($path);
    }
}

if (!function_exists('getClassMethodName')) {        // get class and method name without namespace

    function getClassMethodName($classMethod)
    {
        $resArr = explode('\\', $classMethod);
        $classMethodName = array_pop($resArr);

        $res = explode('::', $classMethodName);
        $className = $res[0];
        $methodName = $res[1];
        return [
            'className' => $className,
            'methodName' => $methodName,
        ];
    }
}

if (!function_exists('generateRandomString')) {

    function generateRandomString($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i <= $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}


if (!function_exists('tCyrLat')) {

    function tCyrLat($textcyr = null, $textlat = null)
    {
        $cyr = array(
            'ж', 'ч', 'щ', 'ш', 'ю', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ь', 'я',
            'Ж', 'Ч', 'Щ', 'Ш', 'Ю', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ь', 'Я');
        $lat = array(
            'zh', 'ch', 'sht', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'y', 'x', 'q',
            'Zh', 'Ch', 'Sht', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', 'Y', 'X', 'Q');
        if ($textcyr) return str_replace($cyr, $lat, $textcyr);
        else if ($textlat) return str_replace($lat, $cyr, $textlat);
        else return null;
    }

}


if (!function_exists('http_response_code')) {
    function http_response_code($code = NULL)
    {

        if ($code !== NULL) {

            switch ($code) {
                case 100:
                    $text = 'Continue';
                    break;
                case 101:
                    $text = 'Switching Protocols';
                    break;
                case 200:
                    $text = 'OK';
                    break;
                case 201:
                    $text = 'Created';
                    break;
                case 202:
                    $text = 'Accepted';
                    break;
                case 203:
                    $text = 'Non-Authoritative Information';
                    break;
                case 204:
                    $text = 'No Content';
                    break;
                case 205:
                    $text = 'Reset Content';
                    break;
                case 206:
                    $text = 'Partial Content';
                    break;
                case 300:
                    $text = 'Multiple Choices';
                    break;
                case 301:
                    $text = 'Moved Permanently';
                    break;
                case 302:
                    $text = 'Moved Temporarily';
                    break;
                case 303:
                    $text = 'See Other';
                    break;
                case 304:
                    $text = 'Not Modified';
                    break;
                case 305:
                    $text = 'Use Proxy';
                    break;
                case 400:
                    $text = 'Bad Request';
                    break;
                case 401:
                    $text = 'Unauthorized';
                    break;
                case 402:
                    $text = 'Payment Required';
                    break;
                case 403:
                    $text = 'Forbidden';
                    break;
                case 404:
                    $text = 'Not Found';
                    break;
                case 405:
                    $text = 'Method Not Allowed';
                    break;
                case 406:
                    $text = 'Not Acceptable';
                    break;
                case 407:
                    $text = 'Proxy Authentication Required';
                    break;
                case 408:
                    $text = 'Request Time-out';
                    break;
                case 409:
                    $text = 'Conflict';
                    break;
                case 410:
                    $text = 'Gone';
                    break;
                case 411:
                    $text = 'Length Required';
                    break;
                case 412:
                    $text = 'Precondition Failed';
                    break;
                case 413:
                    $text = 'Request Entity Too Large';
                    break;
                case 414:
                    $text = 'Request-URI Too Large';
                    break;
                case 415:
                    $text = 'Unsupported Media Type';
                    break;
                case 500:
                    $text = 'Internal Server Error';
                    break;
                case 501:
                    $text = 'Not Implemented';
                    break;
                case 502:
                    $text = 'Bad Gateway';
                    break;
                case 503:
                    $text = 'Service Unavailable';
                    break;
                case 504:
                    $text = 'Gateway Time-out';
                    break;
                case 505:
                    $text = 'HTTP Version not supported';
                    break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            header($protocol . ' ' . $code . ' ' . $text);

            $GLOBALS['http_response_code'] = $code;

        } else {

            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

        }

        return $code;

    }
}















