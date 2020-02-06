<?php

declare(strict_types=1);

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Template;

interface TemplateServiceContract
{
    public function getAll(array $filters = null): array;

    public function get(string $id): array;

    public function create(Template $template): array;

    public function update(string $id, Template $template): array;

    public function delete(string $id): array;

    public function getDetailContent(string $id): array;

    public function createDetailContent(string $id, array $content): array;

    public function deleteDetailContent(string $id): array;
}
