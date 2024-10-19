<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SettingsService;

class SettingsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * Mục đích: Đăng ký các service vào container của ứng dụng.
     * Phương thức này được gọi trong quá trình khởi động ứng dụng.
     */
    public function register(): void
    {
        // Đăng ký SettingsService như một singleton trong container.
        // Điều này đảm bảo chỉ có một instance duy nhất của SettingsService trong ứng dụng.
        $this->app->singleton(SettingsService::class, function () {
            // Closure này sẽ được gọi khi tôi yêu cầu SettingsService lần đầu tiên.
            return new SettingsService(); // Trả về một instance mới của SettingsService.
        });
    }

    /**
     * Bootstrap services.
     *
     * Mục đích: Được gọi sau khi tất cả các service đã được đăng ký.
     * Thực hiện các tác vụ cần thiết để khởi động dịch vụ ở đây.
     */
    public function boot(): void
    {
        // Lấy instance của SettingsService từ container.
        $settingsService = $this->app->make(SettingsService::class);

        // Gọi phương thức setGlobalSettings() của SettingsService.
        // Mục đích: Đặt các cài đặt toàn cục từ cơ sở dữ liệu vào cấu hình của ứng dụng.
        $settingsService->setGlobalSettings();
    }
}
