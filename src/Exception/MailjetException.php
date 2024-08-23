<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Exception;

use Throwable;
use \Mailjet\Response;

class MailjetException extends \Exception
{
    /**
     * @var string
     */
    private string $errorInfo;

    /**
     * @var string
     */
    private string $errorMessage;

    /**
     * @var string
     */
    private string $errorIdentifier;

    /**
     * https://dev.mailjet.com/guides/#about-the-mailjet-restful-api
     * @param int $statusCode
     * @param null $message
     * @param Response|null $response
     * @param Throwable|null $previous
     */
    public function __construct(int $statusCode = 0, $message = null, Response $response = null, Throwable $previous = null)
    {
        if ($response) {
            $statusCode = $response->getStatus() ?? 0;
            $message = "{$message}: {$response->getReasonPhrase()}";

            $this->setErrorFromResponse($response);
        }

        parent::__construct($message, $statusCode, $previous);
    }
    /**
     * Configure MailjetException from Mailjet\Response.
     *
     * @param  Response $response
     */
    private function setErrorFromResponse(Response $response): void
    {
        $body = $response->getBody();

        if (isset($body['ErrorInfo'])) {
            $this->errorInfo = $body['ErrorInfo'];
        }
        if (isset($body['ErrorMessage'])) {
            $this->errorMessage = $body['ErrorMessage'];
        }
        if (isset($body['ErrorIdentifier'])) {
            $this->errorIdentifier = $body['ErrorIdentifier'];
        }
    }

    /**
     * @return string
     */
    public function getErrorInfo(): string
    {
        return $this->errorInfo;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @return string
     */
    public function getErrorIdentifier(): string
    {
        return $this->errorIdentifier;
    }
}
