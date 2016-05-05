<?php defined('SYSPATH') or die('No direct script access.');

if(!Route::cache()){
    Route::set('opinion', 'opinion(/<action>(/<id>)(/p<page>.html))', array('id' => '[0-9]+', 'page' => '[0-9]+'))
        ->defaults(array(
            'controller' => 'opinion',
            'action' => 'index',
        ));
}
