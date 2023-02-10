<?php

namespace Rras3k\Sebconsole\Lib;

use Illuminate\Support\Facades\Auth;



class RapportSimple
{
	public const TYPE_LIGNE_SIMPLE = 1;
	public const TYPE_LIGNE_H1 = 2;
	public const TYPE_LIGNE_H2 = 3;

	public const BADGE_TYPE_ERROR = 0;
	public const BADGE_TYPE_OK = 1;

	private $lignes = [];
	private $titre = "";
	public  function test()
	{
		return "ppppp";
	}

	public function __construct()
	{
	}
	public function add($ligne, $ligneType, $badgeType = null, $badgeLibelle = null)
	{
		$this->lignes[] = ['ligne' => $ligne, 'badgeType' => $badgeType, 'message_badge' => $badgeLibelle, 'ligneType' => $ligneType];
	}
	public function addTitle($titre)
	{
		$this->titre = $titre;
	}
	public function getTitre()
	{
		return $this->titre;
	}

	public function get()
	{
		return $this->lignes;
	}
	public function getHtml()
	{
		$ret = "";

		foreach ($this->lignes as  $value) {
			$finLigne = "";

			// Type de ligne normal, H1, H2
			switch ($value['ligneType']) {
				case self::TYPE_LIGNE_H1:
					$ret .= "<h1>";
					$finLigne = "</h1>";
					break;
				case self::TYPE_LIGNE_H2:
					$ret .= "<h2>";
					$finLigne = "</h2>";
					break;
			}

			// Texte 
			$ret .= $value['ligne'];
			// $ret .=' badge='.$value['badgeType'].' ';
			$ret .= $finLigne;

			// Badge
			if ($value['badgeType'] !== null) {
				switch ($value['badgeType']) {
					case self::BADGE_TYPE_ERROR:
						$message = $value['message_badge'] ? $value['message_badge'] : "Erreur";
						$ret .= ' <span class="badge bg-danger">' . $message . '</span>';
						break;
					case self::BADGE_TYPE_OK:
						$message = $value['message_badge'] ? $value['message_badge'] : "Ok";
						$ret .= ' <span class="badge bg-success">' . $message . '</span>';
						break;
				}
			}
			if ($value['ligneType'] == self::TYPE_LIGNE_SIMPLE) {
				$ret .= "<br/>";
			}
		}
		return $ret;
	}
}
