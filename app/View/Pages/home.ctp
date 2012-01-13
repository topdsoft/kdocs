<div class="pages view">
<p>Welcome to kDocs your online solution for simple document sharing.</p>
<h2>Basic Help</h2>

<h3>Creating a new Document</h3>
<p>Click <?php echo $this->Html->link(__('Create New Doc'),array('controller'=>'docs','action'=>'add'));?>, give it a name.  Select a group (if you are in more than 
one.)  Decide who can edit the doc and how important it is, then click "Submit"</p>
<p>You should be taken to the edit doc screen.  You can make the text box larger by dragging the lower right corner, or make it full screen by clicking this button:
<?php echo $this->Html->image('help/kdoc.png',array('class'=>'shadow'));?>
 When you are done creating a doc, click the save button in the upper left corner.
</p>
<h3>Basic Document Editing</h3>


</div>
<?php echo $this->element('menu');?>
</div>