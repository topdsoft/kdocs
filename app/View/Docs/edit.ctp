<div class="docs form">
<?php echo $this->Form->create('Doc');?>
	<fieldset>
		<legend><?php echo __('Edit Doc'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
//		echo $this->Form->input('user_id');
//		echo $this->Form->input('group_id');
		echo $this->Form->input('editor_id',array('label'=>'Who can edit this doc:'));
		echo $this->Form->input('priority',array('id'=>'rating','type'=>'hidden'));
		//show priority bangs
		echo 'Priority:<table style="width:300px;"><tr>';
		for ($i=0; $i<5; $i++) echo '<td><div class="tdBox">'.$this->Html->image('off.png',
			array('class'=>'L1','url'=>"javascript:rating(".($i+1).")",'style'=>'position:relative;')).$this->Html->image('on.png',
			array('class'=>'L1','url'=>"javascript:rating(".($i+1).")",'id'=>'on',
			'style'=>''.(($this->Form->value('Doc.priority')>$i ? '' : 'display:none;')))).'</div></td>';
		echo '</tr></table>';
		echo $this->Form->input('text');
//		echo $this->Form->input('Uploadedfile');
//		echo $this->Form->input('User');
	?>
<?php echo $this->Html->script(array('trainmce.js','tiny_mce/tiny_mce.js'));?>


<script type="text/javascript">
tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

		//removed options:newdocument
		
        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
//        content_css : "css/example.css",
        content_css : "../../css/textedit.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
</script>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<?php echo $this->element('menu');?>
</div>
<?php echo $this->Html->script(array('jquery-1.6.4.min','priority.js'));?>
<style type='text/css'>
.tdBox { position:relative; padding:0;}
.L1 { position:absolute; top:0px; left:0px; z-index:1; }
</style>
