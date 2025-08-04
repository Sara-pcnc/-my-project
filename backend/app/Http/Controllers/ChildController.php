<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Support\Facades\Lang;

class ChildController extends BaseApiController
{
 public function index(Request $request)
{
    $language = $request->query('language', 'en');

    if ($request->has('name')) {
        $name = $request->input('name');
        $hasArabic = preg_match('/\p{Arabic}/u', $name);
        $hasEnglish = preg_match('/[a-zA-Z]/', $name);

        if ($language === 'en' && $hasArabic) {
            return $this->returnError('الرجاء البحث عن الأسماء الإنجليزية فقط عند اختيار اللغة الإنجليزية.', 422);
        }

        if ($language === 'ar' && $hasEnglish) {
            return $this->returnError('يرجى البحث عن الأسماء العربية فقط عند اختيار اللغة العربية.', 422);
        }
    }

    $columns = [
        'id',
        'parent_id',
        'birth_date',
        $language === 'en' ? 'name_en as name' : 'name_ar as name',
    ];

    $query = Child::select($columns);

    if ($request->has('id')) {
        $query->where('id', $request->id);
    }

    if ($request->has('name')) {
        $nameColumn = $language === 'en' ? 'name_en' : 'name_ar';
        $query->whereRaw("LOWER($nameColumn) like ?", ['%' . strtolower($request->name) . '%']);
    }

    if ($request->has('parent_id')) {
        $query->where('parent_id', $request->parent_id);
    }

    $results = $query->get();

    return $this->returnSuccess($results, 'تم جلب البيانات بنجاح');
}



    public function store(Request $request)
    {
        $language = $request->input('language', 'en');
        $rules = $this->getRulesByLanguageFromModel($language);

        $validator = Validator::make($request->all(), $rules, $this->customMessages());
        $validator->setAttributeNames($this->attributeNames());

        if ($validator->fails()) {
            $message = $language === 'ar'
                ? 'يرجى التأكد من تعبئة الحقول المطلوبة باللغة العربية والإنجليزية.'
                : 'Please make sure to fill in the required fields in both Arabic and English.';
            return $this->returnError($message, 422, $validator->errors()->toArray());
        }

        $child = Child::create($validator->validated());
        return $this->returnSuccess($child, 'تم إنشاء الطفل بنجاح', 201);
    }

    public function update(Request $request, $id)
    {
        $child = Child::find($id);

        if (!$child) {
            return $this->returnNotFound('الطفل المطلوب غير موجود أو تم حذفه.');
        }

        $language = $request->input('language', 'en');
        $rules = $this->getRulesByLanguageFromModel($language, $id);

        $validator = Validator::make($request->all(), $rules, $this->customMessages());
        $validator->setAttributeNames($this->attributeNames());

        if ($validator->fails()) {
            $message = $language === 'ar'
                ? 'يرجى التأكد من تعبئة الحقول المطلوبة باللغة العربية والإنجليزية.'
                : 'Please make sure to fill in the required fields in both Arabic and English.';
            return $this->returnError($message, $validator->errors()->toArray());
        }

        $child->update($validator->validated());
        return $this->returnSuccess($child, 'تم تعديل بيانات الطفل بنجاح');
    }

    public function destroy($id)
    {
        $child = Child::find($id);

        if (!$child) {
            return $this->returnNotFound('الطفل المطلوب غير موجود أو تم حذفه.');
        }

        $child->delete();
        return $this->returnSuccess(null, 'تم حذف الطفل بنجاح');
    }

    private function getRulesByLanguageFromModel($language, $id = null)
    {
        $allRules = Child::rules();

        $filteredRules = [];
        $filteredRules['name_ar'] = $allRules['name_ar'];
        $filteredRules['name_en'] = $allRules['name_en'];

        foreach ($allRules as $field => $rules) {
            if (in_array($field, ['name_ar', 'name_en'])) {
                continue;
            }

            if (
                ($language === 'en' && (str_ends_with($field, '_en') || $field === 'parent_id' || $field === 'birth_date')) ||
                ($language === 'ar' && (str_ends_with($field, '_ar') || $field === 'parent_id' || $field === 'birth_date'))
            ) {
                $filteredRules[$field] = $rules;
            }
        }

        return $filteredRules;
    }

    private function attributeNames()
    {
        return [
            'name_ar' => 'الاسم بالعربية',
            'name_en' => 'الاسم بالإنجليزية',
            'parent_id' => 'المعرف الخاص بالأب',
            'birth_date' => 'تاريخ الميلاد',
        ];
    }

    private function customMessages()
    {
        return [
            'required' => 'الرجاء إدخال :attribute',
            'date' => ':attribute يجب أن يكون تاريخ صالح',
            'exists' => ':attribute غير موجود في النظام',
            'name_ar.regex' => 'الاسم بالعربية يجب أن يحتوي على حروف عربية فقط بدون أرقام أو رموز.',
            'name_en.regex' => 'الاسم بالإنجليزية يجب أن يحتوي على حروف إنجليزية فقط بدون أرقام أو رموز.',
        ];
    }
}
