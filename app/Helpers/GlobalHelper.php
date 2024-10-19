<?php

/** Truncate string in name listings */

if (!function_exists('cutString')) {
    function cutString(string $text, int $limit = 20): ?string
    {
        // Đây là class Str trong Laravel, giúp xử lý các thao tác với chuỗi.
        // Dấu \ trước Str là để chỉ rõ chúng ta đang gọi class Str thuộc global namespace của Laravel,
        // không phải một class Str nào khác trong namespace hiện tại (nếu có).
        return \Str::of($text)    // Tạo một đối tượng chuỗi từ biến $text.
            ->limit($limit);  // Giới hạn độ dài chuỗi bằng giá trị $limit, ví dụ: "Hello World" sẽ thành "Hello" nếu $limit = 5.
    }
}

/** Active Routes */

if (!function_exists('setActiveRoute')) {
    function setActiveRoute(array $routes): ?string
    {
        foreach ($routes as $route) {
            if (request()->routeIs($route)) {
                return 'active';
            }
        }
        return null;
    }
}

/** Active Routes */

if (!function_exists('currencyPostion')) {
    function currencyPostion(int $amount): ?string
    {
        if (config('settings.site_currency_position') === 'right') {
            return $amount . config('settings.site_currency_icon');
        } else {
            return config('settings.site_currency_icon') . $amount;
        }
        return null;
    }
}

/** Show videos */

if (!function_exists('getURL')) {
    function getURL(string $url): ?string
    {
        //https://www.youtube.com/watch?v=bIqCVkJS7VQ
        $regex = '/[?&]v=([a-zA-Z0-9_-]{11})/'; //regex function

        /** Hàm preg_match kiểm tra xem biểu thức chính quy $regex có khớp với chuỗi $url hay không.
         * Nếu có, nó sẽ lưu trữ các kết quả khớp trong mảng $matches.
         * $matches[0] chứa toàn bộ chuỗi khớp, và $matches[1] chứa nhóm đầu tiên (ID video) được xác định bởi dấu ngoặc đơn trong biểu thức chính quy.
         */
        if (preg_match($regex, $url, $matches)) {
            $id = $matches[1];

            return "https://img.youtube.com/vi/$id/mqdefault.jpg";
        }
        return null;
    }
}
