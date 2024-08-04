<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: CatalogueRepository::class)]
class Catalogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $identifier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $repository = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $shelfmark = null;

    #[ORM\ManyToMany(targetEntity: PrimaryCreator::class, inversedBy: 'catalogues')]
    private Collection $primary_creator;

    #[ORM\ManyToMany(targetEntity: SecondaryCreator::class, inversedBy: 'catalogues')]
    private Collection $secondary_creator;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $digital_resource = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $autograph = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $incipit_diplomatic = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $incipit_modernised = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $text_language = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $brief_summary = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $detailed_summary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $keywords = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $genre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $inclusions = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $bibliography = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $material = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $extent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $format = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensions = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $watermark = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additional_comments = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hands = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $additions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $decorations = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $origin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ownership = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $provenance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ocv_volume = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ocv_chapter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $text_chapter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $text_reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $manuscript_details = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link_archive_catalogue = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link_digital_voltaire = null;

    public function __construct()
    {
        $this->primary_creator = new ArrayCollection();
        $this->secondary_creator = new ArrayCollection();
    }

  
   
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function getRepository(): ?string
    {
        return $this->repository;
    }

    public function setRepository(?string $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getShelfmark(): ?string
    {
        return $this->shelfmark;
    }

    public function setShelfmark(?string $shelfmark): self
    {
        $this->shelfmark = $shelfmark;

        return $this;
    }

    /**
     * @return Collection<int, PrimaryCreator>
     */
    public function getPrimaryCreator(): Collection
    {
        return $this->primary_creator;
    }

    public function addPrimaryCreator(PrimaryCreator $primaryCreator): self
    {
        if (!$this->primary_creator->contains($primaryCreator)) {
            $this->primary_creator->add($primaryCreator);
        }

        return $this;
    }

    public function removePrimaryCreator(PrimaryCreator $primaryCreator): self
    {
        $this->primary_creator->removeElement($primaryCreator);

        return $this;
    }

    /**
     * @return Collection<int, SecondaryCreator>
     */
    public function getSecondaryCreator(): Collection
    {
        return $this->secondary_creator;
    }

    public function addSecondaryCreator(SecondaryCreator $secondaryCreator): self
    {
        if (!$this->secondary_creator->contains($secondaryCreator)) {
            $this->secondary_creator->add($secondaryCreator);
        }

        return $this;
    }

    public function removeSecondaryCreator(SecondaryCreator $secondaryCreator): self
    {
        $this->secondary_creator->removeElement($secondaryCreator);

        return $this;
    }

    public function __toString()
    {
        return $this->identifier;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDigitalResource(): ?string
    {
        return $this->digital_resource;
    }

    public function setDigitalResource(string $digital_resource): self
    {
        $this->digital_resource = $digital_resource;

        return $this;
    }

    public function getAutograph(): ?string
    {
        return $this->autograph;
    }

    public function setAutograph(string $autograph): self
    {
        $this->autograph = $autograph;

        return $this;
    }

    public function getIncipitDiplomatic(): ?string
    {
        return $this->incipit_diplomatic;
    }

    public function setIncipitDiplomatic(string $incipit_diplomatic): self
    {
        $this->incipit_diplomatic = $incipit_diplomatic;

        return $this;
    }

    public function getIncipitModernised(): ?string
    {
        return $this->incipit_modernised;
    }

    public function setIncipitModernised(string $incipit_modernised): self
    {
        $this->incipit_modernised = $incipit_modernised;

        return $this;
    }

    public function getTextLanguage(): ?string
    {
        return $this->text_language;
    }

    public function setTextLanguage(string $text_language): self
    {
        $this->text_language = $text_language;

        return $this;
    }

    public function getBriefSummary(): ?string
    {
        return $this->brief_summary;
    }

    public function setBriefSummary(?string $brief_summary): self
    {
        $this->brief_summary = $brief_summary;

        return $this;
    }

    public function getDetailedSummary(): ?string
    {
        return $this->detailed_summary;
    }

    public function setDetailedSummary(?string $detailed_summary): self
    {
        $this->detailed_summary = $detailed_summary;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(?string $keywords): self
    {
        $this->keywords = $keywords;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(?string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getInclusions(): ?string
    {
        return $this->inclusions;
    }

    public function setInclusions(?string $inclusions): self
    {
        $this->inclusions = $inclusions;

        return $this;
    }

    public function getBibliography(): ?string
    {
        return $this->bibliography;
    }

    public function setBibliography(?string $bibliography): self
    {
        $this->bibliography = $bibliography;

        return $this;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function setMaterial(?string $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getExtent(): ?string
    {
        return $this->extent;
    }

    public function setExtent(?string $extent): self
    {
        $this->extent = $extent;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimensions;
    }

    public function setDimensions(?string $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }

    public function getWatermark(): ?string
    {
        return $this->watermark;
    }

    public function setWatermark(?string $watermark): self
    {
        $this->watermark = $watermark;

        return $this;
    }

    public function getAdditionalComments(): ?string
    {
        return $this->additional_comments;
    }

    public function setAdditionalComments(?string $additional_comments): self
    {
        $this->additional_comments = $additional_comments;

        return $this;
    }

    public function getHands(): ?string
    {
        return $this->hands;
    }

    public function setHands(?string $hands): self
    {
        $this->hands = $hands;

        return $this;
    }

    public function getAdditions(): ?string
    {
        return $this->additions;
    }

    public function setAdditions(?string $additions): self
    {
        $this->additions = $additions;

        return $this;
    }

    public function getDecorations(): ?string
    {
        return $this->decorations;
    }

    public function setDecorations(?string $decorations): self
    {
        $this->decorations = $decorations;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getOwnership(): ?string
    {
        return $this->ownership;
    }

    public function setOwnership(?string $ownership): self
    {
        $this->ownership = $ownership;

        return $this;
    }

    public function getProvenance(): ?string
    {
        return $this->provenance;
    }

    public function setProvenance(?string $provenance): self
    {
        $this->provenance = $provenance;

        return $this;
    }

    public function getOcvVolume(): ?string
    {
        return $this->ocv_volume;
    }

    public function setOcvVolume(?string $ocv_volume): self
    {
        $this->ocv_volume = $ocv_volume;

        return $this;
    }

    public function getOcvChapter(): ?string
    {
        return $this->ocv_chapter;
    }

    public function setOcvChapter(?string $ocv_chapter): self
    {
        $this->ocv_chapter = $ocv_chapter;

        return $this;
    }

    public function getTextChapter(): ?string
    {
        return $this->text_chapter;
    }

    public function setTextChapter(?string $text_chapter): self
    {
        $this->text_chapter = $text_chapter;

        return $this;
    }

    public function getTextReference(): ?string
    {
        return $this->text_reference;
    }

    public function setTextReference(?string $text_reference): self
    {
        $this->text_reference = $text_reference;

        return $this;
    }

    public function getManuscriptDetails(): ?string
    {
        return $this->manuscript_details;
    }

    public function setManuscriptDetails(?string $manuscript_details): self
    {
        $this->manuscript_details = $manuscript_details;

        return $this;
    }

    public function getLinkArchiveCatalogue(): ?string
    {
        return $this->link_archive_catalogue;
    }

    public function setLinkArchiveCatalogue(?string $link_archive_catalogue): self
    {
        $this->link_archive_catalogue = $link_archive_catalogue;

        return $this;
    }

    public function getLinkDigitalVoltaire(): ?string
    {
        return $this->link_digital_voltaire;
    }

    public function setLinkDigitalVoltaire(?string $link_digital_voltaire): self
    {
        $this->link_digital_voltaire = $link_digital_voltaire;

        return $this;
    }
     
}
