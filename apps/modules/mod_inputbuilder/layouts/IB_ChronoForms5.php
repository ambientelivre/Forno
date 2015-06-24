<?php
require_once 'Shared.php';

class IB_ChronoForms5 extends Shared {      
    public $result;
    
    function __construct($input_array) {  
        //print_r($input_array);     
        $header = self::getTemplateHeader($input_array);
        $label  = self::getTemplateLabel($input_array);
        $input  = self::getTemplateContent($input_array);
        $footer = parent::getTemplateFooter($label);        
        $this->result = $header . $label . $input . $footer;   
    }
    
    public function __toString() {
        return $this->result;
    }
    
    protected function getTemplateHeader($input) {
        $content = '<div class="form-group gcore-form-row container_'.$input['class'].'">';
        return $content;
    } 
    
    protected function getTemplateLabel($input) {
        if (!empty($input['label'])) {
            $content = '<label';
            if (!empty($input['label_for'])) {
                $content .= ' for="'.$input['label_for'].'"';
            }
            if ($input['type'] == "hidden") {
                $content .= 'style="visibility: hidden;"';
            }
            $content .= 'class="control-label gcore-label-left">'.$input['label'].'</label>';
            return $content;
        } else {
            return "";
        }
    }
    
    protected function getTemplateContent($input) {
        if (!empty($input['label'])) {
            $content = '<div class="gcore-input gcore-display-table" id="custom_'.$input['name'].'">';        
        }
        
	if (!empty($input['pre_content'])) {
            $content.= $input['pre_content'];
        }

        $content.= parent::openInputTag($input); // Abre   
        $content.= ' class="form-control A '.$input['class'].'"';
        if (!empty($input['id'])) {
            $content .= ' id="'.$input['id'].'"';
        }           
        if (!empty($input['name'])) {
            $content .= ' name="'.$input['name'].'"';
        }    
        if (!empty($input['value'])) {
            $content .= ' value="'.$input['value'].'"';
        }        
        if (!empty($input['data']) && !empty($input['data_name'])) {
            $content .= ' data-'.$input['data_name'].'="'.$input['data'].'"';
        }        
        $content .= ' '.$input['extra_param'];
        $content .= ' >';   
        if ($input['type'] == "select") {
            if (!empty($input['placeholder'])) {
                $default_option = array("", $input['placeholder']);
            }
            $content.= parent::buildSelect($input, $default_option);
        }
        
	/*
        if (!empty($input['label'])) {
            $content .= "</div>";
        }
	*/

        $content.= parent::closeInputTag($input);

	if (!empty($input['post_content'])) {
            $content.= $input['post_content'];
        }
   
        return $content;
    }    
}