<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mailjet\LaravelMailjet\Contracts;

interface ContactsV4Contract
{
    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
