<?php

namespace OswisOrg\OswisWebBundle\Entity\MediaObject;

use ApiPlatform\Core\Annotation\ApiResource;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractImage;
use OswisOrg\OswisWebBundle\Controller\MediaObject\CreateWebImageAction;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_image")
 * @ApiResource(iri="http://schema.org/ImageObject", collectionOperations={
 *     "get"={
 *       "access_control"="is_granted('ROLE_MANAGER')",
 *       "normalization_context"={"groups"={"web_actualities_get"}},
 *     },
 *     "post"={
 *         "method"="POST",
 *         "path"="/web_image",
 *         "controller"=CreateWebImageAction::class,
 *         "defaults"={"_api_receive"=false},
 *         "access_control"="is_granted('ROLE_MANAGER')",
 *     },
 * })
 * @Vich\UploaderBundle\Mapping\Annotation\Uploadable()
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_web_page")
 */
class WebImage extends AbstractImage
{
    /**
     * @Symfony\Component\Validator\Constraints\NotNull()
     * @Vich\UploaderBundle\Mapping\Annotation\UploadableField(
     *     mapping="web_image",
     *     fileNameProperty="contentUrl",
     *     dimensions={"contentDimensionsWidth", "contentDimensionsHeight"},
     *     mimeType="contentDimensionsMimeType"
     * )
     */
    public ?File $file = null;
}
