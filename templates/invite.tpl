<div class="box" id="invite">
	<div class="innerTop"></div>
	<div class="innerLeft"></div>
	<div class="innerRight"></div>
	<div class="innerBottom"></div>
	
	<div class="inner">
		<h1>Weitere Personen einladen, um gemeinsam diese Website zu verwalten</h1>
		<p>contentBox verschickt automatisch Eine Email mit Invitation-Link an die angegebenen Emailadressen.</p>
		
		<form action="invite" method="post">
			<fieldset>
				<legend>Weitere Personen einladen</legend>
				<div class="left">
					<ul>
						<li>
							<label for="emails">Emailadressen: </label>
							<textarea rows="10" cols="30" tabindex="1" id="emails" name="invite[emails]" onfocus="if(this.value=='Emailadressen, der Personen mit Beistrich getrennt eingeben (beispiel1@gmail.com, beispiel2@reflex.at)')this.value=''" onblur="if(this.value=='')this.value='Emailadressen, der Personen mit Beistrich getrennt eingeben (beispiel1@gmail.com, beispiel2@reflex.at)'">Emailadressen, der Personen mit Beistrich getrennt eingeben (beispiel1@gmail.com, beispiel2@reflex.at)</textarea>
						</li>
						<li>
							<label for="text">Einladungstext: </label>
							<textarea rows="10" cols="30" tabindex="2" id="text" name="invite[text]" onfocus="if(this.value=='{$logedinName} läd dich ein, gemeinsam die Website {$title} zu verwalten.')this.value=''" onblur="if(this.value=='')this.value='{$logedinName} läd dich ein, gemeinsam die Website {$title} zu verwalten.'">{$logedinName} läd dich ein, gemeinsam die Website {$title} zu verwalten.</textarea>
						</li>
					</ul>
				</div><!-- left ends here -->
				
				<div class="right">
					<h2>Berechtigungen:</h2>
					<p>Alle Personen, die eingeladen werden, können folgende Inhalte bearbeiten:</p>
					<ul>
						<li>
							<input type="checkbox" id="allowed_23" name="invite[allowed]" value="12" />
							<label for="allowed_23">Newsverwaltung</label>
						</li>
						
						<li>
							<input type="checkbox" id="allowed_23" name="invite[allowed]" value="12" />
							<label for="allowed_23">Newsverwaltung</label>
						</li>
						
						<li>
							<input type="checkbox" id="allowed_23" name="invite[allowed]" value="12" />
							<label for="allowed_23">Newsverwaltung</label>
						</li>
					</ul>
				</div><!-- right ends here -->
					
						<button type="submit" class="btn green" tabindex="3" name="invite[submit]" value="true"><span><span>Einladen</span></span></button>
			</fieldset>
		</form>
	</div>
	
	<span class="lt"></span>
	<span class="rt"></span>
	<span class="lb"></span>
	<span class="rb"></span>
</div>
