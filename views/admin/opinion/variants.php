<?php defined('SYSPATH') or die('No direct script access.');?>

<b>Ответы</b>
<div id="opinionVariants">
    <div id="variantsList">
        <?foreach($model->variants->find_all() as $variant):?>
            <div>
                <?=Form::input('variants['.$variant->id.']', $variant->title, array('class'=>'span2'))?>&nbsp;
                <?= Form::button('del','X',array('class'=>'del btn', 'data-id'=>$variant->id))?><br>
            </div>
        <?endforeach;?>
    </div>
    <br>
    <?= Form::input('add', __('Add').' '.__('variant'), array('class'=>'addButton', 'type'=>'button'))?>
</div>
<div id="deletedVariants"></div>

<script type="text/javascript">
    variantHtml = '<div>\
    <?= Form::input('newVariants[]', '', array('class'=>'span2'))?>&nbsp;\
    <?= Form::button('del','X',array('class'=>'del btn'))?><br>\
</div>';
var deletedVariantHtml = '<?= Form::hidden('deleted[]', 'variantKey') ?>';

$(document).ready(function(){
    /**
     * Options List events
     * @type {*|jQuery|HTMLElement}
     */
    $('#opinionVariants').on('click', '.addButton',function(){
        var content = variantHtml;
        if($(this).data('id') > 0)
            content = content.replace('PARENT_ID', $(this).data('id'));
        $(this).before(content);
    });
    $('#opinionVariants').on('click', '.del', function(){
        var id = $(this).data('id');
        if(id)
            $('#deletedVariants').append(deletedVariantHtml.replace('variantKey', id));
        $(this).parent().remove();
    });
});
</script>