<?php

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
    }
    return null;
}
