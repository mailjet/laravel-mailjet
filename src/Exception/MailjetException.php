<?php
namespace Mailjet\LaravelMailjet\Exception;

use \Mailjet\Response;

/**
 * Handle Mailjet API errors
 */
class MailjetException extends \Exception
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var string
     */
    private $errorInfo;
    /**
     * @var string
     */
    private $errorMessage;
    /**
     * @var string
     */
    private $errorIdentifier;
    /**
     * https://dev.mailjet.com/guides/#about-the-mailjet-restful-api
     * @param Response  $response
     * @param \Throwable $previous
     */
    public function __construct($statusCode=0, $message=null, Response $response=null, \Throwable $previous=null)
    {
        // if you pass a Mailjet\Response
        if ($response) {
            $statusCode = $response->getStatus();
            $message = sprintf('%s: %s', $message, $response->getReasonPhrase());
            $this->setErrorFromResponse($response);
        }
        parent::__construct($message, $statusCode, $previous);
    }
    /**
     * Configure MailjetException from Mailjet\Response
     * @method setErrorFromResponse
     * @param  Response $response
     */
    private function setErrorFromResponse(Response $response)
    {
        $this->statusCode = $response->getStatus();
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
    public function getErrorInfo()
    {
        return $this->errorInfo;
    }
    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
    /**
     * @return string
     */
    public function getErrorIdentifier()
    {
        return $this->errorIdentifier;
    }
}
