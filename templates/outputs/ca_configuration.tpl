
<div class="box" id="configuration">

	<div class="innerTop"></div>
	<div class="innerLeft"></div>
	<div class="innerRight"></div>
	<div class="innerBottom"></div>
	
	<div class="inner">

		<h1>Content-Bereiche</h1>






		{* Startpage - Übersicht *}
		{if $page == "start"}
			<ul>
			{foreach name=uebersicht from=$data item=dataRow}
				<li>
					<a class="delete" href="{$pagePath}/delete/{$dataRow.cb_contentareas_id}">Löschen</a>
					<a class="name" href="{$pagePath}/edit1/{$dataRow.cb_contentareas_id}">{$dataRow.cb_contentareas_name}</a>
	
					{if $smarty.foreach.uebersicht.first}
						<span class="up">Rauf</span>
					{else}
						<a class="up" href="{$pagePath}/up/{$dataRow.cb_contentareas_id}">Rauf</a>
					{/if}
					
					{if $smarty.foreach.uebersicht.last}
						<span class="down">Runter</span>
					{else}
						<a class="down" href="{$pagePath}/down/{$dataRow.cb_contentareas_id}">Runter</a>
					{/if}
				</li>
			{/foreach}
			</ul>
			
			<p class="button"><a href="{$pagePath}/edit1" class="btn green"><span><span>Contentbereich Hinzufügen</span></span></a></p>
		
		
		
		{* Editpage 1 *}
		{elseif $page == "edit1"}
			
			<form class="edit" action="{$pagePath}/edit2" method="post">
				<fieldset>
					<legend>Contentbereich bearbeiten</legend>
					<ul>
						<li>
							<label for="name">Name: </label>
							{if $id > 0}
								<input type="hidden" name="edit[id]" value="{$id}" />
							{/if}
							<input tabindex="1" id="name" name="edit[name]" type="text" value="{$name}" />
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
			
			

		{* Editpage 2 *}		
		{elseif $page == "edit2"}
			
			<form class="edit" action="{$pagePath}/edit3" method="post">
				<fieldset>
					<legend>Contentbereich bearbeiten</legend>
					<input type="hidden" name="edit[id]" value="{$edit_id}" />
					<ul>
						<li>
							<label for="name">Name: </label>
							<input id="name" name="edit[name]" type="text" disabled="disabled" value="{$edit_name}" />
						</li>
						
						<li>
							<label for="tables">Tables: </label>
							<input tabindex="1" id="tables" name="edit[tables]" type="text" value="{foreach from=$tables item=table name=tableForEach}{$table.cb_tables_the_table}{if !$smarty.foreach.tableForEach.last},{/if}{/foreach}" />
						</li>
						
						<li>
							<label for="where">Where: </label>
							<input tabindex="2" id="where" name="edit[where]" type="text" value="{$whereString}" />
						</li>
						
						<li>
							<label for="fieldtypes">Fieldtypes: </label>
							<input tabindex="3" id="fieldtypes" name="edit[fieldtypes]" type="text" value="{foreach from=$fieldTypes item=fieldType name=typeForEach}{$fieldType.cb_fieldtypes_the_table}#{$fieldType.cb_fieldtypes_field}=>{$fieldType.cb_fieldtypes_type}{if !$smarty.foreach.typeForEach.last},{/if}{/foreach}" />
						</li>
						
						<li>
							<label for="joins">Joins: </label>
							<input tabindex="4" id="joins" name="edit[joins]" type="text" value="" disabled="disabled" />
						</li>
						
						<li>
							<label for="keys">Keys: </label>
							<input tabindex="5" id="keys" name="edit[keys]" type="text" value="{foreach from=$keys item=key name=keyForEach}{$key.cb_keys_the_table}#{$key.cb_keys_the_key}{if !$smarty.foreach.keyForEach.last},{/if}{/foreach}" />
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
			
			
		{* Editpage 3 *}		
		{elseif $page == "edit3"}
			
			<p>Der ContentBereich wurde erfolgreich angelegt!</p>
			<p class="button"><a href="{$pagePath}" class="btn green"><span><span>zur Übersicht</span></span></a></p>


		{* Deletepage 1 *}		
		{elseif $page == "delete1"}
			
			<p class="button"><a href="{$pagePath}/delete2/{$id}" class="btn green"><span><span>Contentbereich "{$name}" wirklich löschen?</span></span></a></p>



		
		
		{* Deletepage 2 *}		
		{elseif $page == "delete2"}
			
			<p>Der ContentBereich wurde gelöscht!</p>
			
			<p class="button"><a href="{$pagePath}" class="btn green"><span><span>zur Übersicht</span></span></a></p>

		{/if}



	</div>
	
	<span class="lt"></span>
	<span class="rt"></span>

	<span class="lb"></span>
	<span class="rb"></span>
</div>