<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faker extends MY_Controller
{
    public $faker;

	public function __construct()
	{
        parent::__construct();
        $this->faker = Faker\Factory::create();
    }

    public function dentist($limit = 10)
    {
        $dentists = [];
        for ($i = 0; $i < $limit; $i++) {
            $raw_password = $this->faker->password;
            $dentist = [
                'username' => $this->faker->username,
                'firstname' => $this->faker->firstName,
                'lastname' => $this->faker->lastName,
                'password' => password_hash($raw_password, PASSWORD_BCRYPT),
                'raw_password' => $raw_password,
                'pin' => $this->faker->randomNumber(4, TRUE),
                'status' => $this->faker->numberBetween(0,1)
            ];
            
            db_timestamp('created', $dentist);
            
            $dentists[] = $dentist;
        }
        
        $this->json->_display([
            'context' => [
                'data' => $dentists,
                'status' => $this->db->insert_batch('dentist', $dentists) ? 1 : 0
            ]
        ]);
    }

    public function patient($limit = 10)
    {
        $dentist_ids = $this->dentist->select(['id'])->get_all();
        $patients = [];
        for ($i = 0; $i < $limit; $i++) {
            $gender = $this->faker->randomElement(['male','female','others']);
            $patient = [
                'dentist_id' => $dentist_ids[rand(0, count($dentist_ids) - 1)]->id,
                'firstname' => $this->faker->firstName($gender),
                'middlename' => $this->faker->lastName,
                'lastname' => $this->faker->lastName,
                'age' => $this->faker->numberBetween(1,100),
                'gender' => $gender,
                'religion' => $this->faker->word,
                'nationality' => $this->faker->word,
                'address' => $this->faker->buildingNumber,
                'address_1' => $this->faker->secondaryAddress,
                'address_2' => $this->faker->streetName,
                'address_3' => $this->faker->state,
                'address_4' => $this->faker->city,
                'address_5' => $this->faker->country,
                'occupation' => $this->faker->word,
                'dental_insurance' => $this->faker->word,
                'effective_date' => $this->faker->dateTimeBetween('now', '+1 months')->format('Y-m-d'),
                'guardian_firstname' => $this->faker->firstName,
                'guardian_middlename' => $this->faker->lastName,
                'guardian_lastname' => $this->faker->lastName,
                'guardian_occupation' => $this->faker->word,
                'consultation_reason' => $this->faker->realText($this->faker->numberBetween(10,20)),
                'home_number' => $this->faker->phoneNumber,
                'office_number' => $this->faker->phoneNumber,
                'fax_number' => $this->faker->phoneNumber,
                'mobile_number' => $this->faker->e164PhoneNumber,
                'email_address' => $this->faker->email,
                // 'signature' => $this->faker->luh,
                'consent_agreement' => 1, // $this->faker->numberBetween(0, 1),
                // 'picture' => $this->faker->luh,
            ];
            
            db_timestamp('created', $patient);
            
            $patients[] = $patient;
        }
        
        $this->json->_display([
            'context' => [
                'data' => $patients,
                // 'status' => 1
                'status' => $this->db->insert_batch('patient', $patients) ? 1 : 0
            ]
        ]);
    }
}