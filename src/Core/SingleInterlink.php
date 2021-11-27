<?php

namespace KaqazStudio\LaravelInterlink\Core;

use Illuminate\Support\Collection;

class SingleInterlink
{
    #region Attributes
    /**
     * @var string
     */
    private $_keyword;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $_link;

    /**
     * @var boolean
     */
    private $_rawLink = false;

    /**
     * @var integer
     */
    private $_count = 0;

    /**
     * @var Collection
     */
    private $_posts;

    /**
     * @var string
     */
    private $_column;

    /**
     * @var Collection
     */
    private $_result;

    /**
     * @var bool
     */
    private $_markdown = false;

    /**
     * @var bool
     */
    private $_blank = false;

    /**
     * @var bool
     */
    private $_noFollow = false;

    /**
     * @var string
     */
    private $_customAttributes;
    #endregion

    #region Core

    /**
     * Warm SingleInterLink System.
     *
     * @return $this
     */
    public function init(): SingleInterlink
    {
        return $this;
    }

    /**
     * Internalization links.
     * @return SingleInterlink
     */
    public function process(): SingleInterlink
    {
        $result = collect();

        foreach ($this->getPosts() as $post) {
            $content = $post[$this->getColumn()];

            $post[$this->getColumn()] = $this->replace($content);

            $result->add($post);
        }

        $this->setResult($result);

        return $this;
    }

    /**
     * Get updated posts.
     * @return Collection
     */
    public function getUpdatedPosts(): Collection
    {
        return $this->getResult();
    }

    /**
     * Process update action on posts.
     */
    public function updatePosts(): void
    {
        foreach ($this->getResult() as $post)
            $post->update();
    }

    #endregion

    #region Helpers

    /**
     * Replace post content
     * @param string $content
     * @return string
     */
    private function replace(string $content): string
    {
        return $this->isCountable()
            ? preg_replace($this->normalizedKeyword(), $this->normalizedLink(), $content, $this->getCount())
            : str_replace($this->getKeyword(), $this->normalizedLink(), $content);
    }

    /**
     * Get normalized link.
     * @return string
     */
    private function normalizedLink(): string
    {
        $title = $this->getTitle();
        $link  = $this->getLink();

        if ($this->isRawLink())
            return $this->getLink();

        if ($this->isMarkdown())
            return "[$title]($link)";

        return $this->formatHtml($title, $link);
    }

    /**
     * Get HTML formatted link.
     * @param string $title
     * @param string $link
     * @return string
     */
    private function formatHtml(string $title, string $link): string
    {
        $targetAttribute = $this->isBlank() ? '_blank' : '_self';
        $relAttribute = $this->isNoFollow() ? 'rel=nofollow' : '';
        $customAttributes = $this->getCustomAttributes();


        return "<a href='$link' target='$targetAttribute' $relAttribute $customAttributes>$title</a>";
    }

    /**
     * Normalize keyword for regex search.
     * @return string
     */
    private function normalizedKeyword(): string
    {
        return '/' . preg_quote($this->getKeyword(), '/') . '/';
    }

    #endregion

    #region Setters

    /**
     * @param string $keyword
     * @return SingleInterlink
     */
    public function setKeyword(string $keyword): SingleInterlink
    {
        $this->_keyword = $keyword;
        return $this;
    }

    /**
     * @param string $link
     * @return SingleInterlink
     */
    public function setLink(string $link): SingleInterlink
    {
        $this->_link = $link;
        return $this;
    }

    /**
     * @return SingleInterlink
     */
    public function rawLink(): SingleInterlink
    {
        $this->_rawLink = true;
        return $this;
    }

    /**
     * @param int $count
     * @return SingleInterlink
     */
    public function setCount(int $count): SingleInterlink
    {
        $this->_count = $count;
        return $this;
    }

    /**
     * @param Collection $contents
     * @return SingleInterlink
     */
    public function setPosts(Collection $contents): SingleInterlink
    {
        $this->_posts = $contents;
        return $this;
    }

    /**
     * @param string $column
     * @return SingleInterlink
     */
    public function setColumn(string $column): SingleInterlink
    {
        $this->_column = $column;
        return $this;
    }

    /**
     * @param Collection $result
     * @return SingleInterlink
     */
    public function setResult(Collection $result): SingleInterlink
    {
        $this->_result = $result;
        return $this;
    }

    /**
     * @param string $title
     * @return SingleInterlink
     */
    public function setTitle(string $title): SingleInterlink
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return SingleInterlink
     */
    public function markDown(): SingleInterlink
    {
        $this->_markdown = true;
        return $this;
    }

    /**
     * @return SingleInterlink
     */
    public function blank(): SingleInterlink
    {
        $this->_blank = true;
        return $this;
    }

    /**
     * @return SingleInterlink
     */
    public function noFollow(): SingleInterlink
    {
        $this->_noFollow = true;
        return $this;
    }

    /**
     * @param string $customAttributes
     * @return SingleInterlink
     */
    public function setCustomAttributes(string $customAttributes): SingleInterlink
    {
        $this->_customAttributes = $customAttributes;
        return $this;
    }
    #endregion

    #region Getters

    /**
     * @return string
     */
    private function getKeyword(): string
    {
        return $this->_keyword;
    }

    /**
     * @return string
     */
    private function getLink(): string
    {
        return $this->_link;
    }

    /**
     * @return bool
     */
    private function isRawLink(): bool
    {
        return $this->_rawLink;
    }

    /**
     * @return int
     */
    private function getCount(): int
    {
        return $this->_count;
    }

    /**
     * @return Collection
     */
    private function getPosts(): Collection
    {
        return $this->_posts;
    }

    /**
     * @return string
     */
    private function getColumn(): string
    {
        return $this->_column;
    }

    /**
     * @return Collection
     */
    private function getResult(): Collection
    {
        return $this->_result;
    }

    /**
     * Get replace countable status.
     * @return bool
     */
    private function isCountable(): bool
    {
        return $this->getCount() > 0;
    }

    /**
     * @return string
     */
    private function getTitle(): string
    {
        return $this->title ?? $this->getKeyword();
    }

    /**
     * @return bool
     */
    private function isMarkdown(): bool
    {
        return $this->_markdown;
    }

    /**
     * @return string
     */
    private function getCustomAttributes(): string
    {
        return $this->_customAttributes ?? '';
    }

    /**
     * @return bool
     */
    private function isBlank(): bool
    {
        return $this->_blank;
    }

    /**
     * @return bool
     */
    private function isNoFollow(): bool
    {
        return $this->_noFollow;
    }
    #endregion
}
