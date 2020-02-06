<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

abstract class Model implements Requestable
{
    /**
     * @var array
     */
    protected $optionalProperties;

    /**
     * Format MailJet API request.
     *
     * @return array
     */
    abstract public function format(): array;

    /**
     * Correspond to properties in MailJet request.
     * Array ['PropertyName' => value, ...]
     *
     * @return array
     */
    public function getOptionalProperties(): array
    {
        return $this->optionalProperties;
    }

    /**
     * Set array of optional properties.
     *
     * @param array $properties
     *
     * @return array
     */
    public function setOptionalProperties(array $properties): array
    {
        $this->optionalProperties = $properties;

        return $this->optionalProperties;
    }

    /**
     * Add a new optional property.
     *
     * @param array $property
     *
     * @return array
     */
    public function addOptionalProperty(array $property): array
    {
        $this->optionalProperties[] = $property;

        return $this->optionalProperties;
    }

    /**
     * Remove a optional property.
     *
     * @param array $property
     *
     * @return array
     */
    public function removeOptionalProperty(array $property): array
    {
        foreach (array_keys($this->optionalProperties, $property) as $key) {
            unset($this->optionalProperties[$key]);
        }

        return $this->optionalProperties;
    }
}
