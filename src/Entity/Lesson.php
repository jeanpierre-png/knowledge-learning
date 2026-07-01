<?php

namespace App\Entity;

use App\Repository\LessonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LessonRepository::class)]
class Lesson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $videoUrl = null;

    #[ORM\Column]
    private ?int $orderIndex = null;

    #[ORM\ManyToOne(inversedBy: 'lessons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    /**
     * @var Collection<int, Purchase>
     */
    #[ORM\OneToMany(targetEntity: Purchase::class, mappedBy: 'lesson')]
    private Collection $purchases;

    /**
     * @var Collection<int, LessonProgress>
     */
    #[ORM\OneToMany(targetEntity: LessonProgress::class, mappedBy: 'lesson')]
    private Collection $lessonProgress;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
        $this->lessonProgress = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getVideoUrl(): ?string
    {
        return $this->videoUrl;
    }

    public function setVideoUrl(?string $videoUrl): static
    {
        $this->videoUrl = $videoUrl;

        return $this;
    }

    public function getOrderIndex(): ?int
    {
        return $this->orderIndex;
    }

    public function setOrderIndex(int $orderIndex): static
    {
        $this->orderIndex = $orderIndex;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection<int, Purchase>
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchase $purchase): static
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases->add($purchase);
            $purchase->setLesson($this);
        }

        return $this;
    }

    public function removePurchase(Purchase $purchase): static
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getLesson() === $this) {
                $purchase->setLesson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, LessonProgress>
     */
    public function getLessonProgress(): Collection
    {
        return $this->lessonProgress;
    }

    public function addLessonProgress(LessonProgress $lessonProgress): static
    {
        if (!$this->lessonProgress->contains($lessonProgress)) {
            $this->lessonProgress->add($lessonProgress);
            $lessonProgress->setLesson($this);
        }

        return $this;
    }

    public function removeLessonProgress(LessonProgress $lessonProgress): static
    {
        if ($this->lessonProgress->removeElement($lessonProgress)) {
            // set the owning side to null (unless already changed)
            if ($lessonProgress->getLesson() === $this) {
                $lessonProgress->setLesson(null);
            }
        }

        return $this;
    }
}
