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

	// -------------------------------------------------------- Menu page -------------------------------------------------------------
	public function menuPage_get()
	{
		return isset($this->entites[$this->entree]['menu_page']) ? $this->entites[$this->entree]['menu_page'] : null;
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


	// -------------------------------------------------------- Form -------------------------------------------------------------

	/**
	 *
	 *
	 * @param
	 * @return
	 */
	public function form_isCreate()
	{
		return isset($this->entites[$this->entree]['form']['isCreate']) ? $this->entites[$this->entree]['form']['isCreate'] : false;
	}

	/**
	 *
	 *
	 * @param
	 * @return
	 */
	public function form_getData($champ = null)
	{
		if ($champ)
			return isset($this->entites[$this->entree]['form']['datas'][$champ]) ? $this->entites[$this->entree]['form']['datas'][$champ] : '';
		else
			return isset($this->entites[$this->entree]['form']['datas']) ? $this->entites[$this->entree]['form']['datas'] : '';
	}

	/**
	 *
	 *
	 * @param
	 * @return
	 */
	public function form_getHiddenValues()
	{
		return (isset($this->entites[$this->entree]['form']['hiddens'])) ? $this->entites[$this->entree]['form']['hiddens'] : null;
	}


	// -------------------------------------------------------- Nav -------------------------------------------------------------

	/**
	 *
	 *
	 * @param
	 * @return
	 */
	public function nav_getPage()
	{
		return (isset($this->entites['page']['nav']['breadcombre'])) ? $this->entites['page']['nav']['breadcombre'] : null;
	}

	// -------------------------------------------------------- Listes -------------------------------------------------------------

	/**
	 *
	 *
	 * @param
	 * @return
	 */
	public function data_getList($listNom)
	{
		return isset($this->entites[$this->entree]['lists'][$listNom]) ? $this->entites[$this->entree]['lists'][$listNom] : null;
	}

	// -------------------------------------------------------- Liste -------------------------------------------------------------

}
