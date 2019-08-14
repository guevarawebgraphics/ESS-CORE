<?php

namespace App\Exports;

use App\payroll_register_details_preview;
use App\payrollregisterdetails;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PayrollExport implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    //use Exportable;
    /**
     * PayrollImport Construct
     * */
    public function __construct($payregister_id)
    {

      $this->payregister_id = $payregister_id;
      
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return payroll_register_details_preview::where('created_by', '=', auth()->user()->id)
        //                     ->select(
        //                             'account_id',
        //                             'basic',
        //                             'late',
        //                             'absent',
        //                             'undertime',
        //                             'regular_ot',
        //                             'legal_holiday',
        //                             'special_holiday',
        //                             'night_differencial',
        //                             'adjustment_salary',
        //                             'night_diff_ot',
        //                             'incentives',
        //                             'commision',
        //                             'net_basic_taxable',
        //                             'non_taxable_allowance',
        //                             'rice_allowance',
        //                             'meal_allowance',
        //                             'telecom',
        //                             'transpo',
        //                             'ecola',
        //                             'grosspay',
        //                             'sss',
        //                             'phic',
        //                             'hdmf',
        //                             'wtax',
        //                             'sss_loan',
        //                             'hdmf_loan',
        //                             'bank_loan',
        //                             'cash_advance',
        //                             'total_deduction',
        //                             'net_pay',
        //                             'bank_id',
        //                             //'payroll_release_date',
        //                             'overtime_hours',
        //                             //'account_status',
        //                             'absences_days')
        //                             ->get();

        return payrollregisterdetails::where('created_by', '=', auth()->user()->id)->where('PayRegisterId', '=', $this->payregister_id)
                            ->select(
                                    'employee_no',
                                    'basic',
                                    'late',
                                    'absent',
                                    'undertime',
                                    'regular_ot',
                                    'legal_holiday',
                                    'special_holiday',
                                    'night_differencial',
                                    'adjustment_salary',
                                    'night_diff_ot',
                                    'incentives',
                                    'commision',
                                    'net_basic_taxable',
                                    'non_taxable_allowance',
                                    'rice_allowance',
                                    'meal_allowance',
                                    'telecom',
                                    'transpo',
                                    'ecola',
                                    'grosspay',
                                    'sss',
                                    'phic',
                                    'hdmf',
                                    'wtax',
                                    'sss_loan',
                                    'hdmf_loan',
                                    'bank_loan',
                                    'cash_advance',
                                    'total_deduction',
                                    'net_pay',
                                    'bank_id',
                                    //'payroll_release_date',
                                    'overtime_hours',
                                    //'account_status',
                                    'absences_days')
                                    ->get();
    }


    public function headings(): array
    {
        return [
            //'id',
            //'PayRegisterId',
            'EMPLOYEENO',
            'BASIC',
            'ABSENT',
            'LATE',
            'UNDERTIME',
            'REGULAROT',
            'LEGAL_HOLIDAY',
            'SPECIAL_NON_WORKING_HOLIDAY',
            'NIGHT_DIFF',
            'ADJUSTMENT_SALARY',
            'NIGHT_DIFF_OT',
            'INCENTIVES',
            'COMMISIONS',
            'NET_BASIC_TAXABLE_INCOME',
            'NON_TAXABLE_ALLOWANCE',
            'RICE_ALLOWANCE',
            'MEAL_ALLOWANCE',
            'TELECOME',
            'TRANSPO',
            'ECOLA',
            'GROSS_PAY',
            'SSS',

            'PHIC',
            'HDMF',
            'WTAX',
            'SSS_LOAN',
            'HDMF_LOAN',
            'BANK_LOAN',
            'CASH_ADVANCE',
            'TOTAL_DEDUCTIONS',
            'NET_PAY',
            'BANK_ACCOUNT_NO',
            //'account_no',
            //'payroll_release_date',
            'OVERTIME_HOURSE',
            'ABSENCES_DAYS',
            //'account_status',
            // 'created_at',
            // 'created_by',
            // 'created_datetime',
            // 'updated_at',
            // 'updated_datetime'
        ];
    }

    // public function map($payroll_register_details_preview): array
    // {
    //     return [
    //         $payroll_register_details_preview->EMPLOYEENO
    //     ];
    // }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
