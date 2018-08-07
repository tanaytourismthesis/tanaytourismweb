<?php
if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Users extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
	}

  public function index(){
    $data = [
      'user_info' => $this->session->userdata('user_info')
    ];

    $this->template->build_template(
      'User Management', //Page Title
      array( // Views
        array(
          'view' => 'users',
          'data' => $data
        )
      ),
      array( // JavaScript Files
        "assets/js/jquery.js",
        "assets/js/user_management.js"
      ),
      array( // CSS Files

      ),
      array( // Meta Tags

      ),
      'backend' // template page
    );
  }

  public function logout() {
    if ($this->session->has_userdata('user_info')) {
      $id = $this->session->userdata('user_info')['user_id'];
      $result = $this->user_model->update_userlogstatus($id, TRUE);

      if ($result) {
        $this->session->unset_userdata('user_info');
      }
    }
    redirect(base_url() . 'admin');
  }

  public function load_user(){

    $data['response'] = FALSE;

    try {
      $result = $this->user_model->load_user();

      if (!empty($result)) {
        $data['data'] = $result;
        $data['response'] = TRUE;
      }

    } catch (Exception $e) {
      $data['message'] = $e->getMessage();
    }

    header( 'Content-Type: application/x-json' );
    echo json_encode( $data );
  }
}
?>
