<?php
require_once 'Shared.php';

class IB_ChronoForms4 extends Shared {      
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
        if ($input['type'] == "input_button") {
            $content = '<div class="cfdiv_text '.$input['class'].'">';
        } else {            
            $content = '<div class="cfdiv_'.$input['type'].' '.$input['class'].'">';
        }
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
            $content .= '>'.$input['label'].'</label>';
            return $content;
        } else {
            return "";
        }
    }
    
    protected function getTemplateContent($input) {
        //$content = '<div class="" id="custom_'.$input['name'].'">';        
        $content.= parent::openInputTag($input); // Abre    
        
        $content.= ' name="'.$input['name']
                .'" id="'.$input['id']
                .'" class="'.$input['class']                
                .'" data-'.$input['data_name'].'="'.$input['data']
                .'" value="'.$input['value']
                .'" '.$input['extra_param']
                .'>';   
        if ($input['type'] == "select") {
            $default_option = array("", "Selecione uma opção");
            $content.= parent::buildSelect($input, $default_option);
        }
        //$content .= "</div>";
        $content.= parent::closeInputTag($input);   
        return $content;
    }
}
