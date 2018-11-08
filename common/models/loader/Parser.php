<?php

namespace common\models\loader;

interface Parser
{
    public function Parsing();

    public function InsertBrand($data);

    public function InsertOrUpdate($data);
}