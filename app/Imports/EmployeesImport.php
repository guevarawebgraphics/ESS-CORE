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

class EmployeesImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts
{
    use Importable, SkipsFailures;
    /**
      * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)  
    {

        /**
         * @
         *  Create Employee Personal Information
         * */
        //foreach ($collection as $row){
            $password = Keygen::alphanum(10)->generate();
            $UserActivation = Keygen::length(6)->numeric()->generate();
            $useractivation_id = $this->generateUserActivationId();
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
                        'gender' => 'Male',
                        'civil_status' => 'Single',
                        'country' => 'Philiippines',
                        'address_unit' => '1',
                        'citytown' => '031419',
                        'barangay' => '6191',
                        'province' => '0314',
                        'zipcode' => '2245',
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

         /*Email Template*/
         $mail_template = DB::table('notification')
                //->where('employer_id', auth()->user()->id)
                ->where('id', '31')
                ->where('notification_type', 1)
                ->select('notification_message')
                ->first();


        $activation_link = "http://127.0.0.1:8000/Account/Activation/".$useractivation_id;


        // Replace All The String in the Notification Message
        $search = ["name", "username", "mobile", "url", "password"];
        $replace = [$employee_ess_id, $employee_ess_id, $row['mobile_no'], "<a href=".$activation_link.">Click Here</a>", $password];                
        $template_result = str_replace($search, $replace, $mail_template->notification_message); 
                
        $email = $row['email_add'];
        /*Send Mail */
        $data = array('username' => $employee_ess_id, "password" => $password, "template" => $template_result);

        Mail::send('Email.mail', $data, function($message) use($mail_template, $email){
            $message->to($email)
                ->subject("ESS Successfully Registered ");
            $message->from('esssample@gmail.com', "ESS");
        });

        //$date = new DateTime();
        $date_unitl = date("Y-m-d H:i:s", strtotime('+5 minutes'));

        $UserActivation = UserActivation::create([
            'account_id' => $user->id,
            'activation_code' => $UserActivation,
            'user_activation_id' => $useractivation_id,
            'expiration_date' => Carbon::now()->addCentury(), // Default for 1 Century 5,//this means 5 minutes or according to sir meo
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id
        ]);
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
        $this->failures = array_merge($this->failures, $failures);
        // Handle the failures how you'd like.
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
