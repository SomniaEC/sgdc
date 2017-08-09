<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DenunciaType extends AbstractType {
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder->add ( 'fechaRegistro' )->add ( 'hechos' )->add ( 'derechos' )->add ( 'junta' );
		$builder->add ( 'vulneradosDomicilio', CollectionType::class, array (
				'entry_type' => VulneradoDomicilioTodoType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'attr' => array ('row_class' => 'vulnerados_domicilio')
		) );
		$builder->add ( 'personasDomicilio', CollectionType::class, array (
				'entry_type' => PersonaDomicilioTodoType::class,
				'allow_add' => true,
				'allow_delete' => true,
				'attr' => array ('row_class' => 'personas_domicilio')
		) );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults ( array (
				'data_class' => 'AppBundle\Entity\Denuncia' 
		) );
	}
	
	/**
	 *
	 * {@inheritdoc}
	 *
	 */
	public function getBlockPrefix() {
		return 'appbundle_denuncia';
	}
}
