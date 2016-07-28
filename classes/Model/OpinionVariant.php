<?php defined('SYSPATH') or die('No direct script access.');

class Model_OpinionVariant extends ORM{
    protected $_table_name = 'opinion_variants';
    protected $_reload_on_wakeup   = FALSE;

    protected $_belongs_to = array(
        'opinion' => array(
            'model' => 'OpinionList',
            'foreign_key' => 'opinion_id',
        ),
    );

    /**
     * Calculate percent
     * @param $total
     * @return mixed
     */
    public function calculatePercent($total){
        $percent = round($this->amount / $total*100,2);
        return str_replace(',', '.', $percent);
    }
}