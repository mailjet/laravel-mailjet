<?php

namespace Mailjet\LaravelMailjet\Model;

/**
* https://dev.mailjet.com/email-api/v3/contactmetadata/
* Manage Contact Properties
*/
class ContactMetadata
{
    const DATATYPE_STR = 'str';
    const DATATYPE_INT = 'int';
    const DATATYPE_FLOAT = 'float';
    const DATATYPE_BOOL = 'bool';
    const DATATYPE_DATETIME = 'datetime';

    protected $name;
    protected $datatype;

    public function __construct($name, $datatype)
    {
        $this->name = $name;
        $this->datatype = $datatype;
    }

    /**
     * Formate contact for Mailjet API request
     * @return array
     */
    public function format()
    {
        $result = [
            'Name' => $this->name,
            'Datatype' => $this->datatype,
        ];

        return $result;
    }
}
