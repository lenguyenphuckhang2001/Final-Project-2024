<?php

namespace App\Traits;

use File;
use Illuminate\Http\Request;

trait FileHandlingTrait
{
    function imageUpload(Request $request, string $inputName, ?string $previousImagePath = null, string $directory = '/uploads'): ?string
    {
        // Kiểm tra xem có file ảnh được upload hay không
        if ($request->hasFile($inputName)) {
            // Lấy file ảnh từ form và lưu vào biến $uploadedImage
            $uploadedImage = $request->{$inputName};

            // Lấy phần mở rộng của file (ví dụ: jpg, png)
            $extension = $uploadedImage->getClientOriginalExtension();

            // Tạo tên file mới bằng cách sử dụng uniqid()
            $newImageName = 'media_' . uniqid() . '.' . $extension;

            // Di chuyển file ảnh tới thư mục uploads
            $uploadedImage->move(public_path($directory), $newImageName);

            // Đường dẫn mặc định nếu không có ảnh cũ
            $defaultDirectory = "/default";

            // Xóa ảnh cũ nếu có
            if ($previousImagePath && File::exists(public_path($previousImagePath)) && strpos($previousImagePath, $defaultDirectory) !== 0) {
                File::delete(public_path($previousImagePath));
            }

            // Trả về đường dẫn của ảnh vừa tải lên
            return $directory . '/' . $newImageName;
        }
        return null;
    }

    function multipleUploadImage(Request $request, string $inputName, string $directory = '/uploads'): ?array
    {
        // Kiểm tra nếu có nhiều file ảnh được upload
        if ($request->hasFile($inputName)) {

            // Lấy mảng các ảnh đã tải lên
            $uploadedImages = $request->{$inputName};

            $imagePaths = [];

            // Lặp qua từng ảnh và xử lý
            foreach ($uploadedImages as $uploadedImage) {
                // Lấy phần mở rộng của ảnh
                $extension = $uploadedImage->getClientOriginalExtension();

                // Tạo tên ảnh mới
                $newImageName = 'media_' . uniqid() . '.' . $extension;

                // Di chuyển ảnh vào thư mục uploads
                $uploadedImage->move(public_path($directory), $newImageName);

                // Lưu đường dẫn ảnh vào mảng
                $imagePaths[] = $directory . '/' . $newImageName;
            }

            return $imagePaths;
        }
        return null;
    }

    function deleteUploadedFile($filePath): void
    {
        $defaultDirectory = "/default";

        // Kiểm tra và xóa file nếu tồn tại và không thuộc thư mục mặc định
        if ($filePath && File::exists(public_path($filePath)) && strpos($filePath, $defaultDirectory) !== 0) {
            File::delete(public_path($filePath));
        }
    }
}
