<?php
/************************************************************/
/************************************************************/
/************** TWIDOO by FRANZ WILDING - 2008 **************/
/********** MORE INFOS at twidoo.frant-wilding.eu ***********/
/************************************************************/
/************************************************************/


/********** TWIDOO _ FORM *************/
class twidoo_form
{
	var $identificator;
	var $values;
	var $files;
	var $errors;
	var $requiredfields;
	var $rules;
	var $honeypot;

	function twidoo_form($identi='FORM')
	{
		$this->identificator = $identi;
		if(isset($_REQUEST[$this->identificator]))
			$this->values = $_REQUEST[$this->identificator];
					
		$this->files = array();
		$this->errors = array();
		$this->requiredfields = array();
		$this->rules = array();
		$this->honeypot = '';
	}
	
	//liefert alle values aus dem form
	function getValues()
	{
		return $this->values;
	}
	
	//checkt, ob der submit-button gedrŸckt wurde
	function formSubmit()
	{
		if($this->values['submit'] == 'true')
			return true;
		
		return false;
	}
	
	//kalkuliert die Errors, und gibt entweder true, wenn es keine gibt, oder false, wenn es welche gibt
	function formErrors()
	{
		//zuerst mŸssen wir immer alle Errors lšschen, um sie nachher neu zu erstellen
		$this->errors = array();
		
		//nur, wenn Form schon abgeschickt wurde
		if($this->formSubmit())
		{
			//schaut, ob die Pflichtfelder eh ausgefŸllt sind
			foreach($this->requiredfields as $requiredfield)
			{
				//wenn das Feld kein Datei-Feld it, ...
				if(!in_array($requiredfield, $this->files))
				{
					if($this->values[$requiredfield] == "")
						$this->setError($requiredfield, 'empty');
				}
				//wenn doch, muss ich im $_FILES array nachschauen, ob das Feld ausgefüllt wurde
				else
				{
					if(array_key_exists($requiredfield, $_FILES[$this->identificator]['name']))
					{
						if($_FILES[$this->identificator]['name'][$requiredfield] == '')
							$this->setError($requiredfield, 'empty');
					}
					else
					{
						$this->setError($requiredfield, 'empty');
					}
				}
			}
		}
		
		//checkt alle Regeln
		foreach($this->rules as $rule)
		{
			switch($rule[1])
			{
				case 'valid': 
						if(!$this->validator($rule[0], $rule[2]))
							$this->setError($rule[0], 'notvalid');
					break;
				case 'sameas':
						if($this->values[$rule[0]] != $this->values[$rule[2]])
						{
							$this->setError($rule[0], 'notthesame');
							$this->setError($rule[2], 'notthesame');
						}
					break;
			}
				
		}
		
		if(!$this->formSubmit() || 0 == count($this->errors))
			return true;
		else
			return false;
	}
	
	//liefert uns die Errors
	function getErrors()
	{
		if($this->formErrors())
			return array();
		else
			return $this->errors;
	}
	
	function getValue($name)
	{
		if(array_key_exists($name, $this->values))
			return $this->values[$name];
		else
			return "";
	}
	
	function setError($key, $value)
	{
		if(!array_key_exists($key, $this->errors))
			$this->errors[$key] = array($value);
		else
			array_push($this->errors[$key], $value);
			
	}

	//liefert true zurŸck, wenn der submit-button gedrŸckt wurde, und es keine Fehler gibt
	function formDone()
	{
		if($this->formSubmit() && $this->formErrors() && $this->checkHoneyPot() && $this->moveFiles())
			return true;
			
		return false;
	}
	
	//setzt die Pflichtfelder
	function setRequired($name)
	{
		array_push($this->requiredfields, $name);
	}
	
	//holt einmal alle Regeln fŸr die einzelnen Felder
	function setRule($field, $opererator, $value='')
	{
		array_push($this->rules, array($field, $opererator, $value));
	}
	
	//checkt, ob der eingegebene Wert auch valide ist. die Regeln werden hier bestimmt
	function validator($field, $type)
	{
	
		switch($type)
		{
			case 'email' :
					if(preg_match("/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i",$this->values[$field]))
						return true;
				break;
			case 'date' :
				if(preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $this->values[$field]))
					return true;
		}
		
		return false;	
	}
	
	function setHoneyPot($identy)
	{
		$this->honeypot = $identy;
	}
	
	function checkHoneyPot()
	{
		if(array_key_exists($this->honeypot, $this->values) && $this->values[$this->honeypot] != "")
			return false;
		
		return true;
	}
	
	//der klasse sagen, wenn ein Feld ein Fileupload ist
	function setFile($fieldname)
	{
		array_push($this->files, $fieldname);
	}
	
	//verschiebt hochgeladene Dateien aus ihrem ursprungsverzeichnis in ihr Zielverzechnis
	function moveFiles()
	{
		global $TWIDOO;
		
		if(count($this->files) > 0)
		{
			//wir gehen alle Files durch, die gerade hochgeladen wurden
			foreach($_FILES[$this->identificator]['name'] as $key => $file)
			{
				//wenn jetzt eines vorkommt, dass auch angegeben wurde, beginne ich es in den richtigen Ordner zu verschieben
				if(in_array($key, $this->files))
				{
					move_uploaded_file($_FILES[$this->identificator]['tmp_name'][$key], $TWIDOO['includepath'].'/'.$this->values[$key]['destination'].'/'.$file);
					$this->values[$key] = $this->values[$key]['destination'].'/'.$file;
				}
			}
		}
		return true;
	}
	
}

?>