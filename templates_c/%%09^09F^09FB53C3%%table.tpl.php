<?php /* Smarty version 2.6.20, created on 2010-06-03 22:06:38
         compiled from /Users/franzwilding/WEB/dev/twidoo/trunk/templates/outputs/table.tpl */ ?>
<div class="box" style="width:auto;">

	<div class="innerTop"></div>
	<div class="innerLeft"></div>
	<div class="innerRight"></div>
	<div class="innerBottom"></div>
	
	<div class="inner" style="overflow-x:auto;">
		
		
		
				<?php if ($this->_tpl_vars['page'] == 'start'): ?>
		<table>
			<tr>
				<?php $_from = $this->_tpl_vars['ths']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['th']):
?>
					<th><?php echo $this->_tpl_vars['th']; ?>
</th>	
				<?php endforeach; endif; unset($_from); ?>
			</tr>
			
			<?php $_from = $this->_tpl_vars['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['datasettable'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['datasettable']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['datarow']):
        $this->_foreach['datasettable']['iteration']++;
?>
				<tr<?php if ((1 & ($this->_foreach['datasettable']['iteration']-1))): ?> class="flag"<?php endif; ?>>
					<?php $_from = $this->_tpl_vars['datarow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cellname'] => $this->_tpl_vars['datacell']):
?>
						<td>
						<?php if ($this->_tpl_vars['cellname'] == $this->_tpl_vars['key']): ?><a href="<?php echo $this->_tpl_vars['pagePath']; ?>
/<?php echo $this->_tpl_vars['ca_key']; ?>
/edit/<?php echo $this->_tpl_vars['datacell']; ?>
"><?php endif; ?>
							<?php echo $this->_tpl_vars['datacell']; ?>

						<?php if ($this->_tpl_vars['cellname'] == $this->_tpl_vars['key']): ?></a><?php endif; ?>
						</td>	
					<?php endforeach; endif; unset($_from); ?>
				</tr>	
			<?php endforeach; endif; unset($_from); ?>
		</table>
		
		<p class="button"><a href="<?php echo $this->_tpl_vars['pagePath']; ?>
/<?php echo $this->_tpl_vars['ca_key']; ?>
/edit" class="btn green"><span><span>Neuer Eintrag</span></span></a></p>
		
				<?php elseif ($this->_tpl_vars['page'] == 'edit'): ?>
		
		
			<form class="edit" action="<?php echo $this->_tpl_vars['pagePath']; ?>
/<?php echo $this->_tpl_vars['ca_key']; ?>
/edit2" method="post">
				<fieldset>
					<legend>Contentbereich bearbeiten</legend>
					<input type="hidden" name="edit[the_incredible_page_id]" value="<?php echo $this->_tpl_vars['id']; ?>
" />
					<ul>
						<?php $_from = $this->_tpl_vars['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['editForm'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['editForm']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['label'] => $this->_tpl_vars['field']):
        $this->_foreach['editForm']['iteration']++;
?>
							<?php $this->assign('varname', ($this->_tpl_vars['tablename'])."_".($this->_tpl_vars['label'])); ?> 
							
							<li>
								<label for="f_<?php echo ($this->_foreach['editForm']['iteration']-1); ?>
"><?php echo $this->_tpl_vars['label']; ?>
: </label>
								<?php if ($this->_tpl_vars['field'] == 'varchar' || $this->_tpl_vars['field'] == 'int' || $this->_tpl_vars['field'] == 'password'): ?>
									<input id="f_<?php echo ($this->_foreach['editForm']['iteration']-1); ?>
" name="edit[<?php echo $this->_tpl_vars['label']; ?>
]" type="text" value="<?php echo $this->_tpl_vars['data'][$this->_tpl_vars['varname']]; ?>
" />
								<?php elseif ($this->_tpl_vars['field'] == 'noedit'): ?>
									<input id="f_<?php echo ($this->_foreach['editForm']['iteration']-1); ?>
" name="edit[<?php echo $this->_tpl_vars['label']; ?>
]" disabled="disabled" type="text" value="" />								
								<?php elseif ($this->_tpl_vars['field'] == 'text'): ?>
									<textarea id="f_<?php echo ($this->_foreach['editForm']['iteration']-1); ?>
" name="edit[<?php echo $this->_tpl_vars['label']; ?>
]"></textarea>
								<?php endif; ?>
							</li>
						<?php endforeach; endif; unset($_from); ?>
							<li>
								<button type="submit" class="btn green" tabindex="3" name="edit[submit]" value="true"><span><span>Speichern</span></span></button>
							</li>
					</ul>
				</fieldset>
			</form>
		
		
		<?php elseif ($this->_tpl_vars['page'] == 'edit2'): ?>
			
			<p>Gespeichert!</p>
			<p class="button"><a href="<?php echo $this->_tpl_vars['pagePath']; ?>
/<?php echo $this->_tpl_vars['ca_key']; ?>
" class="btn green"><span><span>zur Übersicht</span></span></a></p>

		<?php endif; ?>
		
	</div>
	
	<span class="lt"></span>
	<span class="rt"></span>

	<span class="lb"></span>
	<span class="rb"></span>
</div>