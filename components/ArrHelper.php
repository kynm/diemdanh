<?php

namespace app\components;

use yii\base\Component;

class ArrHelper extends Component
{
    public $content;

    public function init()
    {
        parent::init();
        $this->content = 'Hello Yii 2.0';
    }

    /*
     * search in array and return an array of result
     */

    public function search($array, $search_list)
    {
        $result = array();
        foreach ($array as $key => $value) {
            foreach ($search_list as $k => $v) {

                if (!isset($value[$k]) || $value[$k] != $v) {
                    continue 2;
                }
            }
            $result[] = $value;
        }

        return $result;
    }
}
