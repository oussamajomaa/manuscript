<?php

namespace App\Form;

use App\Entity\Catalogue;
use App\Entity\PrimaryCreator;
use App\Entity\SecondaryCreator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
class CatalogueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('identifier')
            ->add('repository')
            ->add('shelfmark')
            ->add('title')
            ->add('link_archive_catalogue')
            ->add('digital_resource')
            ->add('autograph', ChoiceType::class, [
                'placeholder' => 'Choose an option',
                'required' => false,
                'choices' => [
                    'Yes' => 'yes',
                    'No'  => 'no',
                    'Partly' => 'partly'
                ]
            ])

            ->add('incipit_diplomatic', CKEditorType::class)
            ->add('incipit_modernised', CKEditorType::class)
            ->add('text_language')
            ->add('brief_summary', CKEditorType::class)
            ->add('detailed_summary', CKEditorType::class)
            ->add('keywords')
            ->add('genre')
            ->add('status')
            ->add('inclusions', CKEditorType::class)
            ->add('bibliography', CKEditorType::class)
            ->add('material')
            ->add('extent')
            ->add('format', ChoiceType::class, [
                'placeholder' => 'Choose an format',
                'required' => false,
                'choices' => [
                    'Folio'=>'folio',
                    '4o'=>'4o',
                    '8vo'=>'8vo',
                    '12mo'=>'12mo',
                    '16mo'=>'16mo',
                    '32mo'=>'32mo',
                    '64mo'=>'64mo',
                    'Half Sheet'=>'half sheet',
                    'Quarter Sheet'=>'quarter sheet',
                    'Eighth Sheet'=>'eighth sheet',
                    'Various'=>'Various',
                ]
            ])
            ->add('dimensions')
            ->add('watermark', CKEditorType::class)
            ->add('additional_comments', CKEditorType::class)
            ->add('hands', ChoiceType::class, array(
                'placeholder' => 'Choose an option',
                'required' => false,
                'choices' => array(
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4',
                    '5'=>'5'
            )))
            ->add('additions')
            ->add('decorations')
            ->add('date')
            ->add('origin')
            ->add('ownership')
            ->add('provenance', CKEditorType::class)
            ->add('link_digital_voltaire')
            ->add('ocv_volume')
            ->add('ocv_chapter')
            ->add('text_chapter')
            ->add('text_reference')
            ->add('manuscript_details')
            ->add('primary_creator', EntityType::class, [
                'class'     => PrimaryCreator::class,
                'multiple'  => true,
                'required'  => false,
                'by_reference' => false,

                'attr'      => [
                    'class' => 'select-primary'
                ]

            ])
            ->add('secondary_creator', EntityType::class, [
                'class'     => SecondaryCreator::class,
                'multiple'  => true,
                'required'  => false,
                'by_reference' => false,

                'attr'      => [
                    'class' => 'select-primary'
                ]

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Catalogue::class,
        ]);
    }
}
