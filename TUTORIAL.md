# Tutorial Penggunaan OrderKuota API Class

Berikut adalah panduan penggunaan class `OrderKuota` untuk berinteraksi dengan API OrderKuota.

## Instalasi

Pastikan Anda telah menyertakan file `OrderKuota.php` dalam proyek Anda.

```php
require 'src/OrderKuota.php';
use bionyxxx\OrderKuota;
```

## Inisialisasi

Anda dapat menginisialisasi class dengan username dan token (opsional jika sudah punya token).

```php
$username = 'username_anda';
$token = 'token_anda'; // Opsional, bisa didapat setelah login
$orderkuota = new OrderKuota($username, $token);
```

## Login

Jika Anda belum memiliki token, Anda bisa melakukan login terlebih dahulu.

```php
// Login dengan password
$response = $orderkuota->loginRequest('password_anda');
echo $response;

// Atau jika menggunakan OTP (metode getAuthToken)
$response = $orderkuota->getAuthToken('otp_code');
echo $response;
```

## Menggunakan Proxy

Fitur baru! Anda sekarang dapat mengatur proxy untuk setiap request yang dilakukan oleh class ini.

```php
// Format: setProxy($host, $port, $username = null, $password = null)

// Contoh Proxy Tanpa Autentikasi
$orderkuota->setProxy('192.168.1.10', 8080);

// Contoh Proxy Dengan Autentikasi
$orderkuota->setProxy('192.168.1.10', 8080, 'user_proxy', 'pass_proxy');

// Setelah proxy di-set, semua request selanjutnya akan melalui proxy tersebut.
```

## Mengambil Riwayat Transaksi

```php
// Mengambil riwayat transaksi QRIS
$history = $orderkuota->getTransactionQris();
echo $history;

// Mengambil riwayat transaksi QRIS Ajaib
$historyAjaib = $orderkuota->getTransactionQrisAjaib();
echo $historyAjaib;
```

## Membuat Transaksi QRIS Ajaib

```php
$amount = 10000; // Jumlah nominal
$response = $orderkuota->createQrisAjaib($amount);
echo $response;
```

## Penarikan Saldo (Withdrawal)

```php
$amount = 50000;
$response = $orderkuota->withdrawalQris($amount);
echo $response;
```
