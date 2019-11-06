<?php

namespace App\Services;

use App\Services\Exceptions\CaptchaException;

class Captcha
{
    private const URL_VERIFY = 'https://www.google.com/recaptcha/api/siteverify';
    private const REQUEST_KEY = 'g-recaptcha-response';

    /**
     * @var string
     */
    protected $siteKey;

    /**
     * @var string
     */
    protected $secretKey;

    /**
     * Captcha constructor.
     */
    public function __construct()
    {
        $this->siteKey = env('INVISIBLE_RECAPTCHA_SITEKEY');
        $this->secretKey = env('INVISIBLE_RECAPTCHA_SECRETKEY');
    }

    /**
     * @return bool
     * @throws CaptchaException
     */
    public function verify()
    {
        if (!request()->has(self::REQUEST_KEY)) {
            throw new CaptchaException(trans('contact-form.empty_captcha'));
        }
        $result = file_get_contents(
            self::URL_VERIFY,
            false,
            stream_context_create(
                [
                    'http' => [
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query([
                            'response' => request()->post(self::REQUEST_KEY),
                            'secret' => $this->secretKey
                        ]),
                    ],
                ]
            )
        );
        $result = json_decode($result);
        if (empty($result->success)) {
            throw new CaptchaException(trans('contact-form.error_captcha'));
        }

        return true;
    }
}
