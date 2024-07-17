<?php

namespace App\Entity;


use App\Entity\Traits\EnableTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[Vich\Uploadable]
class Book
{
    use EnableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Length(max: 17, min: 14)]
    private ?string $isbn = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?int $publishing_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $synopsis = null;


    /**
     * @var Collection<int, Users>
     */
    #[ORM\ManyToMany(targetEntity: Users::class, mappedBy: 'favoris')]
    private Collection $users;



    /**
     * @var Collection<int, author>
     */
    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'books')]
    private Collection $author;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Publisher $publisher = null;

    /**
     * @var Collection<int, categories>
     */
    #[ORM\ManyToMany(targetEntity: Categories::class, inversedBy: 'books')]
    private Collection $categories;


    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName', size: 'fileSize')]
    #[Assert\Image(detectCorrupted: true)]
    private ?File $bookCover = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $fileSize = null;

    /**
     * @var Collection<int, Commentaries>
     */
    #[ORM\OneToMany(targetEntity: Commentaries::class, mappedBy: 'book')]
    private Collection $commentaries;

    public function __construct()
    {

        $this->users = new ArrayCollection();

        $this->author = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->commentaries = new ArrayCollection();
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

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): static
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPublishingDate(): ?int
    {
        return $this->publishing_date;
    }

    public function setPublishingDate(int $publishing_date): static
    {
        $this->publishing_date = $publishing_date;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }



    /**
     * @return Collection<int, Users>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(Users $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addFavori($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavori($this);
        }

        return $this;
    }



    /**
     * @return Collection<int, author>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(author $author): static
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
        }

        return $this;
    }

    public function removeAuthor(author $author): static
    {
        $this->author->removeElement($author);

        return $this;
    }

    public function getPublisher(): ?Publisher
    {
        return $this->publisher;
    }

    public function setPublisher(?Publisher $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * @return Collection<int, categories>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categories $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categories $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }



    /**
     * Get the value of File
     *
     * @return ?File
     */
    public function getBookCover(): ?File
    {
        return $this->bookCover;
    }

    /**
     * Set the value of File
     *
     * @param ?File $File
     *
     * @return self
     */
    public function setBookCover(?File $bookCover): self
    {
        $this->bookCover = $bookCover;

        return $this;
    }

    /**
     * Get the value of imageName
     *
     * @return ?string
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * Set the value of imageName
     *
     * @param ?string $imageName
     *
     * @return self
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get the value of fileSize
     *
     * @return ?int
     */
    public function getFileSize(): ?int
    {
        return $this->fileSize;
    }

    /**
     * Set the value of fileSize
     *
     * @param ?int $fileSize
     *
     * @return self
     */
    public function setFileSize(?int $fileSize): self
    {
        $this->fileSize = $fileSize;

        return $this;
    }

    /**
     * @return Collection<int, Commentaries>
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentaries $commentary): static
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries->add($commentary);
            $commentary->setBook($this);
        }

        return $this;
    }

    public function removeCommentary(Commentaries $commentary): static
    {
        if ($this->commentaries->removeElement($commentary)) {
            // set the owning side to null (unless already changed)
            if ($commentary->getBook() === $this) {
                $commentary->setBook(null);
            }
        }

        return $this;
    }
}
