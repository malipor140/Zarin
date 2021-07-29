# زرین پال | Zarinpal

Zarinpal library for Laravel based on Zarinpal API v4

کتابخانه زرین پال برای لاراول براساس نسخه 4 ای‌پی‌آی زرین پال

## روش نصب - Installation

Use composer to install this package

برای نصب و استفاده از این پکیج می توانید از کمپوسر استفاده کنید

```bash
composer require pishran/zarinpal
```

## تنظیمات - Configuration

Add your merchant id to .env file

مرچنت کد خود را اضافه کنید

```dotenv
ZARINPAL_MERCHANT_ID=00000000-0000-0000-0000-000000000000
```

To change currency to Toman (Default) 

برای تغییر واحد پول به تومان (مقدار پیشفرض)

```dotenv
ZARINPAL_CURRENCY=IRT
```

To change currency to Rial

برای تغییر واحد پول به ریال

```dotenv
ZARINPAL_CURRENCY=IRR
```

To enable sandbox mode

برای فعالسازی حالت تست

```dotenv
ZARINPAL_SANDBOX_ENABLED=true
```

## روش استفاده | How to use

### ارسال مشتری به درگاه پرداخت | Send customer to payment gateway

```php
$response = zarinpal()
    ->amount(100) // مبلغ تراکنش
    ->request()
    ->description('transaction info') // توضیحات تراکنش
    ->callbackUrl('https://domain.com/verification') // آدرس برگشت پس از پرداخت
    ->mobile('09123456789') // شماره موبایل مشتری - اختیاری
    ->email('name@domain.com') // ایمیل مشتری - اختیاری
    ->send();

if (!$response->success()) {
    return $response->error()->message();
}

// ذخیره اطلاعات در دیتابیس
// $response->authority();

// هدایت مشتری به درگاه پرداخت
return $response->redirect();
```

### بررسی وضعیت تراکنش | Verify payment status

```php
$authority = request()->query('Authority'); // دریافت کوئری استرینگ ارسال شده توسط زرین پال
$status = request()->query('Status'); // دریافت کوئری استرینگ ارسال شده توسط زرین پال

$response = zarinpal()
    ->amount(100)
    ->merchant_id(config('zarinpal.merchant_id'))
    ->verification()
    ->authority($authority)
    ->send();

if (!$response->success()) {
    return $response->error()->message();
}

// دریافت هش شماره کارتی که مشتری برای پرداخت استفاده کرده است
// $response->cardHash();

// دریافت شماره کارتی که مشتری برای پرداخت استفاده کرده است (بصورت ماسک شده)
// $response->cardPan();

// پرداخت موفقیت آمیز بود
// دریافت شماره پیگیری تراکنش و انجام امور مربوط به دیتابیس
return $response->referenceId();
```
