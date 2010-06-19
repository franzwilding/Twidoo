<?php /* Smarty version 2.6.20, created on 2010-06-02 22:48:56
         compiled from /Users/franzwilding/WEB/dev/twidoo/trunk/templates/ca_configuration.tpl */ ?>

<div class="box" id="configuration">

	<div class="innerTop"></div>
	<div class="innerLeft"></div>
	<div class="innerRight"></div>
	<div class="innerBottom"></div>
	
	<div class="inner">

		<h1>Content-Bereiche</h1>






				<?php if ($this->_tpl_vars['page'] == 'start'): ?>
			<ul>
			<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['uebersicht'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['uebersicht']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['dataRow']):
        $this->_foreach['uebersicht']['iteration']++;
?>
				<li>
					<a class="delete" href="<?php echo $this->_tpl_vars['pagePath']; ?>
/delete/<?php echo $this->_tpl_vars['dataRow']['cb_contentareas_id']; ?>
">Löschen</a>
					<a class="name" href="<?php echo $this->_tpl_vars['pagePath']; ?>
/edit1/<?php echo $this->_tpl_vars['dataRow']['cb_contentareas_id']; ?>
"><?php echo $this->_tpl_vars['dataRow']['cb_contentareas_name']; ?>
</a>
	
					<?php if (($this->_foreach['uebersicht']['iteration'] <= 1)): ?>
						<span class="up">Rauf</span>
					<?php else: ?>
						<a class="up" href="<?php echo $this->_tpl_vars['pagePath']; ?>
/up/<?php echo $this->_tpl_vars['dataRow']['cb_contentareas_id']; ?>
">Rauf</a>
					<?php endif; ?>
					
					<?php if (($this->_foreach['uebersicht']['iteration'] == $this->_foreach['uebersicht']['total'])): ?>
						<span class="down">Runter</span>
					<?php else: ?>
						<a class="down" href="<?php echo $this->_tpl_vars['pagePath']; ?>
/down/<?php echo $this->_tpl_vars['dataRow']['cb_contentareas_id']; ?>
">Runter</a>
					<?php endif; ?>
				</li>
			<?php endforeach; endif; unset($_from); ?>
			</ul>
			
			<p class="button"><a href="<?php echo $this->_tpl_vars['pagePath']; ?>
/edit1" class="btn green"><span><span>Contentbereich Hinzufügen</span></span></a></p>
		
		
		
				<?php elseif ($this->_tpl_vars['page'] == 'edit1'): ?>
			
			<form class="edit" action="<?php echo $this->_tpl_vars['pagePath']; ?>
/edit2" method="post">
				<fieldset>
					<legend>Contentbereich bearbeiten</legend>
					<ul>
						<li>
							<label for="name">Name: </label>
							<?php if ($this->_tpl_vars['id'] > 0): ?>
								<input type="hidden" name="edit[id]" value="<?php echo $this->_tpl_vars['id']; ?>
" />
							<?php endif; ?>
							<input tabindex="1" id="name" name="edit[name]" type="text" value="<?php echo $this->_tpl_vars['name']; ?>
" />
						</li>
						
						<!--li>
							<label for="output">Output: </label>
							<select id="output" name="edit[output]">
								<option value="1">Output1</option>
							</select>
						</li-->
					
						<li><button type="submit" class="btn green" tabindex="3" name="edit[submit]" value="true"><span><span>Weiter</span></span></button></li>
					</ul>
				</fieldset>
			</form>
			
			

				
		<?php elseif ($this->_tpl_vars['page'] == 'edit2'): ?>
			
			<form class="edit" action="<?php echo $this->_tpl_vars['pagePath']; ?>
/edit3" method="post">
				<fieldset>
					<legend>Contentbereich bearbeiten</legend>
					<input type="hidden" name="edit[id]" value="<?php echo $this->_tpl_vars['edit_id']; ?>
" />
					<ul>
						<li>
							<label for="name">Name: </label>
							<input id="name" name="edit[name]" type="text" disabled="disabled" value="<?php echo $this->_tpl_vars['edit_name']; ?>
" />
						</li>
						
						<li>
							<label for="tables">Tables: </label>
							<input tabindex="1" id="tables" name="edit[tables]" type="text" value="<?php $_from = $this->_tpl_vars['tables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['tableForEach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['tableForEach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['table']):
        $this->_foreach['tableForEach']['iteration']++;
?><?php echo $this->_tpl_vars['table']['cb_tables_the_table']; ?>
<?php if (! ($this->_foreach['tableForEach']['iteration'] == $this->_foreach['tableForEach']['total'])): ?>,<?php endif; ?><?php endforeach; endif; unset($_from); ?>" />
						</li>
						
						<li>
							<label for="where">Where: </label>
							<input tabindex="2" id="where" name="edit[where]" type="text" value="<?php echo $this->_tpl_vars['whereString']; ?>
" />
						</li>
						
						<li>
							<label for="fieldtypes">Fieldtypes: </label>
							<input tabindex="3" id="fieldtypes" name="edit[fieldtypes]" type="text" value="<?php $_from = $this->_tpl_vars['fieldTypes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['typeForEach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['typeForEach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['fieldType']):
        $this->_foreach['typeForEach']['iteration']++;
?><?php echo $this->_tpl_vars['fieldType']['cb_fieldtypes_the_table']; ?>
#<?php echo $this->_tpl_vars['fieldType']['cb_fieldtypes_field']; ?>
=><?php echo $this->_tpl_vars['fieldType']['cb_fieldtypes_type']; ?>
<?php if (! ($this->_foreach['typeForEach']['iteration'] == $this->_foreach['typeForEach']['total'])): ?>,<?php endif; ?><?php endforeach; endif; unset($_from); ?>" />
						</li>
						
						<li>
							<label for="joins">Joins: </label>
							<input tabindex="4" id="joins" name="edit[joins]" type="text" value="" disabled="disabled" />
						</li>
						
						<li>
							<label for="keys">Keys: </label>
							<input tabindex="5" id="keys" name="edit[keys]" type="text" value="<?php $_from = $this->_tpl_vars['keys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['keyForEach'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['keyForEach']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key']):
        $this->_foreach['keyForEach']['iteration']++;
?><?php echo $this->_tpl_vars['key']['cb_keys_the_table']; ?>
#<?php echo $this->_tpl_vars['key']['cb_keys_the_key']; ?>
<?php if (! ($this->_foreach['keyForEach']['iteration'] == $this->_foreach['keyForEach']['total'])): ?>,<?php endif; ?><?php endforeach; endif; unset($_from); ?>" />
						</li>
						
						<li>
							<p>
								<strong>Tables:</strong> table1,table2<br />
								<strong>Where:</strong> Standard SQL Where: "id=5"<br />
								<strong>Fieldtypes:</strong> table1#field1=>type1,table1#field2=>type2<br />
								<strong>Joins:</strong> table|join_table|key|join_key|mode,table|join_table|key|join_key|mode<br />
								<strong>Keys:</strong> table1#key1,table2#key2<br />
							</p>
						</li>
						
						<li><button type="submit" class="btn green" tabindex="3" name="edit[submit]" value="true"><span><span>Weiter</span></span></button></li>
					</ul>
				</fieldset>
			</form>
			
			
				
		<?php elseif ($this->_tpl_vars['page'] == 'edit3'): ?>
			
			<p>Der ContentBereich wurde erfolgreich angelegt!</p>
			
			<p class="button"><a href="<?php echo $this->_tpl_vars['pagePath']; ?>
" class="btn green"><span><span>zur Übersicht</span></span></a></p>


				
		<?php elseif ($this->_tpl_vars['page'] == 'delete1'): ?>
			
			<p class="button"><a href="<?php echo $this->_tpl_vars['pagePath']; ?>
/delete2/<?php echo $this->_tpl_vars['id']; ?>
" class="btn green"><span><span>Contentbereich "<?php echo $this->_tpl_vars['name']; ?>
" wirklich löschen?</span></span></a></p>



		
		
				
		<?php elseif ($this->_tpl_vars['page'] == 'delete2'): ?>
			
			<p>Der ContentBereich wurde gelöscht!</p>
			
			<p class="button"><a href="<?php echo $this->_tpl_vars['pagePath']; ?>
" class="btn green"><span><span>zur Übersicht</span></span></a></p>

		<?php endif; ?>



	</div>
	
	<span class="lt"></span>
	<span class="rt"></span>

	<span class="lb"></span>
	<span class="rb"></span>
</div>