<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    // Hàm này dùng để lấy các cài đặt từ cache (nếu có), hoặc sẽ lấy từ database nếu cache chưa tồn tại, sau đó lưu vào cache.
    function getSettings()
    {
        /**
         * Cache::rememberForever sẽ kiểm tra cache với khóa 'settings'.
         * Nếu cache tồn tại, trả về giá trị từ cache.
         * Nếu cache không tồn tại, chạy callback function để lấy từ database và lưu vào cache vĩnh viễn.
         */
        return Cache::rememberForever('settings', function () {
            /**
             * Hàm trả về pluck('value', 'key) sẽ trả về một mảng collection với giá trị là value và key của value
             * Ví dụ :  ['site_name'  => 'My Website',
             *          'site_email' => 'info@myweb.com']
             * site_name sẽ là key và 'My Website' sẽ là value
             * Hàm toArray() sẽ chuyển đổi collection thành array để dễ dàng thao tác
             */
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    // Hàm này dùng để lấy các cài đặt từ cache và lưu chúng vào file cấu hình global của Laravel.
    //Mục đích là để có thể truy cập các cài đặt này dễ dàng từ bất kỳ đâu trong ứng dụng.
    function setGlobalSettings()
    {
        // Lấy cài đặt từ cache hoặc database
        $settings = $this->getSettings();

        // Đặt các cài đặt vào cấu hình Laravel. Các cài đặt này giờ có thể truy cập với config('settings.key')
        config()->set('settings', $settings);
    }

    // Hàm này dùng để xóa cài đặt khỏi cache.
    // Mục đích là khi cài đặt được thay đổi, cần xóa cache cũ để lần sau hệ thống sẽ lấy cài đặt mới từ database.
    function clearCachedSettings()
    {
        // Cache::forget('settings') xóa khóa 'settings' khỏi cache.
        // Lần sau khi gọi getSettings(), hệ thống sẽ phải truy vấn database và tạo lại cache mới.
        Cache::forget('settings');
    }
}
