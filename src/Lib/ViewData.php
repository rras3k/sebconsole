<?php

namespace Rras3k\Sebconsole\Lib;

class ViewData
{
	private $entree = 'main';
	private $entites = [];

	/**
	 *
	 * @param
	 * @return
	 */
	public function __construct()
	{
	}

	/**
	 *
	 * @param
	 * @return
	 */
	public function setEntree($entree)
	{
		$this->entree = $entree;
	}

	/**
	 *
	 * @param
	 * @return
	 */
	public function setEntites($entites)
	{
		$this->entites = $entites;
	}

	// -------------------------------------------------------- Page -------------------------------------------------------------

	/**
	 *
	 * @param
	 * @return
	 */
	public function page_getTitre()
	{
		return $this->entites[$this->entree]['titre'];
	}
}
