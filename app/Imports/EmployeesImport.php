<?php

namespace App\Imports;

use Mail;
use Keygen;
use Carbon\Carbon;
use App\User;
use App\ESSBase;
use App\EmployerEmployee;
use App\EmployeeEnrollment;
use App\EmployeePersonalInfo;
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

class EmployeesImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable, SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function model(array $row)  
    {

        /**
         * @
         *  Create Employee Personal Information
         * */
        //foreach ($collection as $row){
            $password = Keygen::alphanum(10)->generate();
            /**
             * @//Generated ESS ID
             * */
            $initial = (new Initials)->length(3)->generate($row['lastname'] . ' ' . $row['firstname'] . ' ' . $row['middlename']);    
            $employee_ess_id = $initial . $this->generateESSID();

            /**
             * @ Create a Employee Personal Information
             * @ The Test Inputs are Temporary
             * */
            $Employee_personal_info = EmployeePersonalInfo::create([
                        'lastname'  => $row['lastname'],
                        'firstname' => $row['firstname'],
                        'middlename' => $row['middlename'],
                        'TIN' => $row['tin'],
                        'SSSGSIS' => $row['sssgsis'],
                        'PHIC' => $row['phic'],
                        'HDMF' => $row['hdmf'],
                        'NID' => $row['nid'],
                        'mobile_no' => $row['mobile_no'],
                        'email_add' => $row['email_add'],
                        'birthdate' => Carbon::now(),
                        'gender' => 'test',
                        'civil_status' => 'test',
                        'country' => 'test',
                        'address_unit' => 'test',
                        'citytown' => 'test',
                        'barangay' => 'test',
                        'province' => 'test',
                        'zipcode' => 'test',
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
            ]);

            /**
             * @ Create Employee Enrollment
             **/
            $emppid = $Employee_personal_info->id;
            $employee = EmployeeEnrollment::create([
                    'employee_info' => $emppid,
                    'employee_no' => 'test',
                    'position' => 'test',
                    'payroll_bank' => 'test',
                    'employer_id' => auth()->user()->employer_id,
                    'department' => 'test',
                    'enrollment_date' => Carbon::now(),
                    'employment_status' => 'test',
                    'payroll_schedule' => 'test',
                    'account_no' => 'test',
                    'created_by' => auth()->user()->id,
                    'updated_by' => auth()->user()->id
            ]);

            /**
             * Employee Enrollment ID
             * */    
            $emp_id = $employee->id;
            
            /**
             * 
             * Create into ESSBase Table
             */
            ESSBase::create([
                'account_id' => $emp_id,
                'ess_id' => $employee_ess_id,
                'employee_info' => $emppid,
                'user_type_id' => 4,
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
            
            /**
             * 
             * Employer And Employee Relationship
             */
            EmployerEmployee::create([
                'ess_id' => $employee_ess_id,
                'employer_id' => auth()->user()->employer_id,
                'employee_no' => $emp_id,
                'employee_id' => $emp_id
            ]);

            /**
             * 
             * Create Account User
             */
            //insert into table user
            $user = User::create([
                'user_type_id' => 4,
                'user_type_for' => 7,
                'employer_id' => auth()->user()->employer_id,//Session::get("employer_id"),//$request->input('employer_id'),
                'employee_id' => $emp_id,
                'name' => $row['lastname'] . ", " . $row['firstname'] . ", " . $row['middlename'],
                'username' => $employee_ess_id,
                'password' => Hash::make($password),
                'expiry_date' => Carbon::now()->addCentury(), // Default for 1 Century
                'enrollment_date' => Carbon::now(),
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id,
            ]);
        //}
    }
    /*Generate Key*/
    protected function generateESSKey(){
        // prefixes the key with a random integer between 1 - 9 (inclusive)
        return Keygen::numeric(7)->prefix(mt_rand(1, 9))->generate(true);
    }

    /*Generate ESS ID*/
    protected function generateESSID(){

        $ess_id = $this->generateESSKey();

        // Ensure ID does not exist
        // Generate new one if ID already exists
        while (ESSBase::where('ess_id', $ess_id)->count() > 0){
            $ess_id = $this->generateESSKey();
        }

        return $ess_id;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'lastname' => 'required|unique:employee_personal_information',
            '*.lastname' => 'required|unique:employee_personal_information',

            'firstname' => 'required|string|unique:employee_personal_information',
            '*.firstname' => 'required|string|unique:employee_personal_information',

            'middlename' => 'required|string|unique:employee_personal_information',
            '*.middlename' => 'required|string|unique:employee_personal_information',

            'tin' => 'required|string|unique:employee_personal_information',
            '*.tin' => 'required|unique:employee_personal_information',

            'sssgsis' => 'required|unique:employee_personal_information',
            '*.sssgsis' => 'required|unique:employee_personal_information',

            'phic' => 'required|unique:employee_personal_information',
            '*.phic' => 'required|unique:employee_personal_information',

            'hdmf' => 'required|unique:employee_personal_information',
            '*.hdmf' => 'required|unique:employee_personal_information',

            'nid' => 'required|unique:employee_personal_information',
            '*.nid' => 'required|unique:employee_personal_information',
            
            'mobile_no' => 'required|unique:employee_personal_information',
            '*.mobile_no' => 'required|unique:employee_personal_information',
            
            'email_add' => 'required|unique:employee_personal_information',
            '*.email_add' => 'required|unique:employee_personal_information',

            'birthdate' => 'required|before:'.\Carbon\Carbon::now()->subYears(21)->format('Y-m-d'),
            '*.birthdate' => 'required|before:'.\Carbon\Carbon::now()->subYears(21)->format('Y-m-d'),

            // 'gender' => 'required',
            // '*.gender' => 'required',

            // 'civil_status' => 'required',
            // '*.civil_status' => 'required',

            // 'country' => 'required',
            // '*.country' => 'required',

            // 'address_unit' => 'required',
            // '*.address_unit' => 'required',

            // 'city_town' => 'required',
            // '*.city_town' => 'required',

            // 'barangay' => 'required',
            // '*.barangay' => 'required',
            
            // 'province' => 'required',
            // '*.province' => 'required',

            // 'zipcode' => 'required',
            // '*.zipcode' => 'required',
        ];
    }

    /**
     * Validation rules custome Message
     * */
    public function messages()
    {
        return [
            'required' => 'The :attribute field is required.'
        ];
    }
}
