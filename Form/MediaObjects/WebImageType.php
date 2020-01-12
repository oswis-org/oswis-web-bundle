<?php
/**
 * @noinspection PhpUnused
 */

namespace Zakjakub\OswisWebBundle\Form\MediaObjects;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Zakjakub\OswisCoreBundle\Utils\FileUtils;
use Zakjakub\OswisWebBundle\Entity\MediaObject\WebImage;

final class WebImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $maxSize = FileUtils::humanReadableFileUploadMaxSize();
        $maxSize = $maxSize ? ' (max. '.$maxSize.')' : '';
        $builder->add(
            'file',
            VichImageType::class,
            [
                'label'          => false,
                'download_label' => true,
                'download_uri'   => true,
                'required'       => false,
                'attr'           => [
                    'placeholder' => 'Kliknutím vyberte soubor'.$maxSize.'...',
                ],
            ]
        );
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class'      => WebImage::class,
                'csrf_protection' => false,
            ]
        );
    }

    public function getBlockPrefix(): string
    {
        return 'web_web_image';
    }
}
