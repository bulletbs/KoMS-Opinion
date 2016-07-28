<?php defined('SYSPATH') or die('No direct script access.');?>
<h1><?php echo $opinion->title?></h1>

<b><?php echo $opinion->title?>?</b><br>
<br>
<?if(isset($errors) && is_array($errors)):?><?= View::factory('error/validation', array('errors' => $errors))->render()?><?endif;?>
<?php echo Form::open($opinion->getVoteUri(), array('class'=>'pure-form'))?>
    <?foreach($variants as $variant):?>
        <?php echo Form::label('variant', Form::radio('variant', $variant->id, !isset($selected)?$selected=TRUE:FALSE).' '.$variant->title, array('class'=>'row'))?>
    <?endforeach;?>
    <br>
    <input type="submit" class="pure-button pure-button-success">
    <?php echo HTML::anchor($opinion->getResultsUri(), 'Результаты', array('class'=>'pure-button'))?>
<?php echo Form::close()?>
<br>
<?php echo HTML::anchor(Route::get('opinion')->uri(), 'Вернуться к списку голосований')?>