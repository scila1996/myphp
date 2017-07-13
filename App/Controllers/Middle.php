<?php

namespace App\Controllers;

use System\Core\Controller;
use App\Models\Session;

class Middle extends Controller
{

	/**
	 *
	 * @var Session 
	 */
	protected $session = null;

	public function __construct()
	{
		$this->session = new Session();
	}

	public function requireLogin()
	{

		if (!$this->isLogin())
		{
			header('Location: /login');
			return true;
		}
	}

	public function validLogin()
	{
		if ($this->isLogin())
		{
			header('Location: /');
			return true;
		}
	}

	public function isLogin()
	{
		return $this->session->has('login');
	}

}
