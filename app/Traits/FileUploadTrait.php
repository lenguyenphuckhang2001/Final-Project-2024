<?php

namespace App\Traits;

use File;
use Illuminate\Http\Request;

trait FileUploadTrait
{
    function uploadImage(Request $request, string $inputName, string $oldPath = null, string $path = '/uploads'): ?string
    {
        //Hàm này kiểm tra xem ảnh có được upload lên không
        if ($request->hasFile($inputName)) {
            //Sau khi có file lấy từ form và lưu vào biến $image
            $image = $request->{$inputName};
            //Phần mở rộng của file jpg,png,...
            $ext = $image->getClientOriginalExtension();
            //Đặt tên cho file kết hợp với uniqid() với prefix là media_. Ví dụ media_64fd0d674ec2f.jpg
            $imageName = 'media_' . uniqid() . '.' . $ext;

            //File sẽ được di chuyển tới thư mục uploads cụ thể hơn /public/uploads/media_64fd0d674ec2f.jpg
            $image->move(public_path($path), $imageName);

            //Xóa ảnh gốc từ storage
            if ($oldPath && File::exists(public_path($oldPath))) {
                File::delete(public_path($oldPath));
            }
            //Trả về đường dẫn sau khi thành công /uploads/media_64fd0d674ec2f.jpg
            return $path . '/' . $imageName;
        }
        return null;
    }
}
