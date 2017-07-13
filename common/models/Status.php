<?php

namespace common\models;

use common\models\base\Status as BaseStatus;
use common\models\traits\DropdownDataTrait;


class Status extends BaseStatus
{
    use DropdownDataTrait;
}
