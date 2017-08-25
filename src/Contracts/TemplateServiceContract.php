<?php

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\Template;

interface TemplateServiceContract
{

    public function getAll(array $filters = null);

    public function get($id);

    public function create(Template $Template);

    public function update($id, Template $Template);

    public function delete($id);

    public function getDetailContent($id);

    public function createDetailContent($id, $contentData);

    public function deleteDetailContent($id);
}