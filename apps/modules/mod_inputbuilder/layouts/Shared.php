<?php

class Shared {    
    protected function openInputTag($input) {
        switch($input['type']) {
            case "text":
            case "submit":    
            case "password":  
            case "radio":  
            case "checkbox": 
            case "hidden":
	    case "file":
	    case "number":
                $content = '<input type="'.$input['type'].'"';
                break;
            case "input_button":   
                $content = '<input type="button"';
                break;
            case "button":
            case "textarea":
            case "select":
                $content = '<'.$input['type'];
		break;
	    case "datalist":
		$content = '<input list="'.$input['datalist_id'].'"';
                break;           
            case "radiogroup":
                $content = '<fieldset';
                break;
        }
        return $content;
    }    
    
    protected function buildSelect($input, $default_option = "") {
	switch ($input['type']) {
	case "select":
		if ($default_option != "") {
		    	$content.= '<option value="'.$default_option[0].'" 
			data-'.$input['select_options_data'].'="'.$default_option[2].'">'.$default_option[1].'</option>'; 
		}
		if (!empty($input['select_options'])) {
		    foreach ($input['select_options'] as $object){
		        $content.= '<option value="'.$object[0].'"'; 
                        if (!empty($input['value']) && $input['value'] == $object[0]) {
                            $content .= ' selected';
                        }
			if (!empty($object[2])) {
				$content .= ' data-'.$input['select_options_data'].'="'.$object[2].'"';
			}
			$content.= ' >'.$object[1].'</option>'; 
		    }
		}
		break;
	case "datalist":
		if (!empty($input['select_options'])) {
		    foreach ($input['select_options'] as $object){
		        $content.= '<option value="'.$object[0].'" 
			data-'.$input['select_options_data'].'="'.$object[2].'">'; 
		    }
		}
		break;
        case "radiogroup":
            // acrescentar opçao horizontal ou vertical (horizontal padrao)
            $content .= '<legend>'.$input['fieldset_label'].'</legend>';            
            $content .= '<ul>';                        
            foreach ($input['radiogroup'] as $radio) {
                $content .= '<li class="form-group">';                
                $content .= '<input type="radio" name="'.$input['name'].'" id="'.$radio['id'].'" class="'.$radio['class'].'" value="'.$radio['value'].'"';
                if ((isset($input['checked']['value']) && $radio['value'] == $input['checked']['value'])
                        || (isset($input['checked']['id']) && $radio['id'] == $input['checked']['id'])) {
                    $content .= ' checked';
                } 
                if (!empty($radio['data_name']) && !empty($radio['data'])) {
                    $content .= " data-".$radio['data_name']."='".$radio['data']."'";
                }                
                $content .= ' />';
                $content .= '<label for="'.$radio['id'].'">'.$radio['label'].'</label>';
                $content .= '</li>';
            }
            $content .= '</ul>';
            break;
	}
        return $content;
    }
    
    protected function closeInputTag($input) {
        switch($input['type']) {
            case "radio":  
            case "checkbox":
                $content = $input['input_label'];
                break;                
            case "textarea":
            case "button":
                $content = $input['value'].'</'.$input['type'].'>';
                break;
            case "select":
                $content = '</'.$input['type'].'>';
                break;
            case "radiogroup":
                $content .= '</fieldset>';
                break;
        }
	if (!empty($input['label'])) {
            $content .= "</div>";
        }
        return $content;
    }
    
    protected function getTemplateFooter($label) {
        $content = '</div>';	
        return $content;
    }
}
