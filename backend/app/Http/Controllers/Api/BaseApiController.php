<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    /**
     * إرجاع استجابة ناجحة
     */
  
public function returnSuccess($data = null, $message = "تم بنجاح", $status = 200)
{
    return response()->json([
        'status' => true,
        'message' => $message,
        'data' => $data,  // إضافة بيانات الاستجابة هنا
    ], $status);
}

    /**
     * إرجاع استجابة خطأ عام
     */
  public function returnError($message = "حدث خطأ ما", $status = 400, $errors = null)
{
    return response()->json([
        'status' => false,
        'message' => $message,
        'errors' => $errors
    ], $status);
}

public function returnNotFound($message = "العنصر المطلوب غير موجود", $status = 404)
{
    return $this->returnError($message, $status);
}


    /**
     * إرجاع استجابة خطأ تحقق من البيانات
     */
  public function returnValidationError($validator)
{
    return response()->json([
        'status' => false,
        'message' => 'الرجاء التأكد من تعبئة الحقول المطلوبة بشكل صحيح.',
        'errors' => $validator->errors()
    ], 422);
}

}
