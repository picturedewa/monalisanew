<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';

class Document extends API_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('api/LoginModel');
		 $this->load->model('api/BarModel');
    }


    public function belajar(){
    	header("Access-Control-Allow-Origin: *");

			// API Configuration
			$this->_apiConfig([

					'methods' => ['POST']
				]);

    }

    public function apilimit(){

    	/**
		 * API Limit
		 * ----------------------------------
		 * @param: {int} API limit Number
		 * @param: {string} API limit Type (IP)
		 * @param: {int} API limit Time [minute]
		 */

		$this->_APIConfig([
		    // number limit, type limit, time limit (last minute)
		    'limit' => [10, 'ip', 5],  // 10 kali akses udah ngak bisa  lagi 

		     // number limit, type limit, everyday
   			 'limit' => [10, 'ip', 'everyday']  // 

		]);


    }

    /*
		Apikey without database
    */

	public function apikey(){

		/**
		 * Use API Key without Database
		 * ---------------------------------------------------------
		 * @param: {string} Types
		 * @param: {string} API Key
		 */

		$this->_APIConfig([
			'methods' => ['POST'],
		 //    'key' => ['header', '23456789']

		    //api key with database - databasename ada di file api.php
			'key' => ['header'],
			'data'=>[
				'islogin'=>false,
			]		    
		]);

		$data=array('status' =>'OK',
					'data'=>[
						'user_id'=>'dewa',
					]
			);

		//return data 
		$this->api_return($data, '200');

	}

	public function masuk(){
		// API Configuration
			// $this->_apiConfig([

			// 		'methods' => ['POST'],
			// 		'requireAuthorization' => true
			// 	]);

		header("Access-Control-Allow-Origin: *");

		    // API Configuration
		    $this->_apiConfig([
		        'methods' => ['POST'],
		    ]);

		    // you user authentication code will go here, you can compare the user with the database or whatever
		    $payload = [
		        'id' => "Your User's ID",
		        'other' => "Some other data"
		    ];

		    // Load Authorization Library or Load in autoload config file
		    $this->load->library('authorization_token');

		    // generte a token
		    $token = $this->authorization_token->generateToken($payload);

		    // return data
		    $this->api_return(
		        [
		            'status' => true,
		            "result" => [
		                'token' => $token,
		            ],
		            
		        ],
		    200);

	}

			/**
			 * view method
			 *
			 * @link [api/user/view]
			 * @method POST
			 * @return Response|void
			 */
			public function view()
			{
			    header("Access-Control-Allow-Origin: *");

			    // API Configuration [Return Array: User Token Data]
			    $user_data = $this->_apiConfig([
			        'methods' => ['POST'],
			        'requireAuthorization' => true,
			    ]);

			    // return data
			    $this->api_return(
			        [
			            'status' => true,
			            "result" => [
			                'user_data' => $user_data['token_data']
			            ],
			        ],
			    200);
			}