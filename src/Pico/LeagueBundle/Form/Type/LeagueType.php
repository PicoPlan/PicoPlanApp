<?php
namespace Pico\LeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LeagueType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add("nom")
			->add("description")
			->add("sport", "entity", array(
				"class" => "PicoLeagueBundle:Sport",
				"property" => "nom"))
			->add("save", 'submit');
	}

	public function getName(){
		return "league";
	}
}