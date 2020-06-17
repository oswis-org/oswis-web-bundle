<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity\MediaObject;

use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractFile;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Publicity;
use OswisOrg\OswisCoreBundle\Exceptions\InvalidTypeException;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\EntityPublicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TypeTrait;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @Doctrine\ORM\Mapping\Entity()
 * @Doctrine\ORM\Mapping\Table(name="web_file")
 * @ApiPlatform\Core\Annotation\ApiResource(
 *     collectionOperations={
 *         "get"={
 *           "access_control"="is_granted('ROLE_MANAGER')",
 *           "normalization_context"={"groups"={"web_actualities_get"}},
 *         },
 *         "post"={
 *           "method"="POST",
 *           "path"="/web_file",
 *           "controller"=OswisOrg\OswisWebBundle\Controller\MediaObject\CreateWebFileAction::class,
 *           "defaults"={"_api_receive"=false},
 *           "access_control"="is_granted('ROLE_MANAGER')",
 *         },
 *     }
 * )
 * @Vich\UploaderBundle\Mapping\Annotation\Uploadable()
 * @Doctrine\ORM\Mapping\Cache(usage="NONSTRICT_READ_WRITE", region="web_web_file")
 */
class WebFile extends AbstractFile
{
    use BasicTrait;
    use TypeTrait;
    use PriorityTrait;
    use EntityPublicTrait;

    /**
     * @Symfony\Component\Validator\Constraints\NotNull()
     * @Vich\UploaderBundle\Mapping\Annotation\UploadableField(
     *     mapping="web_file", fileNameProperty="contentName", mimeType="contentMimeType"
     * )
     */
    public ?File $file = null;

    /**
     * @Doctrine\ORM\Mapping\ManyToOne(
     *     targetEntity="OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage", inversedBy="files"
     * )
     * @Doctrine\ORM\Mapping\JoinColumn(name="abstract_web_page_id", referencedColumnName="id")
     */
    protected ?AbstractWebPage $webPage = null;

    /**
     * @param File|null      $file
     * @param string|null    $type
     * @param int|null       $priority
     * @param Publicity|null $publicity
     *
     * @throws InvalidTypeException
     */
    public function __construct(?File $file = null, ?string $type = null, ?int $priority = null, ?Publicity $publicity = null)
    {
        $this->setFile($file);
        $this->setType($type);
        $this->setPriority($priority);
        $this->setFieldsFromPublicity($publicity);
    }

    public function getWebPage(): ?AbstractWebPage
    {
        return $this->webPage;
    }

    public function setWebPage(?AbstractWebPage $webPage): void
    {
        if (null !== $this->webPage && $webPage !== $this->webPage) {
            $this->webPage->removeFile($this);
        }
        $this->webPage = $webPage;
        if (null !== $webPage && $this->webPage !== $webPage) {
            $webPage->addFile($this);
        }
    }
}
