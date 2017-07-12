<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Http\Messages\Session;

class Middle extends Controller
{

	/**
	 *
	 * @var Session
	 */
	protected $session = null;

	public function __construct()
	{
		Session::start();
		$this->session = new Session('auth');
	}

	public function validate()
	{
		//return $this->session->get('data', false);
	}

	public function getSession()
	{
		return $this->session;
	}

}
