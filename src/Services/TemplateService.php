<?php

namespace Mailjet\LaravelMailjet\Services;

use \Mailjet\Resources;
use \Mailjet\Response;
use Mailjet\LaravelMailjet\Services\MailjetService;
use Mailjet\LaravelMailjet\Model\Template;
use Mailjet\LaravelMailjet\Contracts\TemplateServiceContract;
use Mailjet\LaravelMailjet\Exception\MailjetException;

/**
 * https://dev.mailjet.com/email-api/v3/template/
 * Template data. (list,view, create, update, delete,detailcontent, ...)
 */
class TemplateService implements TemplateServiceContract
{
    /**
     * Mailjet client
     * @var MailjetClient
     */
    protected $mailjet;

    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * List template resources available for this apikey, use a GET request.
     * Alternatively, you may want to add one or more filters.
     * @param array optional $filters
     * @return templates
     */
    public function getAll(array $filters = null)
    {
        $response = $this->mailjet->get(Resources::$Template,
            ['filters' => $filters]);
        if (!$response->success()) {
            $this->throwError("TemplateService :getAll() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Access a given template resource, use a GET request, providing the template's ID value
     * @param string $id
     * @return $Template
     */
    public function get($id)
    {
        $response = $this->mailjet->get(Resources::$Template, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("TemplateService:get() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Add a new template resource with a POST request.
     * @param Template $Template
     */
    public function create(Template $Template)
    {
        $response = $this->mailjet->post(Resources::$Template,
            ['body' => $Template->format()]);
        if (!$response->success()) {
            $this->throwError("TemplateService:create() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Update one specific template resource with a PUT request, providing the template's ID value
     * @param int $id
     * @param Template $Template
     */
    public function update($id, Template $Template)
    {
        $response = $this->mailjet->put(Resources::$Template,
            ['id' => $id, 'body' => $Template->format()]);
        if (!$response->success()) {
            $this->throwError("TemplateService:update() failed", $response);
        }

        return $response->getData();
    }

    /**
     * delete a given template
     * @param string $id
     * @return array
     */
    public function delete($id)
    {
        $response = $this->mailjet->delete(Resources::$Template, ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("TemplateService:delete() failed", $response);
        }

        return $response->getData();
    }

    /**
     * Return the text and html contents of the Template
     * @param string $id
     * @return array
     */
    public function getDetailContent($id)
    {
        $response = $this->mailjet->get(Resources::$TemplateDetailcontent,
            ['id' => $id]);
        if (!$response->success()) {
            $this->throwError("TemplateService:getDetailContent failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Creates the content of a  Template
     * @return array
     */
    public function createDetailContent($id, $contentData)
    {
        $response = $this->mailjet->post(Resources::$TemplateDetailcontent,
            ['id' => $id, 'body' => $contentData]);
        if (!$response->success()) {
            $this->throwError("TemplateService:createDetailContent failed",
                $response);
        }

        return $response->getData();
    }

    /**
     * Deletes the content of a  Template
     * @return array
     */
    public function deleteDetailContent($id)
    {
        $nullContent = null;
        $response    = $this->mailjet->post(Resources::$TemplateDetailcontent,
            ['id' => $id, 'body' => $nullContent]);
        if (!$response->success()) {
            $this->throwError("TemplateService:createDetailContent failed",
                $response);
        }

        return $response->getData();
    }

    private function throwError($title, Response $response)
    {
        throw new MailjetException(0, $title, $response);
    }
}