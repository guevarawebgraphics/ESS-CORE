<?php

namespace App\Imports;
/**
 * @ Insert Laravel Packages Here
 * */
use Mail;
use Keygen;
use Carbon\Carbon;

/**
 *  @ Insert Models Here
 * */
use App\User;
use App\EmployeeEnrollment;
use App\payrollregister;
use App\payrollregisterdetails;

/**
 * Maat Website Packages
 *  */
use LasseRafn\Initials\Initials;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;

class PayrollImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    use Importable;
    /**
     * PayrollImport Construct
     * */
    public function __construct($payregisterid)
    {

      $this->payregisterid = $payregisterid;
      
    }
    /**
      * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
      /**
       * Get Employee ID
       */
      $get_employee_id = EmployeeEnrollment::where('employee_no', '=', $row['employeeno'])->pluck('id');

        /**
         * @ Create Payroll Register Details
         * */
        $payroll_register_details = payrollregisterdetails::create([
                    'PayRegisterId' => $this->payregisterid,
                    'account_id' => '1235422',
                    'basic' => $row['basic'],
                    'absent' => $row['absent'],
                    'late' => $row['late'],
                    'regular_ot' => $row['regularot'],
                    'undertime' => $row['undertime'],
                    'legal_holiday' => $row['legal_holiday'],
                    'special_holiday' => $row['special_non_working_holiday'],
                    'night_differencial' => $row['night_diff'],
                    'adjustment_salary' => $row['adjustment_salary'],
                    'night_diff_ot' => $row['night_diff_ot'],
                    'incentives' => $row['incentive'],
                    'commision' => $row['commisions'],
                    'net_basic_taxable' => $row['net_basic_taxable_income'],
                    'non_taxable_allowance' => $row['non_taxable_allowance'],
                    'rice_allowance' => $row['rice_allowance'],
                    'meal_allowance' => $row['meal_allowance'],
                    'transpo' => $row['transpo'],
                    'ecola' => $row['ecola'],
                    'grosspay' => $row['gross_pay'],
                    'sss' => $row['sss'],
                    'phic' => $row['phic'],
                    'hdmf' => $row['hdmf'],
                    'wtax' => $row['wtax'],
                    'sss_loan' => $row['sss_loan'],
                    'hdmf_load' => $row['hdmf_loan'],
                    'bank_loan' => $row['bank_loan'],
                    'cash_advance' => $row['cash_advance'],
                    'total_deduction' => $row['total_deductions'],
                    'net_pay' => $row['net_pay'],
                    'bank_id' => '1',
                    'payroll_release_date' => Carbon::now(),
                    'overtime_hours' => $row['overtime_hours'],
                    'absences_days' => $row['absences_days'],
                    'account_status_datetime' => Carbon::now(),
                    'created_at' => Carbon::now(),
                    'created_by' => auth()->user()->id,
                    'created_datetime' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'updated_datetime' => Carbon::now(),

        ]);
    }

    /**
     * @ Batch Insert
     * */
    public function batchSize(): int
    {
        return 1000;
    }
}
