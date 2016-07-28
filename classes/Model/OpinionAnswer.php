<?php defined('SYSPATH') or die('No direct script access.');

class Model_OpinionAnswer extends ORM{
    protected $_table_name = 'opinion_answers';
    protected $_reload_on_wakeup   = FALSE;

    public function labels(){
        return array(
            'opinion_id' => 'Опрос',
            'variant_id' => 'Вариант ответа',
            'user_id' => 'Пользователь',
            'ip' => 'IP адрес',
        );
    }

    protected $_belongs_to = array(
        'opinion' => array(
            'model' => 'OpinionList',
            'foreign_key' => 'opinion_id',
        ),
    );

    /**
     * @param Validation $validation
     * @return void
     */
    public function save(Validation $validation=NULL){
        parent::save($validation);
        DB::update(ORM::factory('OpinionVariant')->table_name())
            ->set(array('amount'=>DB::expr('amount+1')))
            ->where('opinion_id', '=', $this->opinion_id)
            ->and_where('id', '=', $this->variant_id)
            ->execute();
    }
}