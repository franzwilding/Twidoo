<div class="box" style="width:auto;">

	<div class="innerTop"></div>
	<div class="innerLeft"></div>
	<div class="innerRight"></div>
	<div class="innerBottom"></div>
	
	<div class="inner" style="overflow-x:auto;">
		
		
		
		{* PAGE START *}
		{if $page == "start"}
		<table>
			<tr>
				{foreach from=$ths item=th}
					<th>{$th}</th>	
				{/foreach}
			</tr>
			
			{foreach from=$data item=datarow name=datasettable}
				<tr{if $smarty.foreach.datasettable.index is odd} class="flag"{/if}>
					{foreach from=$datarow key=cellname item=datacell}
						<td>
						{if $cellname == $key}<a href="{$pagePath}/{$ca_key}/edit/{$datacell}">{/if}
							{$datacell}
						{if $cellname == $key}</a>{/if}
						</td>	
					{/foreach}
				</tr>	
			{/foreach}
		</table>
		
		<p class="button"><a href="{$pagePath}/{$ca_key}/edit" class="btn green"><span><span>Neuer Eintrag</span></span></a></p>
		
		{* PAGE EDIT *}
		{elseif $page == "edit"}
		
		
			<form class="edit" action="{$pagePath}/{$ca_key}/edit2" method="post">
				<fieldset>
					<legend>Contentbereich bearbeiten</legend>
					<input type="hidden" name="edit[the_incredible_page_id]" value="{$id}" />
					<ul>
						{foreach from=$fields item=field key=label name=editForm}
							{assign var="varname" value="`$tablename`_`$label`"} 
							
							<li>
								<label for="f_{$smarty.foreach.editForm.index}">{$label}: </label>
								{if $field == "varchar" || $field == "int" || $field == "password"}
									<input id="f_{$smarty.foreach.editForm.index}" name="edit[{$label}]" type="text" value="{$data[$varname]}" />
								{elseif $field == "noedit"}
									<input id="f_{$smarty.foreach.editForm.index}" name="edit[{$label}]" disabled="disabled" type="text" value="" />								
								{elseif $field == "text"}
									<textarea id="f_{$smarty.foreach.editForm.index}" name="edit[{$label}]"></textarea>
								{/if}
							</li>
						{/foreach}
							<li>
								<button type="submit" class="btn green" tabindex="3" name="edit[submit]" value="true"><span><span>Speichern</span></span></button>
							</li>
					</ul>
				</fieldset>
			</form>
		
		
		{elseif $page == "edit2"}
			
			<p>Gespeichert!</p>
			<p class="button"><a href="{$pagePath}/{$ca_key}" class="btn green"><span><span>zur Übersicht</span></span></a></p>

		{/if}
		
	</div>
	
	<span class="lt"></span>
	<span class="rt"></span>

	<span class="lb"></span>
	<span class="rb"></span>
</div>