<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

/**
 * https://dev.mailjet.com/email/reference/templates
 */
class Template extends Model
{
    public const NAME_KEY = 'Name';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array|null
     */
    protected $content;

    /**
     * @var string|null
     */
    protected $id;

    public function __construct(string $name, array $optionalProperties = [])
    {
        $this->name = $name;
        $this->optionalProperties = $optionalProperties;
    }

    /**
     * Format Template for MailJet API request.
     *
     * @return array
     */
    public function format(): array
    {
        $result[self::NAME_KEY] = $this->name;

        return array_merge($result, $this->optionalProperties);
    }

    /**
     * Get  Template content
     *
     * @return array|null $content
     */
    public function getContent(): ?array
    {
        return $this->content;
    }

    /**
     * Set Template content.
     *
     * @param array $content
     *
     * @return \Mailjet\LaravelMailjet\Model\Template
     */
    public function setContent(array $content): Template
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get id.
     *
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param string $id
     *
     * @return \Mailjet\LaravelMailjet\Model\Template
     */
    public function setId(string $id): Template
    {
        $this->id = $id;

        return $this;
    }
}
