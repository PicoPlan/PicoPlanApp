<?php
namespace Pico\LeagueBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class SportType extends AbstractType {

	public function buildForm(FormBuilderInterface $builder, array $options){
		$builder
			->add("nom")
			->add("description")
			->add("save", "submit");
	}

	public function getName(){
		return "sport";
	}
}