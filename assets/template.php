<?php
class TEMPLATE{
	var $html_content;
	
	function getTemplate($file){ //get template 
			$this->html_content = file_get_contents($file);
			return true;
	}

	function setEmpty(){
		$this->html_content='';
		return;
	}

	function setHTML($html){
		$this->html_content=$html;
		return;
	}

	//
	function renew($tag,$content){ //looping, get value
		if (!empty($content)) {
			preg_match($tag,$content,$matches);
			if (isset($matches[1])) {
				$this->html_content = $matches[1];
			}
		}
	}

	function replace($data){ //str_replace
		foreach($data as $tag=>$value){
			if (strpos($tag, '}(.+){')) {
				if (!empty($this->html_content)) {
					if (!isset($value)) {
						$value='';
					}else{
						$value=str_replace('$', '\$', $value);
					}
					$this->html_content = preg_replace($tag,$value,$this->html_content);
				}
			}else{
				if (!empty($this->html_content)){
					if (!isset($value)) {
						$value='';
					}
					$this->html_content = str_replace(substr($tag,'1','-2'),$value,$this->html_content);
				}
			}
		}
	}

	function remove($tag){ //remove spefific code
		if (!empty($this->html_content)) {
			$this->html_content = preg_replace($tag,'',$this->html_content);
		}
	}
	
	function content($write = false,$clear_tags = false){ // want to show or not
		if (!empty($this->html_content)) {
			if($clear_tags){
				$content = preg_replace('/{[\/A-Z0-9_:]+}/s','',$this->html_content);
			}else{
				$content = $this->html_content;
			}
			if($write){echo $content;}else{return $content;}
		}
	}

	function loadLanguageFile($lang_array){
		foreach($lang_array as $lang_key => $lang_value){
			$this->html_content = str_replace('{'.$lang_key.'}',$lang_value,$this->html_content);
		}
	}
}
/*
$_temp = new TEPLATE();
$_temp->getTemplate();
$_temp->remove('/{START}(.+){END}/s')


$new_temp = new TEMPLATE();
$new_temp->renew('/{START}(.+){END}/s',$_temp);

$_temp->replace(array('/{MESSAGES}/s'=>'Your message'))
*/

?>