<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Services;

use Mailjet\Resources;
use Mailjet\LaravelMailjet\Model\Template;
use Mailjet\LaravelMailjet\Exception\MailjetException;
use Mailjet\LaravelMailjet\Contracts\TemplateServiceContract;

/**
 * https://dev.mailjet.com/email-api/v3/template/
 */
class TemplateService implements TemplateServiceContract
{
    /**
     * @var MailjetService
     */
    protected $mailjet;

    public function __construct(MailjetService $mailjet)
    {
        $this->mailjet = $mailjet;
    }

    /**
     * List template resources available for this apikey, use a GET request.
     * Alternatively, you may want to add one or more filters.
     *
     * @param array|null $filters
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getAll(array $filters = null): array
    {
        $response = $this->mailjet->get(Resources::$Template, ['filters' => $filters]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:getAll() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Access a given template resource, use a GET request, providing the template's ID value.
     *
     * @param string $id
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function get(string $id): array
    {
        $response = $this->mailjet->get(Resources::$Template, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:get() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Add a new template resource with a POST request.
     *
     * @param Template $template
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function create(Template $template): array
    {
        $response = $this->mailjet->post(Resources::$Template, ['body' => $template->format()]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:create() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Update one specific template resource with a PUT request, providing the template's ID value.
     *
     * @param string   $id
     * @param Template $template
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function update(string $id, Template $template): array
    {
        $response = $this->mailjet->put(Resources::$Template, ['id' => $id, 'body' => $template->format()]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:update() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Delete a given template.
     *
     * @param string $id
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function delete(string $id): array
    {
        $response = $this->mailjet->delete(Resources::$Template, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:delete() failed', $response);
        }

        return $response->getData();
    }

    /**
     * Return the text and html contents of the Template.
     *
     * @param string $id
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function getDetailContent(string $id): array
    {
        $response = $this->mailjet->get(Resources::$TemplateDetailcontent, ['id' => $id]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:getDetailContent failed', $response);
        }

        return $response->getData();
    }

    /**
     * Creates the content of a Template.
     *
     * @param string $id
     * @param array  $content
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function createDetailContent(string $id, array $content): array
    {
        $response = $this->mailjet->post(Resources::$TemplateDetailcontent, ['id' => $id, 'body' => $content]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:createDetailContent failed', $response);
        }

        return $response->getData();
    }

    /**
     * Deletes the content of a Template.
     *
     * @param string $id
     *
     * @return array
     * @throws \Mailjet\LaravelMailjet\Exception\MailjetException
     */
    public function deleteDetailContent(string $id): array
    {
        $response = $this->mailjet->post(Resources::$TemplateDetailcontent, ['id' => $id, 'body' => null]);

        if (! $response->success()) {
            throw new MailjetException(0, 'TemplateService:createDetailContent failed', $response);
        }

        return $response->getData();
    }
}
