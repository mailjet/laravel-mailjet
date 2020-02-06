<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Model;

use RuntimeException;

/**
 * https://dev.mailjet.com/email/reference/contacts/contact-properties/
 */
class ContactMetadata implements Requestable
{
    public const DATATYPE_STR = 'str';
    public const DATATYPE_INT = 'int';
    public const DATATYPE_FLOAT = 'float';
    public const DATATYPE_BOOL = 'bool';
    public const DATATYPE_DATETIME = 'datetime';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $datatype;

    public function __construct(string $name, string $datatype)
    {
        if (! $this->validateDatatype($datatype)) {
            throw new RuntimeException("$datatype: is not a valid Datatype.");
        }

        $this->name = $name;
        $this->datatype = $datatype;
    }

    /**
     * Format contact for Mailjet API request.
     *
     * @return array
     */
    public function format(): array
    {
        return [
            'Name' => $this->name,
            'Datatype' => $this->datatype,
        ];
    }

    /**
     * Validate datatype.
     *
     * @param string $datatype
     *
     * @return bool
     */
    protected function validateDatatype(string $datatype): bool
    {
        $available = [
            self::DATATYPE_STR,
            self::DATATYPE_INT,
            self::DATATYPE_FLOAT,
            self::DATATYPE_BOOL,
            self::DATATYPE_DATETIME,
        ];

        return in_array($datatype, $available);
    }
}
