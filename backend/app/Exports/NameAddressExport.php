<?php

namespace App\Exports;

use App\Models\NameAddress;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NameAddressExport implements FromCollection, WithHeadings
{
    protected $language;

    public function __construct($language = null) // نجعل اللغة افتراضيًا null
    {
        $this->language = $language;
    }

    public function collection()
    {
        if ($this->language === 'ar') {
            return NameAddress::select([
                'id',
                'birth_date',
                'national_id',
                'phone',
                'name_ar as name',
                'governorate_ar as governorate',
                'city_ar as city',
                'area_ar as area',
            ])->get();
        } elseif ($this->language === 'en') {
            return NameAddress::select([
                'id',
                'birth_date',
                'national_id',
                'phone',
                'name_en as name',
                'governorate_en as governorate',
                'city_en as city',
                'area_en as area',
            ])->get();
        } else {
            // حالة عدم تحديد اللغة: نطبع العربي والإنجليزي معًا
            return NameAddress::select([
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
            ])->get();
        }
    }

    public function headings(): array
    {
        if ($this->language === 'ar') {
            return ['المعرف', 'تاريخ الميلاد', 'رقم الهوية', 'الهاتف', 'الاسم', 'المحافظة', 'المدينة', 'المنطقة'];
        } elseif ($this->language === 'en') {
            return ['ID', 'Birth Date', 'National ID', 'Phone', 'Name', 'Governorate', 'City', 'Area'];
        } else {
            return [
                'ID',
                'Birth Date',
                'National ID',
                'Phone',
                'الاسم (عربي)',
                'Name (English)',
                'المحافظة (عربي)',
                'Governorate (English)',
                'المدينة (عربي)',
                'City (English)',
                'المنطقة (عربي)',
                'Area (English)',
            ];
        }
    }
}
