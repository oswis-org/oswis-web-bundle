<?php
/**
 * @noinspection MethodShouldBeFinalInspection
 */

namespace OswisOrg\OswisWebBundle\Entity\MediaObject;

use Doctrine\ORM\Mapping\Cache;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Mapping\Annotation\Uploadable;
use OswisOrg\OswisCoreBundle\Entity\AbstractClass\AbstractFile;
use OswisOrg\OswisCoreBundle\Entity\NonPersistent\Publicity;
use OswisOrg\OswisCoreBundle\Exceptions\InvalidTypeException;
use OswisOrg\OswisCoreBundle\Traits\Common\BasicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\EntityPublicTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\PriorityTrait;
use OswisOrg\OswisCoreBundle\Traits\Common\TypeTrait;
use OswisOrg\OswisWebBundle\Entity\AbstractClass\AbstractWebPage;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ApiPlatform\Core\Annotation\ApiResource(
 *     collectionOperations={
 *         "get"={
 *           "access_control"="is_granted('ROLE_MANAGER')",
 *           "normalization_context"={"groups"={"web_actualities_get"}}
 *         },
 *         "post"={
 *           "method"="POST",
 *           "path"="/web_file",
 *           "controller"=OswisOrg\OswisWebBundle\Controller\MediaObject\CreateWebFileAction::class,
 *           "defaults"={"_api_receive"=false},
 *           "access_control"="is_granted('ROLE_MANAGER')"
 *         }
 *     }
 * )
 */
#[Entity]
#[Table(name: 'web_file')]
#[Cache(usage: 'NONSTRICT_READ_WRITE', region: 'web_web_file')]
#[Uploadable]
class WebFile extends AbstractFile
{
    use BasicTrait;
    use TypeTrait;
    use PriorityTrait;
    use EntityPublicTrait;

    #[NotNull]
    #[UploadableField(mapping: 'web_file', fileNameProperty: 'contentName', mimeType: 'contentMimeType')]
    public ?File $file = null;

    #[ManyToOne(targetEntity: AbstractWebPage::class, inversedBy: 'files')]
    #[JoinColumn(name: 'abstract_web_page_id', referencedColumnName: 'id')]
    protected ?AbstractWebPage $webPage = null;

    /**
     * @param  File|null  $file
     * @param  string|null  $type
     * @param  int|null  $priority
     * @param  Publicity|null  $publicity
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
        $webPage?->addFile($this);
    }
}
