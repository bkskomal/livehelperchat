<div class="fill-survey-container">
    <?php include(erLhcoreClassDesign::designtpl('lhsurvey/forms/parts/header.tpl.php'));?>
    <div class="fill-survey-form">
        <form action="" method="post">
            <?php if (isset($errors)) : ?>
            		<?php include(erLhcoreClassDesign::designtpl('lhkernel/validation_error.tpl.php'));?>
            <?php endif; ?>
            
            <?php include(erLhcoreClassDesign::designtpl('lhsurvey/forms/fill.tpl.php'));?>
            
            <hr class="mt-1 mb-1">
            
            <div class="btn-group" role="group" aria-label="...">
                <?php if ($survey_item->is_filled == false) : ?>
                    <input type="submit" class="btn btn-success btn-sm" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('system/buttons','Submit')?>" name="Vote" />
                <?php endif;?>

                <?php if (!(isset($survey->configuration_array['disable_chat_preview']) && $survey->configuration_array['disable_chat_preview'] == true)) : ?>
                <button type="button" class="btn btn-info btn-sm" onclick="return lhc.revealModal({'url':WWW_DIR_JAVASCRIPT+'chat/chatpreview/<?php echo $chat->id?>/<?php echo $chat->hash?>'})"><i class="material-icons">chat</i> <?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('survey/fill','Preview chat')?></button>
                <?php endif; ?>
            </div>
            
            <?php if ($survey_item->is_filled == true && ($chat->status == erLhcoreClassModelChat::STATUS_CLOSED_CHAT || !in_array($chat->status_sub, array(erLhcoreClassModelChat::STATUS_SUB_SURVEY_SHOW, erLhcoreClassModelChat::STATUS_SUB_SURVEY_COLLECTED)))) : ?>
                 <input type="button" class="btn btn-sm btn-success mb-1 float-right" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/chat','Close')?>" onclick="lhinst.userclosedchatembed();" />
            <?php endif;?>
            
            <?php 
            /**
             * Because user filled a survey we have to redirect it back to chat
             * */
            if ($chat->status != erLhcoreClassModelChat::STATUS_CLOSED_CHAT && in_array($chat->status_sub, array(erLhcoreClassModelChat::STATUS_SUB_SURVEY_SHOW, erLhcoreClassModelChat::STATUS_SUB_SURVEY_COLLECTED))) : ?>
                 <input type="button" class="btn btn-sm btn-success mb-1 float-right" value="<?php echo erTranslationClassLhTranslation::getInstance()->getTranslation('chat/chat','Back to chat')?>" onclick="return lhinst.continueChatFromSurvey('<?php echo $survey->id?>');" />
            <?php endif;?>
            
        </form>
    </div>
</div>
<script type="text/javascript">
<?php if ($survey_item->is_filled == false) : ?>
setInterval(function(){
    $.getJSON(WWW_DIR_JAVASCRIPT + 'survey/isfilled/<?php echo $chat->id?>/<?php echo $chat->hash?>/<?php echo $survey->id?>', function(data) {
        if (data === true) {
            document.location.reload();
        }
    });
},2000);
<?php endif; ?>

<?php if ($survey_item->is_filled == true && $chat->status_sub == erLhcoreClassModelChat::STATUS_SUB_SURVEY_COLLECTED && isset($just_stored) && $just_stored == true) : ?>
setTimeout(function() {
	   lhinst.continueChatFromSurvey('<?php echo $survey->id?>');
}, 3000);
<?php elseif ($survey_item->is_filled == true && $chat->status_sub == erLhcoreClassModelChat::STATUS_SUB_SURVEY_COLLECTED && !isset($just_stored)) : ?>
$( document ).ready(function() {
	lhinst.userclosedchatembed();
});
<?php endif;?>

lhinst.setChatID('<?php echo $chat->id?>');
lhinst.setChatHash('<?php echo $chat->hash?>');
</script>