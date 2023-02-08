<?php

namespace Rras3k\Sebconsole\Lib;

use Illuminate\Support\Facades\Auth;



class RapportSimple
{
	public const TYPE_LIGNE_SIMPLE = 1;
	// const TYPE_LIGNE_SIMPLE = 1;

	private $lignes = [];
	public  function test()
	{
		return "ppppp";
	}

	public function __construct()
	{
	}
	public function add($ligne, $badgeType, $ligneType)
	{
		$this->lignes[] = ['ligne' => $ligne, 'badgeType' => $badgeType, 'ligneType' => $ligneType];
	}
	public function get()
	{
		return $this->lignes;
	}
	public function getHtml()
	{
		$ret = "";
		$finLigne = "";
		foreach ($this->lignes as  $value) {
			$finLigne = "";
			switch ($value['ligneType']) {
				case 2:
					$ret = "<h1>";
					$finLigne = "</h1>";
					break;
				default:
					break;
			}

			switch ($value['badgeType']) {
				case 2:
					$ret .= '<span class="badge bg-' . $value['badgeType'] . '">';
					$finLigne = "</h1>";
					break;
				default:
					break;
			}

			$ret.= $value['ligne'];
			if ($value['badgeType']) {
				$ret .='</span>';
			}
			$ret .= $finLigne;
			
		}
		return $ret;
	}
}
