<?php

require_once 'Author.php';

class Book
{

    /**
     * @var string
     */
    private $titel;
    /**
     * @var int
     */
    private $releaseDate;
    /**
     * @var int
     */
    private $numPages;
    /**
     * @var string
     */
    private $genre;

    /**
     * Book constructor.
     * @param $titel
     * @param Author $author
     * @param $releaseDate
     * @param $numPages
     * @param $genre
     */
    public function __construct($titel, Author $author, int $releaseDate, int $numPages, $genre)
    {
        $this->titel = $titel;
        $this->author = $author;
        $this->releaseDate = $releaseDate;
        $this->numPages = $numPages;
        $this->genre = $genre;
    }

    public function getTitel()
    {
        return $this->titel;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    public function getNumPages()
    {
        return $this->numPages;
    }

    public function getGenre()
    {
        return $this->genre;
    }
}