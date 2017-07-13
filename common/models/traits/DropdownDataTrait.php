<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 13.07.2017
 * Time: 18:39
 */

namespace common\models\traits;


use yii\helpers\ArrayHelper;

trait DropdownDataTrait
{
    /**
     * @param null $excludeId
     * @param bool $firstEmpty
     * @param mixed $orderBy
     * @return array
     */
    public static function getDropdownData($excludeId = null, $firstEmpty = true, $orderBy = 'weight')
    {
        $pk = static::primaryKey()[0];
        $data = static::find()->where($excludeId ? "$pk <> $excludeId" : '1=1')->orderBy($orderBy)->asArray()->all();

        return $firstEmpty
            ? ArrayHelper::merge([null=>null], ArrayHelper::map($data, $pk, 'name'))
            : ArrayHelper::map($data, $pk, 'name');
    }
}
