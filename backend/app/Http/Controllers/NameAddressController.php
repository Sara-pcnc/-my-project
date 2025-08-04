<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\BaseApiController;
use App\Models\NameAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use App\Exports\NameAddressExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\AddressPDFExporter;


class NameAddressController extends BaseApiController

{public function index(Request $request)
{
    $language = $request->query('language');

    // بناء الأعمدة والحقول والفلاتر حسب اللغة
    if ($language === 'ar') {
        $columns = [
            'id',
            'birth_date',
            'national_id',
            'phone',
            'name_ar as name',
            'governorate_ar as governorate',
            'city_ar as city',
            'area_ar as area',
        ];

        $childColumns = [
            'id',
            'parent_id',
            'birth_date',
            'name_ar as name',
        ];

        $fields = [
            'id' => 'id',
            'name' => 'name_ar',
            'city' => 'city_ar',
            'governorate' => 'governorate_ar',
            'area' => 'area_ar',
            'national_id' => 'national_id',
            'phone' => 'phone',
        ];
    } elseif ($language === 'en') {
        $columns = [
            'id',
            'birth_date',
            'national_id',
            'phone',
            'name_en as name',
            'governorate_en as governorate',
            'city_en as city',
            'area_en as area',
        ];

        $childColumns = [
            'id',
            'parent_id',
            'birth_date',
            'name_en as name',
        ];

        $fields = [
            'id' => 'id',
            'name' => 'name_en',
            'city' => 'city_en',
            'governorate' => 'governorate_en',
            'area' => 'area_en',
            'national_id' => 'national_id',
            'phone' => 'phone',
        ];
    } else {
        // بدون لغة محددة: إرجاع الحقول العربية والإنجليزية كلها بدون alias
        $columns = [
            'id',
            'birth_date',
            'national_id',
            'phone',
            'name_ar',
            'name_en',
            'governorate_ar',
            'governorate_en',
            'city_ar',
            'city_en',
            'area_ar',
            'area_en',
        ];

        $childColumns = [
            'id',
            'parent_id',
            'birth_date',
            'name_ar',
            'name_en',
        ];

        $fields = [
            'id' => 'id',
            'name_ar' => 'name_ar',
            'name_en' => 'name_en',
            'city_ar' => 'city_ar',
            'city_en' => 'city_en',
            'governorate_ar' => 'governorate_ar',
            'governorate_en' => 'governorate_en',
            'area_ar' => 'area_ar',
            'area_en' => 'area_en',
            'national_id' => 'national_id',
            'phone' => 'phone',
        ];
    }

    $query = NameAddress::select($columns)->with(['children' => function($q) use ($childColumns) {
        $q->select($childColumns);
    }]);

    // تطبيق الفلاتر
    foreach ($fields as $inputField => $column) {
        if ($request->has($inputField)) {
            $value = strtolower($request->input($inputField));
            if ($inputField === 'id') {
                $query->where($column, $value);
            } else {
                $query->whereRaw("LOWER($column) like ?", ["%$value%"]);
            }
        }
    }

    // فلترة بأسماء الأبناء (child_name)
    if ($request->has('child_name')) {
        $childName = strtolower($request->input('child_name'));
        $query->whereHas('children', function ($q) use ($childName) {
            $q->whereRaw("LOWER(name_ar) like ?", ["%$childName%"])
              ->orWhereRaw("LOWER(name_en) like ?", ["%$childName%"]);
        });
    }

    $results = $query->get();

    if ($results->isEmpty()) {
        return $this->returnSuccess([], "لا يوجد سجلات تطابق الفلترة");
    }

    return $this->returnSuccess($results, "تم جلب البيانات بنجاح");
}



    public function store(Request $request)
    {
        $rules = $this->getRulesByLanguageFromModel();

        $validator = Validator::make($request->all(), $rules, $this->customMessages());
        $validator->setAttributeNames($this->attributeNames());

        if ($validator->fails()) {
            return $this->returnValidationError($validator);
        }

        $validated = $validator->validated();
        $record = NameAddress::create($validated);

        return $this->returnSuccess($record, "تم إنشاء البيانات بنجاح", 201);
    }

    public function update(Request $request, $id)
    {
        $record = NameAddress::find($id);

        if (!$record) {
            return $this->returnError("العنصر غير موجود", 404);
        }

        $rules = $this->getRulesByLanguageFromModel($id);

        $validator = Validator::make($request->all(), $rules, $this->customMessages());
        $validator->setAttributeNames($this->attributeNames());

        if ($validator->fails()) {
            return $this->returnValidationError($validator);
        }

        $validated = $validator->validated();
        $record->update($validated);

        return $this->returnSuccess($record, "تم التحديث بنجاح");
    }

    public function destroy($id)
    {
        $record = NameAddress::find($id);

        if (!$record) {
            return $this->returnError("العنصر غير موجود", 404);
        }

        $record->delete();

        return $this->returnSuccess(null, "تم حذف العنصر بنجاح");
    }

    private function getRulesByLanguageFromModel($id = null)
    {
        $allRules = NameAddress::rules();

        if ($id && isset($allRules['national_id'])) {
            $allRules['national_id'] = [
                'required',
                'string',
                'regex:/^\d+$/',
                'max:20',
                "unique:names_addresses,national_id,$id",
            ];
        }

        return $allRules;
    }

    private function attributeNames()
    {
        return [
            'name_ar' => 'الاسم بالعربية',
            'name_en' => 'الاسم بالإنجليزية',
            'birth_date' => 'تاريخ الميلاد',
            'governorate_ar' => 'المحافظة بالعربية',
            'governorate_en' => 'المحافظة بالإنجليزية',
            'city_ar' => 'المدينة بالعربية',
            'city_en' => 'المدينة بالإنجليزية',
            'area_ar' => 'المنطقة بالعربية',
            'area_en' => 'المنطقة بالإنجليزية',
            'national_id' => 'رقم الهوية',
            'phone' => 'رقم الهاتف',
        ];
    }

    private function customMessages()
    {
        return [
            'name_ar.required' => 'الرجاء إدخال الاسم بالعربية',
            'name_ar.regex' => 'الاسم بالعربية يجب أن يحتوي على حروف عربية فقط',

            'name_en.required' => 'الرجاء إدخال الاسم بالإنجليزية',
            'name_en.regex' => 'الاسم بالإنجليزية يجب أن يحتوي على حروف إنجليزية فقط',

            'birth_date.required' => 'الرجاء إدخال تاريخ الميلاد',
            'birth_date.date' => 'تاريخ الميلاد يجب أن يكون تاريخًا صالحًا',
            'birth_date.date_format' => 'تاريخ الميلاد يجب أن يكون بالصيغة (YYYY-MM-DD)',
            'birth_date.before' => 'تاريخ الميلاد يجب أن يكون قبل اليوم',

            'governorate_ar.required' => 'الرجاء إدخال المحافظة بالعربية',
            'governorate_ar.regex' => 'المحافظة بالعربية يجب أن تحتوي على حروف عربية فقط',

            'governorate_en.required' => 'الرجاء إدخال المحافظة بالإنجليزية',
            'governorate_en.regex' => 'المحافظة بالإنجليزية يجب أن تحتوي على حروف إنجليزية فقط',

            'city_ar.required' => 'الرجاء إدخال المدينة بالعربية',
            'city_ar.regex' => 'المدينة بالعربية يجب أن تحتوي على حروف عربية فقط',

            'city_en.required' => 'الرجاء إدخال المدينة بالإنجليزية',
            'city_en.regex' => 'المدينة بالإنجليزية يجب أن تحتوي على حروف إنجليزية فقط',

            'area_ar.required' => 'الرجاء إدخال المنطقة بالعربية',
            'area_ar.regex' => 'المنطقة بالعربية يجب أن تحتوي على حروف عربية فقط',

            'area_en.required' => 'الرجاء إدخال المنطقة بالإنجليزية',
            'area_en.regex' => 'المنطقة بالإنجليزية يجب أن تحتوي على حروف إنجليزية فقط',

            'national_id.required' => 'الرجاء إدخال رقم الهوية',
            'national_id.regex' => 'رقم الهوية يجب أن يتكون من أرقام فقط',
            'national_id.unique' => 'رقم الهوية مستخدم مسبقًا',

            'phone.required' => 'الرجاء إدخال رقم الهاتف',
            'phone.regex' => 'رقم الهاتف يجب أن يكون بصيغة صحيحة (مثلاً: 0561234567 أو 0591234567)',
        ];
    }

public function exportExcel(Request $request)
{
    $language = $request->query('language'); 
    $fileName = match ($language) {
        'ar' => 'العناوين.xlsx',
        'en' => 'NameAddresses.xlsx',
        default => 'NameAddresses_Bilingual.xlsx'
    };

    return Excel::download(new NameAddressExport($language), $fileName);
}


public function exportPDF(Request $request)
{
    $language = $request->query('language');
    return AddressPDFExporter::export($language);
}

}
