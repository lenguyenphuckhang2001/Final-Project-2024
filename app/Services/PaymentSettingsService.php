<?php

namespace App\Services;

use App\Models\PaymentSetting;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class PaymentSettingsService
{
    // Hàm này dùng để lấy các cài đặt từ cache (nếu có), hoặc sẽ lấy từ database nếu cache chưa tồn tại, sau đó lưu vào cache.
    function getSettings()
    {
        return Cache::rememberForever('payment', function () {
            return PaymentSetting::pluck('value', 'key')->toArray();
        });
    }

    // Hàm này dùng để lấy các cài đặt từ cache và lưu chúng vào file cấu hình global của Laravel.
    //Mục đích là để có thể truy cập các cài đặt này dễ dàng từ bất kỳ đâu trong ứng dụng.
    function setGlobalSettings()
    {
        $settings = $this->getSettings();
        config()->set('payment', $settings);
    }

    // Hàm này dùng để xóa cài đặt khỏi cache.
    // Mục đích là khi cài đặt được thay đổi, cần xóa cache cũ để lần sau hệ thống sẽ lấy cài đặt mới từ database.
    function clearCachedSettings()
    {
        Cache::forget('payment');
    }
}
