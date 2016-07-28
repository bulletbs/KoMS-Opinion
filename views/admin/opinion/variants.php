<?php defined('SYSPATH') or die('No direct script access.');?>

<div id="opinionVariants">
    <b>Ответы</b>
    <div id="variantsList">
        <?foreach($model->variants->order_by('ordr', 'ASC')->find_all() as $variant):?>
            <div class="form-group">
                <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                <?=Form::input('variants['.$variant->id.']', $variant->title, array('class'=>'input-sm'))?>
                <?= Form::button('del ','X',array('class'=>'del btn btn-danger input-sm', 'data-id'=>$variant->id))?><br>
            </div>
        <?endforeach;?>
        <?= Form::input('add', __('Add').' '.__('variant'), array('class'=>'addButton  btn btn-primary', 'type'=>'button'))?>
    </div>
    <br>
</div>
<div id="deletedVariants"></div>

<script type="text/javascript">
    var newCounter = -1;
    var deletedVariantHtml = '<?= Form::hidden('deleted[]', 'variantKey') ?>';
    var variantHtml = '<div class="form-group">\
    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>\
    <?= Form::input('variants[\'+ newCounter +\']', '', array('class'=>'input-sm'))?>\
    <?= Form::button('del','X',array('class'=>'del btn  btn-danger input-sm'))?><br>\
</div>';

$(document).ready(function(){
    $("#variantsList").sortable({
        cursor:'move'
    });
    $('#opinionVariants').on('click', '.addButton',function(){
        $(this).before(variantHtml.replace('PARENT_ID', $(this).data('id')));
        newCounter--;
    });
    $('#opinionVariants').on('click', '.del', function(){
        if($(this).data('id'))
            $('#deletedVariants').append(deletedVariantHtml.replace('variantKey', $(this).data('id')));
        $(this).parent().remove();
    });
});
</script>