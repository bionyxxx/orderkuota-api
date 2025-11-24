<?php

namespace bionyxxx;

/**
 * [OrderKuota] OrderKuota Api PHP Class (Un-Official)
 * Author : YuF1Dev <https://github.com/yuf1dev>
 * Created at 10-10-2023 00:22
 * Last Modified at 26-08-2025 23:18
 */
class OrderKuota
{
    const API_URL = 'https://app.orderkuota.com:443/api/v2';
    const API_URL_EWALLET = 'https://checker.orderkuota.com:443/api/checkname/produk/095f701f85/11/1263871';
    const API_URL_ORDER = 'https://app.orderkuota.com:443/api/v2/order';
    const HOST = 'app.orderkuota.com';
    const USER_AGENT = 'okhttp/4.12.0';
    const APP_VERSION_NAME = '25.08.11';
    const APP_VERSION_CODE = '250811';
    const APP_REG_ID = 'di309HvATsaiCppl5eDpoc:APA91bFUcTOH8h2XHdPRz2qQ5Bezn-3_TaycFcJ5pNLGWpmaxheQP9Ri0E56wLHz0_b1vcss55jbRQXZgc9loSfBdNa5nZJZVMlk7GS1JDMGyFUVvpcwXbMDg8tjKGZAurCGR4kDMDRJ';
    const PHONE_MODEL = 'SM-G960N';
    const PHONE_UUID = 'di309HvATsaiCppl5eDpoc';
    

    private $authToken, $username;

    public function __construct($username, $authToken = false)
    {
        $this->username = $username;
        if ($authToken) {
            $this->authToken = $authToken;
        }
    }

    // HAPUS parameter $username, gunakan $this->username
    public function loginRequest($password)
    {
        // Perbaikan: Menambahkan '&' sebelum app_version_name
        $payload = "username=" . $this->username . "&password=" . $password . "&app_reg_id=" . self::APP_REG_ID . "&app_version_code=" . self::APP_VERSION_CODE . "&app_version_name=" . self::APP_VERSION_NAME . "";
        return self::Request("POST", self::API_URL . '/login', $payload, true);
    }

    // HAPUS parameter $username, gunakan $this->username
    // Parameter $otp diganti $password sesuai logika endpoint login, atau tetap $otp jika memang itu variabelnya
    public function getAuthToken($otp)
    {
        // Perbaikan: Menambahkan '&' sebelum app_version_name
        $payload = "username=" . $this->username . "&password=" . $otp . "&app_reg_id=" . self::APP_REG_ID . "&app_version_code=" . self::APP_VERSION_CODE . "&app_version_name=" . self::APP_VERSION_NAME . "";
        return self::Request("POST", self::API_URL . '/login', $payload, true);
    }

    public function getTransactionQris($type = '')
    {
        $payload = "request_time=".time()."&app_reg_id=" . self::APP_REG_ID . "&phone_android_version=9&app_version_code=" . self::APP_VERSION_CODE . "&phone_uuid=" . self::PHONE_UUID . "&auth_username=" . $this->username . "&requests[1]=point&auth_token=" . $this->authToken . "&app_version_name=" . self::APP_VERSION_NAME . "&ui_mode=light&requests[0]=account&phone_model=" . self::PHONE_MODEL . "";
        return self::Request("POST", self::API_URL . '/get', $payload, true);
    }

    public function withdrawalQris($amount = '')
    {
        $payload = "request_time=".time()."&app_reg_id=" . self::APP_REG_ID . "&phone_android_version=9&app_version_code=" . self::APP_VERSION_CODE . "&phone_uuid=" . self::PHONE_UUID . "&auth_username=" . $this->username . "&requests[qris_withdraw][amount]=" . $amount . "&auth_token=" . $this->authToken . "&app_version_name=" . self::APP_VERSION_NAME . "&ui_mode=light&requests[0]=account&phone_model=" . self::PHONE_MODEL . "";
        return self::Request("POST", self::API_URL . '/get', $payload, true);
    }

    public function createQrisAjaib($amount)
    {
        $data = [
            'request_time' => round(microtime(true) * 1000),
            'app_reg_id' => self::APP_REG_ID,
            'phone_android_version' => 9,
            'app_version_code' => self::APP_VERSION_CODE,
            'phone_uuid' => self::PHONE_UUID,
            'auth_username' => $this->username,
            'requests' => [
                'qris_ajaib' => ['amount' => $amount],
                0 => 'account' // request check account
            ],
            'auth_token' => $this->authToken,
            'app_version_name' => self::APP_VERSION_NAME,
            'ui_mode' => 'light',
            'phone_model' => self::PHONE_MODEL
        ];

        // http_build_query otomatis mengubah array di atas menjadi string:
        // request_time=123...&requests%5Bqris_ajaib%5D%5Bamount%5D=10000...
        return self::Request("POST", self::API_URL . '/get', http_build_query($data), true);
    }


    protected function buildHeaders()
    {
        $headers = array(
            'Host: ' . self::HOST,
            'User-Agent: ' . self::USER_AGENT,
            'Content-Type: application/x-www-form-urlencoded',
        );
        return $headers;
    }


    protected function Request($type = "GET", $url, $post = false, $headers = false)
    {
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ));

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

        if ($post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        if ($headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, self::buildHeaders());
        }

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}
