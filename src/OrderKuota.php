<?php

namespace bionyxxx;

/**
 * [OrderKuota] OrderKuota Api PHP Class (Un-Official)
 * Author : YuF1Dev <https://github.com/yuf1dev>
 * Modified by : bionyxxx <https://github.com/bionyxxx>
 * Created at 10-10-2023 00:22
 * Last Modified at 16-12-2025 23:22
 */
class OrderKuota
{
    const API_URL = 'https://app.orderkuota.com:443/api/v2';
    const API_URL_EWALLET = 'https://checker.orderkuota.com:443/api/checkname/produk/095f701f85/11/1263871';
    const API_URL_ORDER = 'https://app.orderkuota.com:443/api/v2/order';
    const HOST = 'app.orderkuota.com';
    const USER_AGENT = 'okhttp/4.12.0';
    const APP_VERSION_NAME = '25.10.29';
    const APP_VERSION_CODE = '251029';
    const APP_REG_ID = 'e7F3UfCUQ52zkco5KCIa3s:APA91bFBdzVxvLKg3RN-Rqc3zwq0CjpW5arf_11tAYRVyRgLRCvGaV7hVmt18L_NcYTSvdSwlRCGKY8tUobzh5CuUEUKFpVyTVSrZRDXAktAkpt7NbyxOos';
    const PHONE_MODEL = 'I2216';
    const PHONE_UUID = 'e7F3UfCUQ52zkco5KCIa3s';
    const PHONE_ANDROID_VERSION = '15';


    private $authToken, $username;
    private $proxyHost, $proxyPort, $proxyUser, $proxyPass;
    private $proxied = false;

    public function __construct($username, $authToken = false)
    {
        $this->username = $username;
        if ($authToken) {
            $this->authToken = $authToken;
        }
    }

    public function setProxy($host, $port, $user = null, $pass = null)
    {
        $this->proxyHost = $host;
        $this->proxyPort = $port;
        $this->proxyUser = $user;
        $this->proxyPass = $pass;
        $this->proxied = true;
    }

    public function getMerchantCode()
    {
        $authToken = $this->authToken;

        $parts = explode(":", $authToken);
        if (count($parts) > 0) {
            return $parts[0];
        }
        return null;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public function loginRequest($password)
    {
        // Perbaikan: Menambahkan '&' sebelum app_version_name
        $payload = "username=" . $this->username . "&password=" . $password . "&app_reg_id=" . self::APP_REG_ID . "&app_version_code=" . self::APP_VERSION_CODE . "&app_version_name=" . self::APP_VERSION_NAME . "";
        return self::Request("POST", self::API_URL . '/login', $payload, true);
    }

    // Parameter $otp diganti $password sesuai logika endpoint login, atau tetap $otp jika memang itu variabelnya
    public function getAuthTokenRequest($otp)
    {
        // Perbaikan: Menambahkan '&' sebelum app_version_name
        $payload = "username=" . $this->username . "&password=" . $otp . "&app_reg_id=" . self::APP_REG_ID . "&app_version_code=" . self::APP_VERSION_CODE . "&app_version_name=" . self::APP_VERSION_NAME;
        return self::Request("POST", self::API_URL . '/login', $payload, true);
    }

    public function getTransactionQris($type = '')
    {
        $payload = "request_time=" . time() . "&app_reg_id=" . self::APP_REG_ID . "&phone_android_version=" . self::PHONE_ANDROID_VERSION . "&app_version_code=" . self::APP_VERSION_CODE . "&phone_uuid=" . self::PHONE_UUID . "&auth_username=" . $this->username . "&requests[1]=point&auth_token=" . $this->authToken . "&app_version_name=" . self::APP_VERSION_NAME . "&ui_mode=light&phone_model=" . self::PHONE_MODEL . "";
        return self::Request("POST", self::API_URL . '/get', $payload, true);
    }

    public function withdrawalQris($amount = '')
    {
        $payload = "request_time=" . time() . "&app_reg_id=" . self::APP_REG_ID . "&phone_android_version=" . self::PHONE_ANDROID_VERSION . "&app_version_code=" . self::APP_VERSION_CODE . "&phone_uuid=" . self::PHONE_UUID . "&auth_username=" . $this->username . "&requests[qris_withdraw][amount]=" . $amount . "&auth_token=" . $this->authToken . "&app_version_name=" . self::APP_VERSION_NAME . "&ui_mode=light&phone_model=" . self::PHONE_MODEL . "";
        return self::Request("POST", self::API_URL . '/get', $payload, true);
    }

    public function createQrisAjaib($amount)
    {
        $data = [
            'request_time' => round(microtime(true) * 1000),
            'app_reg_id' => self::APP_REG_ID,
            'phone_android_version' => self::PHONE_ANDROID_VERSION,
            'app_version_code' => self::APP_VERSION_CODE,
            'phone_uuid' => self::PHONE_UUID,
            'auth_username' => $this->username,
            'requests' => [
                'qris_ajaib' => ['amount' => $amount],
            ],
            'auth_token' => $this->authToken,
            'app_version_name' => self::APP_VERSION_NAME,
            'ui_mode' => 'light',
            'phone_model' => self::PHONE_MODEL
        ];

        return self::Request("POST", self::API_URL . '/get', http_build_query($data), true);
    }

    public function getTransactionQrisAjaib()
    {
        $payload = "request_time=" . time() .
            "&app_reg_id=" . self::APP_REG_ID .
            "&phone_android_version=" . self::PHONE_ANDROID_VERSION .
            "&app_version_code=" . self::APP_VERSION_CODE .
            "&phone_uuid=" . self::PHONE_UUID .
            "&auth_username=" . $this->username .
            "&requests[qris_ajaib_history][]=" .
            "&auth_token=" . $this->authToken .
            "&app_version_name=" . self::APP_VERSION_NAME .
            "&ui_mode=light" .
            "&phone_model=" . self::PHONE_MODEL;

        return self::Request("POST", self::API_URL . '/get', $payload, true);
    }

    public function createQrisMerchant($amount)
    {
        $data = [
            'request_time' => round(microtime(true) * 1000),
            'app_reg_id' => self::APP_REG_ID,
            'phone_android_version' => self::PHONE_ANDROID_VERSION,
            'app_version_code' => self::APP_VERSION_CODE,
            'phone_uuid' => self::PHONE_UUID,
            'auth_username' => $this->username,
            'requests' => [
                'qris_merchant_terms'
            ],
            'auth_token' => $this->authToken,
            'app_version_name' => self::APP_VERSION_NAME,
            'ui_mode' => 'light',
            'phone_model' => self::PHONE_MODEL
        ];

        $request = self::Request("POST", self::API_URL . '/get', http_build_query($data), true);

        if (!empty($request)) {
            $response = json_decode($request, true);
            if (isset($response['success']) && $response['success'] === true) {
                if (isset($response['qris_merchant_terms']['results']['qris_data'])) {
                    $qrisStr = $response['qris_merchant_terms']['results']['qris_data'];
                    $newQrisStr = self::generateNewDynamicQris($qrisStr, $amount);
                    $response['new_qris_data'] = $newQrisStr;

                    $request = json_encode($response);
                }
            }
        }

        return $request;
    }

    public function getTransactionQrisMerchant($type = '', $page = 1, $total = '', $description = '', $fromDate = '', $toDate = '', $minAmount = '', $maxAmount = '')
    {
        $data = [
            'app_reg_id' => self::APP_REG_ID,
            'phone_uuid' => self::PHONE_UUID,
            'phone_model' => self::PHONE_MODEL,
            'request_time' => round(microtime(true) * 1000),
            'phone_android_version' => self::PHONE_ANDROID_VERSION,
            'app_version_code' => self::APP_VERSION_CODE,
            'auth_username' => $this->username,
            'auth_token' => $this->authToken,
            'app_version_name' => self::APP_VERSION_NAME,
            'ui_mode' => 'light',

            // Bagian requests yang nested (qris_history dan index 0)
            'requests' => [
                'qris_history' => [
                    'jenis' => $type, // Filter jenis transaksi
                    'keterangan' => $description,
                    'jumlah' => $total,
                    'page' => $page,      // Halaman mutasi
                    'dari_tanggal' => $fromDate, // Format: DD-MM-YYYY (10-12-2025)
                    'ke_tanggal' => $toDate, // Format: DD-MM-YYYY (10-12-2025)
                ],
                'account' // requests[0]=account
            ]
        ];
        return self::Request("POST", self::API_URL . '/qris/mutasi/' . $this->getMerchantCode(), http_build_query($data), true);
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

        if ($this->proxied) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxyHost);
            curl_setopt($ch, CURLOPT_PROXYPORT, $this->proxyPort);
            if ($this->proxyUser && $this->proxyPass) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyUser . ':' . $this->proxyPass);
            }
        }

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

    // Helpers
    public static function generateNewDynamicQris($qrisStr, $amount, ?string $taxType = null, ?string $taxAmount = null): string
    {
        $processedQris = substr($qrisStr, 0, -4);
        $step1 = str_replace("010211", "010212", $processedQris);
        $step2 = explode("5802ID", $step1);
        $uang = "54" . sprintf("%02d", strlen($amount)) . $amount;

        $taxData = "";
        if ($taxType && $taxAmount) {
            if ($taxType == 'r') {
                $taxData = "55020256" . sprintf("%02d", strlen($taxAmount)) . $taxAmount;
            } elseif ($taxType == 'p') {
                $taxData = "55020357" . sprintf("%02d", strlen($taxAmount)) . $taxAmount;
            }
        }

        if (empty($taxData)) {
            $uang .= "5802ID";
        } else {
            $uang .= $taxData . "5802ID";
        }

        $fix = trim($step2[0]) . $uang . trim($step2[1]);
        $fix .= self::convertCRC16($fix);

        return $fix;
    }

    private static function convertCRC16(string $str): string
    {
        // charCodeAt logic inlined for simplicity and to avoid redeclaration issues
        $crc = 0xFFFF;
        $strlen = strlen($str);
        for ($c = 0; $c < $strlen; $c++) {
            $crc ^= ord(substr($str, $c, 1)) << 8; // Inlined charCodeAt
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = ($crc << 1) ^ 0x1021;
                } else {
                    $crc = $crc << 1;
                }
            }
        }
        $hex = $crc & 0xFFFF;
        $hex = strtoupper(dechex($hex));
        if (strlen($hex) == 3) $hex = "0" . $hex;
        return $hex;
    }
}
