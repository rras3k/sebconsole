<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class SbModel extends Model
{
	use HasFactory;

	abstract public static function getStrName(); // retourne le champ de la désignation lisable de l'enregistrement
	abstract public static function getLabel(); // retourne le libelle de la table
	abstract public static function getList(); // retourne la liste des enregistrements id, ... as label


}
