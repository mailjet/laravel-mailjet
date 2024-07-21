<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Template;

interface TemplateServiceContract
{
    /**
     * @param array|null $filters
     * @return array
     */
    public function getAll(array $filters = null): array;

    /**
     * @param string $id
     * @return array
     */
    public function get(string $id): array;

    /**
     * @param Template $template
     * @return array
     */
    public function create(Template $template): array;

    /**
     * @param string $id
     * @param Template $template
     * @return array
     */
    public function update(string $id, Template $template): array;

    /**
     * @param string $id
     * @return array
     */
    public function delete(string $id): array;

    /**
     * @param string $id
     * @return array
     */
    public function getDetailContent(string $id): array;

    /**
     * @param string $id
     * @param array $content
     * @return array
     */
    public function createDetailContent(string $id, array $content): array;

    /**
     * @param string $id
     * @return array
     */
    public function deleteDetailContent(string $id): array;
}
