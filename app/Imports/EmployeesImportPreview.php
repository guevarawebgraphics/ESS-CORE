<?php

namespace App\Imports;

/**
 * @ Insert Laravel Packages Here
 * */
use DB;
use Mail;
use Keygen;
use Carbon\Carbon;

/**
 *  @ Insert Models Here
 * */
use App\User;
use App\ESSBase;
use App\EmployerEmployee;
use App\EmployeeEnrollment;
use App\EmployeePersonalInfo;
use App\UserActivation;
use App\employee_personal_information_preview;

/**
 * Maat Website Packages
 *  */
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
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

class EmployeesImportPreview implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts
{
    use Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row) 
    {
        $emp_no = $row['employee_no'];
        $employer_id = auth()->user()->employer_id;
        /**
         * @ Validate Employee No
         *  */
        // Validator::make($row, [
        //     //'employee_no' => 'required|min:3|unique:employee,employee_no,employer_id,'.$row['employee_no'].','.auth()->user()->employer_id,
        //     //'employee_no' => 'required|min:3|unique:employee,employee_no,'.auth()->user()->employer_id,
        //     //'employee_no' => Rule::unique('employee')->where('employee_no', '=', $row['employee_no'])->where('employer_id', '=', auth()->user()->employer_id)
        //     'employee_no' => ['required',
        //         Rule::unique('employee')->where(function ($query) use ($row) {
        //             return $query
        //                 ->where('employee_no', '=', $row['employee_no'])
        //                 ->where('employer_id', '=', auth()->user()->employer_id);
        //         }),
        //         'TIN' => 'unique:employee_personal_information_preview',
        //             'SSSGSIS' => 'unique:employee_personal_information_preview',
        //             'PHIC' => 'unique:employee_personal_information_preview',
        //             'HDMF' => 'unique:employee_personal_information_preview',
        //             'NID' => 'unique:employee_personal_information_preview',
        //             'mobile_no' => 'unique:employee_personal_information_preview',
        //             'email_add' => 'unique:employee_personal_information_preview',
        //     ]
        // ])->validate();
        /**
         * @ Get Address
         * */
        $citytown_column = $row['citytown'];
        $barangay_column = $row['barangay'];
        $province_column = $row['province'];
        
        $cityTown = DB::table('refcitymun')->where('citymunDesc', 'like',  $citytown_column.'%')->first();
        $barangay = DB::table('refbrgy')->where('brgyDesc', 'like',  $barangay_column.'%')->first();
        $province = DB::table('refprovince')->where('provDesc', 'like', $province_column.'%')->first();

                        
                        

        /**
         * @
         *  Create Employee Personal Information
         * */
        //foreach ($collection as $row){
            $password = Keygen::alphanum(10)->generate();
            $UserActivation = Keygen::length(6)->numeric()->generate();
            $useractivation_id = $this->generateUserActivationId();
            $employee_id = $this->GenerateEmployeeID($table = "EmployeeEnrollment");
            $employee_info_id = $this->GenerateEmployeeID($table = "employee_personal_information_preview");
            /**
             * @//Generated ESS ID
             * */
            $initial = (new Initials)->length(3)->generate($row['lastname'] . ' ' . $row['firstname'] . ' ' . $row['middlename']);    
            $employee_ess_id = $initial . $this->generateESSID();

            /**
             * @ Create a Employee Personal Information
             * @ The Test Inputs are Temporary
             * */
            $Employee_personal_info = employee_personal_information_preview::create([
                        'id' => $employee_info_id,
                        'lastname'  => $row['lastname'],
                        'firstname' => $row['firstname'],
                        'middlename' => $row['middlename'],
                        'suffix' => $row['suffix'],
                        'TIN' => $row['tin'],
                        'SSSGSIS' => $row['sssgsis'],
                        'PHIC' => $row['phic'],
                        'HDMF' => $row['hdmf'],
                        'NID' => $row['nid'],
                        'mobile_no' => $row['mobile_no'],
                        'email_add' => $row['email_add'],
                        'birthdate' => Carbon::parse($row['birthdate'])->format('Y-m-d'),
                        'gender' => $row['gender'],
                        'civil_status' => $row['civil_status'],
                        'country' => 'Philiippines',
                        'address_unit' => $row['address_unit'],
                        'citytown' => $cityTown->citymunCode,
                        'barangay' => $barangay->id,
                        'province' => $province->provCode,
                        'zipcode' => $row['zipcode'],
                        'created_by' => auth()->user()->id,
                        'updated_by' => auth()->user()->id,
            ]);

            /**
             * @ Create Employee Enrollment
             **/
            $emppid = $Employee_personal_info->id;
            $employee = EmployeeEnrollment::create([
                    'id' => $employee_id,
                    'employee_info' => $emppid,
                    'employee_no' => $row['employee_no'],
                    'position' => $row['position'],
                    'payroll_bank' => $row['payroll_bank'],
                    'employer_id' => auth()->user()->employer_id,
                    'department' => $row['department'],
                    'enrollment_date' => Carbon::now(),
                    'employment_status' => 'Regular',
                    'payroll_schedule' => $row['payroll_schedule'],
                    'account_no' => $row['account_no'],
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
                'account_id' => $emp_id, // Change column to employee_id
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
                    ////////////////////////////////
            /**
             * 
             * Create Account User
             */
            //insert into table user
            // $user = User::create([
            //     'user_type_id' => 4,
            //     'user_type_for' => 7,
            //     'employer_id' => auth()->user()->employer_id,//Session::get("employer_id"),//$request->input('employer_id'),
            //     'employee_id' => $emp_id,
            //     'name' => $row['lastname'] . ", " . $row['firstname'] . ", " . $row['middlename'] . ", " . $row['suffix'],
            //     'username' => $employee_ess_id,
            //     'password' => Hash::make($password),
            //     'expiry_date' => Carbon::now()->addCentury(), // Default for 1 Century
            //     'enrollment_date' => Carbon::now(),
            //     'created_by' => auth()->user()->id,
            //     'updated_by' => auth()->user()->id,
            // ]);

            $UserActivation = UserActivation::create([
                'account_id' => $emp_id, // Temporary For Account ID
                'activation_code' => $UserActivation,
                'user_activation_id' => $useractivation_id,
                'expiration_date' => Carbon::now()->addCentury(), // Default for 1 Century 5,//this means 5 minutes or according to sir meo
                'created_by' => auth()->user()->id,
                'updated_by' => auth()->user()->id
            ]);
            $arrayPicture = 
            ["ESS_male1.png",
            "ESS_male2.png",
            "ESS_male3.png",
            "ESS_male4.png",
            "ESS_male5.png",
            "ESS_male6.png",
            "ESS_male7.png",
            "ESS_male8.png",
            "ESS_male9.png"
            ];
    
            $default_profile = Arr::random($arrayPicture);
    
    
            $default_profile = Arr::random($arrayPicture);
    
                    DB::table('user_picture')->insert([
                        'user_id' => $emp_id, // Temporary For Account ID
                        'employer_id' => auth()->user()->employer_id,
                        'profile_picture' =>  $default_profile,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
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

    protected function genereateEmpId(){
        return Keygen::length(6)->numeric()->generate();
    }

    /**
     * @ Generate Employee Id
     * */
    protected function GenerateEmployeeID($table){
        $employee_id = $this->genereateEmpId();

        if($table == "EmployeeEnrollment"){
            // Ensure ID does not exist
            // Generate new one if ID already exists
            while (EmployeeEnrollment::where('id', $employee_id)->count() > 0){
                $employee_id = $this->genereateEmpId();
            }
        }
        if($table == "employee_personal_information_preview"){
            // Ensure ID does not exist
            // Generate new one if ID already exists
            while (employee_personal_information_preview::where('id', $employee_id)->count() > 0){
                $employee_id = $this->genereateEmpId();
            }
        }
        return $employee_id;
    }


     /**
     * @return array
     */
    public function rules(): array
    {
        return [
            // 'employee_no' => 'required',
            // '*.employee_no' => 'required',

            'lastname' => 'required|string',
            '*.lastname' => 'required|string',

            'firstname' => 'required|string',
            '*.firstname' => 'required|string',

            'middlename' => 'required|string',
            '*.middlename' => 'required|string',

            'tin' => 'required|string|unique:employee_personal_information_preview',
            '*.tin' => 'required|unique:employee_personal_information_preview',

            'sssgsis' => 'required|unique:employee_personal_information_preview',
            '*.sssgsis' => 'required|unique:employee_personal_information_preview',

            'phic' => 'required|unique:employee_personal_information_preview',
            '*.phic' => 'required|unique:employee_personal_information_preview',

            'hdmf' => 'required|unique:employee_personal_information_preview',
            '*.hdmf' => 'required|unique:employee_personal_information_preview',

            'nid' => 'required|unique:employee_personal_information_preview',
            '*.nid' => 'required|unique:employee_personal_information_preview',
            
            'mobile_no' => 'required|unique:employee_personal_information_preview',
            '*.mobile_no' => 'required|unique:employee_personal_information_preview',
            
            'email_add' => 'required|unique:employee_personal_information_preview',
            '*.email_add' => 'required|unique:employee_personal_information_preview',

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
    // public function messages()
    // {
    //     return [
    //         'required' => 'The :attribute field is required.'
    //     ];
    // }

    /**
     * @ Custom Validation For Attributes
     * 
     * @return array
     */
    public function customValidationAttributes()
    {
        return [
            'lastname' => 'Last Name',
            'firstname' => 'First Name',
            'middlename' => 'Middle Name',
            'suffix' => 'Suffix',
            'tin' => 'Tin',
            'sssgsis' => 'SSS/GSIS',
            'phic' => 'Phic',
            'hdmf' => 'Hdmf',
            'nid' => 'Nid',
            'mobile_no' => 'Mobile Number',
            'email_add' => 'Email Address',
            'birthdate' => 'Birth Date',
            'gender' => 'Gender',
            'civil_status' => 'Civil Status',
            'country' => 'Country',
            'address_unit' => 'Address Unit',
            'city_town' => 'City Town',
            'barangay' => 'Barangay',
            'province' => 'Province',
            'zipcode' => 'Zipcode',
        ];
    }


    /**
     * @ Custom Validation Message
     * 
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'lastname' => 'Custom message for :attribute.',
            'firstname' => 'Custom message for :attribute.',
            'middlename' => 'Custom message for :attribute.',
            'suffix' => 'Custom message for :attribute.',
            'tin' => 'Custom message for :attribute.',
            'sssgsis' => 'Custom message for :attribute.',
            'phic' => 'Custom message for :attribute.',
            'hdmf' => 'Custom message for :attribute.',
            'nid' => 'Custom message for :attribute.',
            'mobile_no' => 'Custom message for :attribute.',
            'email_add' => 'Custom message for :attribute.',
            'birthdate' => 'Custom message for :attribute.',
            'gender' => 'Custom message for :attribute.',
            'civil_status' => 'Custom message for :attribute.',
            'country' => 'Custom message for :attribute.',
            'address_unit' => 'Custom message for :attribute.',
            'city_town' => 'Custom message for :attribute.',
            'barangay' => 'Custom message for :attribute.',
            'province' => 'Custom message for :attribute.',
            'zipcode' => 'Custom message for :attribute.',
        ];
    }
    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        //$this->failures = array_merge($this->failures, $failures);
        // Handle the failures how you'd like.
        foreach ($failures as $failure) {
            $failure->row(); // row that went wrong
            $failure->attribute(); // either heading key (if using heading row concern) or column index
            $failure->errors(); // Actual error messages from Laravel validator
            $failure->values(); // The values of the row that has failed.
        }
        
    }

    public function failures()
    {
        return $this->failures;
    }


    /**
     * @ Batch Insert
     * */
    public function batchSize(): int
    {
        return 1000;
    }

    /*This unique Activation ID will serves as mask to the users id*/
    protected function generateUserActivationId() {
        $user_activation_id = Keygen::length(11)->alphanum()->generate();

        return $user_activation_id;
    }
}
