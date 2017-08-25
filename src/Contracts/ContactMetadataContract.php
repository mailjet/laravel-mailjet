<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mailjet\LaravelMailjet\Contracts;

use Mailjet\LaravelMailjet\Model\ContactMetadata;

interface ContactMetadataContract
{

    public function getAll();

    public function get($id);

    public function create(ContactMetadata $contactMetadata);

    public function update($id, ContactMetadata $contactMetadata);

    public function delete($id);
}