<?php
namespace App\Exports;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\NameAddress;

class AddressPDFExporter
{
    public static function export($language = null)
    {
        $data = NameAddress::all();

        $fontFamily = 'DejaVu Sans, sans-serif';
        $direction = ($language === 'ar') ? 'rtl' : 'ltr';

        if ($language === 'ar') {
            $headers = '
                <th style="width: 4%;">#</th>
                <th style="width: 20%;">الاسم</th>
                <th style="width: 12%;">تاريخ الميلاد</th>
                <th style="width: 14%;">رقم الهوية</th>
                <th style="width: 12%;">الهاتف</th>
                <th style="width: 12%;">المحافظة</th>
                <th style="width: 12%;">المدينة</th>
                <th style="width: 14%;">المنطقة</th>
            ';
        } elseif ($language === 'en') {
            $headers = '
                <th style="width: 4%;">#</th>
                <th style="width: 20%;">Name</th>
                <th style="width: 12%;">Birth Date</th>
                <th style="width: 14%;">National ID</th>
                <th style="width: 12%;">Phone</th>
                <th style="width: 12%;">Governorate</th>
                <th style="width: 12%;">City</th>
                <th style="width: 14%;">Area</th>
            ';
        } else {
            $headers = '
                <th style="width: 3%;">#</th>
                <th style="width: 10%;">الاسم (عربي)</th><th style="width: 10%;">Name (English)</th>
                <th style="width: 10%;">تاريخ الميلاد</th>
                <th style="width: 12%;">رقم الهوية</th>
                <th style="width: 10%;">الهاتف</th>
                <th style="width: 10%;">المحافظة (عربي)</th><th style="width: 10%;">Governorate (English)</th>
                <th style="width: 10%;">المدينة (عربي)</th><th style="width: 10%;">City (English)</th>
                <th style="width: 10%;">المنطقة (عربي)</th><th style="width: 10%;">Area (English)</th>
            ';
        }

        $html = '<!DOCTYPE html><html lang="'.($language ?? 'ar').'"><head><meta charset="UTF-8">
            <style>
                body { font-family: '.$fontFamily.'; direction: '.$direction.'; font-size: 14px; }
                table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; word-wrap: break-word; }
                th, td { border: 1px solid #000; padding: 6px 4px; text-align: center; vertical-align: middle; white-space: normal !important; }
                td[lang="ar"], th[lang="ar"] { direction: rtl; unicode-bidi: embed; }
            </style>
            </head><body>
            <h2>'.($language === 'ar' ? 'قائمة العناوين' : ($language === 'en' ? 'List of Addresses' : 'List of Addresses - Arabic & English')).'</h2>
            <table><thead><tr>'.$headers.'</tr></thead><tbody>';

        foreach ($data as $item) {
            if ($language === 'ar') {
                $html .= '<tr><td>'.$item->id.'</td>
                    <td lang="ar">'.htmlspecialchars($item->name_ar).'</td>
                    <td>'.$item->birth_date.'</td>
                    <td>'.$item->national_id.'</td>
                    <td>'.$item->phone.'</td>
                    <td lang="ar">'.htmlspecialchars($item->governorate_ar).'</td>
                    <td lang="ar">'.htmlspecialchars($item->city_ar).'</td>
                    <td lang="ar">'.htmlspecialchars($item->area_ar).'</td></tr>';
            } elseif ($language === 'en') {
                $html .= '<tr><td>'.$item->id.'</td>
                    <td>'.htmlspecialchars($item->name_en).'</td>
                    <td>'.$item->birth_date.'</td>
                    <td>'.$item->national_id.'</td>
                    <td>'.$item->phone.'</td>
                    <td>'.htmlspecialchars($item->governorate_en).'</td>
                    <td>'.htmlspecialchars($item->city_en).'</td>
                    <td>'.htmlspecialchars($item->area_en).'</td></tr>';
            } else {
                $html .= '<tr><td>'.$item->id.'</td>
                    <td lang="ar">'.htmlspecialchars($item->name_ar).'</td><td>'.htmlspecialchars($item->name_en).'</td>
                    <td>'.$item->birth_date.'</td>
                    <td>'.$item->national_id.'</td>
                    <td>'.$item->phone.'</td>
                    <td lang="ar">'.htmlspecialchars($item->governorate_ar).'</td><td>'.htmlspecialchars($item->governorate_en).'</td>
                    <td lang="ar">'.htmlspecialchars($item->city_ar).'</td><td>'.htmlspecialchars($item->city_en).'</td>
                    <td lang="ar">'.htmlspecialchars($item->area_ar).'</td><td>'.htmlspecialchars($item->area_en).'</td></tr>';
            }
        }

        $html .= '</tbody></table></body></html>';

        return Pdf::loadHTML($html)->download('addresses.pdf');
    }
}
