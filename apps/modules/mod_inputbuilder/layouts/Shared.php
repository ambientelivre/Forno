<?php

class Shared {    
    protected function openInputTag($input) {
        switch($input['type']) {
            case "text":
            case "password": 
            case "submit":
            case "radio":  
            case "checkbox": 
            case "hidden":
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
        }
        return $content;
    }    
    
    protected function buildSelect($input, $default_option = "") {
        if ($default_option != "") {
            $content.= '<option value="'.$default_option[0].'"';
            if (!empty($input['select_options_data']) && !empty($default_option[2])) {
                $content.= ' data-'.$input['select_options_data'].'="'.$default_option[2].'"';
            }
            $content.= ' >'.$default_option[1].'</option>'; 
        }
        if (!empty($input['select_options'])) {
            foreach ($input['select_options'] as $object){
                $content.= '<option value="'.$object[0].'"';
                if (!empty($input['select_options_data'])) {
                    $content.= ' data-'.$input['select_options_data'].'="'.$object[2].'"';
                }
                $content.= ' >'.$object[1].'</option>'; 
            }
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