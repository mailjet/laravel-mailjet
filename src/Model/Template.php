<?php

namespace Mailjet\LaravelMailjet\Model;

/**
 * Description of Template
 *
 */
class Template {

    const NAME_KEY = 'Name';

    //Mandatory properties (must be set through constructor)
    protected $name;
    //Optional properties (array)
    protected $optionalProperties = null;
    //content
    protected $content = null;
    //id
    protected $id = null;

    /**
     * @param $name
     * @param optionalProperties
     */
    public function __construct($name, $optionalProperties = null) {
        $this->name = $name;
        $this->optionalProperties = $optionalProperties;
    }

    /**
     * Format Template for MailJet API request
     * @return array
     */
    public function format() {

        /*         * Add the mandatary props* */
        if (!is_null($this->name)) {
            $result[self::NAME_KEY] = $this->name;
        }

        /*         * Add the optional props if any* */
        if (!is_null($this->optionalProperties)) {
            $result = array_merge($result, $this->optionalProperties);
        }


        return $result;
    }

    /**
     * Correspond to properties in MailJet request
     * Array ['PropertyName' => value, ...]
     */
    public function getOptionalProperties() {
        return $this->optionalProperties;
    }

    /**
     * Set array of Template properties
     * @param array $property
     * @return Properties
     */
    public function setOptionalProperties(array $properties) {
        $this->optionalProperties = $properties;
        return $this->optionalProperties;
    }

    /**
     * Add a new $property to Template
     * @param array $property
     * @return Properties
     */
    public function addProperty(array $property) {
        $this->optionalProperties[] = $property;
        return $this->optionalProperties;
    }

    /**
     * Remove a $property from Template
     * @param array $property
     * @return Properties
     */
    public function removeProperty(array $property) {
        foreach (array_keys($this->optionalProperties, $property) as $key) {
            unset($this->optionalProperties[$key]);
        }
        return $this->optionalProperties;
    }

    /**
     * Get  Template content
     * @return $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * Get  Template content
     * @return $content
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Get Id
     * @return $content
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set Id
     */
    public function setId($id) {
        $this->id = $id;
    }

}
