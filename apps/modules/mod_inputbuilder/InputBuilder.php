<?php

/**** Estrutura para geração de inputs e outros conteúdos para páginas web
 * Minha intenção é futuramente transformar isso em um mini-framework,
 * ou pelo menos um 'canivete suíço'...
 * 
 * Autor: Ramon Marcondes
 * Versão atual: 0.3 alpha (05/2015)
 * 
 * Linha do tempo:
 * Se tornará 'beta' a partir da versão 0.5
 * SE tornará 'release' a partir da versão 1.0
 * 
 * TODO (para fazer) - Versão 0.3 alpha, ou futuramente
 * - fazer lista de array dos parâmetros permitidos,
 * quaisquer parametros nao referentes a esses serão removidos/tratados;
 * - Permitir criar input do tipo 'submit' e outros tipos de conteúdo
 * - Ver se é possível evitar produtos idênticos caso haja campo de quantidade
 * - Outras correções de código e segurança
 * - Novas funcionalidades que possam ser interessantes
 * 
 * VERSÃO 0.2 alpha:
 * - Correções na abertura/fechamento de tags div para os layouts pré-definidos
 * - Implementada base de geração de layout na classe Shared ao invés do
 * IB_DEFAULT. Também permite (de uma forma rudimentar) que os métodos de layout sobrescrevam
 * os métodos de layout padrao da classe Shared (devo estudar melhor Override e Overload)
 * - Não cria div com label no caso de input hidden
 * - Método 'createInputs', para criação de multiplos inputs em uma única chamada
 * - Método 'createDataTable', para criar mini-tabelas visuais customizadas
 * (para relatórios, pedidos, etc)
 * 
 * Versão 0.1 alpha:
 * Possibilidade de usar usar mais de 1 tema em uma página
 * (Ex: input1 com tema Joomla2, input2 com tema Joomla3)
 * 
 * Versão 0.05 pre-alpha:
 * Implementadas funcionalidades básicas
 * 
 */

/*** Como chamar em um arquivo de layout em PHP:
 * 1 - Dar include ou require dessa classe. Ex: include /pasta/InputBuilder.php
 * 2 - $variavel = new InputBuilder();
 * 3 - Chamar método de criação de input, enviando os parâmetros necessários:
 * $variavel->createInput($data, $classe) - este pode ser chamado para quantos inputs forem necessário;
 * Explicação detalhada dos parâmetros logo abaixo.
 */
class InputBuilder {
    private $default;
    private $alternateFolder;
    private $prefix = "IB_";
    
    /*** Parâmetros possíveis - exemplo:
    * @data - array com os posśiveis dados: 
        * @type - Tipo do input html {
        * Valores possíveis:
            * text - campo de texto
            * password - campo de senha
            * button, gera um botão com a tag html <button>
            * input_button - gera um botão com a tag html <input type="button">
            * textarea - área para textos mais extensos
            * select - combobox com dropdowns
        }
        * @name => nome do elemento, é enviado no submit
        * @id => id do elemento
        * @class => classe do elemento     
        * @extra_param => outros parâmetros html. Ex: disabled,
        * @label => label de descrição para inputs,
        * @label_for => id do input especificado o qual o label será relacionado,
        * @input_label => label do próprio input, somente para inputs do tipo "radio" e "checkbox"
        * @data_name => nome do atributo "data-*" do elemento (para outros usos, oficializado no HTML5)
        * @data => valor do atributo "data"        
        * @data_options_name => (somente para selects) atributo data para opções de escolha do <select> (<option>)
        * @data_options_value => (somente para selects) valor do atributo data para o <option>,
        * @value => valor do input,
        * @select_options => array com nome texto e value para <option>. Ex: array("texto", "valor")
    * @class - classe a ser usada, com layout pré-definido
    */            
    
    // Classe responsável por criar o input
    public function createInput($data = "", $themeclass = "") { 
        $defaultTheme = $this->getDefaultTheme();
        if (!empty($themeclass)) {
            $class = $this->prefix.$themeclass;
        } else {
	    if (!empty($defaultTheme)) {
                $class = $this->prefix.$defaultTheme;
	    } else { // Se não tiver nenhum tema definido, usa a classe Default
		$class = $this->prefix."Default";
	    }            
        }
        //echo "Classe: " . $class;
        if (!empty($data) && $class != "") {
            $classname = $class.".php";
            $dir = dirname(__FILE__)."/layouts/".$classname; // Diretório padrão dos temas
            
            if (!file_exists($dir)) {
                // Se não localizar os temas no diretório padrão,
                // Pode ser definido um diretório 'alternativo'...
                $dir = $this->getAlternateFolder()."/layouts/".$classname;
            }
            
            //echo $dir;
            if (!empty($class) && file_exists($dir)) {
                require_once $dir;
                return new $class($data);
            }
        }
    }
    
    /***** ESBOÇO - Métodos dentro dessa faixa ainda NÃO estão funcionanado */
    // Ainda em esboço... E ver se usarei função customizada por tema
    // para deixar o conteúdo o mais dinâmico possível
    public function createDataTable($input, $themeclass = "") {
        //print_r($input);
        
        // Cabecalho
        $content = '<table '.$input['extra_param'].'>';
        
        // Labels
        foreach ($input['labels'] as $label) {
            $content .= '<th>'.$label.'</th>';
        }
        /*
        foreach ($input['actions'] as $action) {
            if ($action) {
                $content .= '<th>'.$action.'</th>';
            }
        }        
        */
        
        // Conteudo
        if (!empty($input['extraHeaderRow'])) {
            foreach($input['extraHeaderRow'] as $row) {
                $content .= $this->createRow($row);
            } 
        }
        
        $content .= "<tr class='item'>";    
        
        for ($i = 0; $i < count($input['inputs']); $i++) {
            if (!empty($input['inputs'][$i]['type']) && $input['inputs'][$i]['type'] != 'hidden') {
                $content .= $this->createColumn($this->createInput($input['inputs'][$i], $themeclass));
            } else {
                $content .= $this->createColumn($this->createInput($input['inputs'][$i], $themeclass), 'none');
            } 
        }     
                
        if (!empty($input['hasPrice'])) {
            $content .= $this->createColumn(
                '<span class="sp_val_unit"></span>'
                .'<input class="valor_unitario" name="valor_unitario[]" type="hidden">'
            );
            $content .= $this->createColumn(
                '<span class="sp_val_total"></span>'
                .'<input class="valor_total" name="valor_total[]" type="hidden">'
            );
        }
        
        if (!empty($input['actions'])) {
            foreach($input['actions'] as $action_key => $action) {
                switch ($action_key) {
                    case 'details':
                        $content .= $this->createColumn($action);
                        break;
                    case 'edit':
                        $content .= $this->createColumn($action);
                        break;
                    case 'delete':
                        $content .= $this->createColumn($action);
                        break;
                } 
            }    
        }
        
        if (!empty($input['extraFooterRow'])) {
            foreach($input['extraFooterRow'] as $row) {
                $content .= $this->createRow($row);
            }        
        }        
        $content .= "</tr>";
        
        // Rodape
        $content .= '</table>';
        
        echo $content; 
    }
    
    public function createRow($input) {
        $content = '<tr>';
        $content .= '<td '.$input['params'].'>';
        $content .= $input['content'];
        $content .= '</td>';
        $content .= '</tr>';
        return $content;
    }
    
    public function createColumn($input, $display = "") {  
        if (!empty($display)) {
            $content = '<td style="display: '.$display.'">';            
        } else {
            $content = '<td>';
        }
        
        $content .= $input;
        $content .= '</td>';
        return $content;
    }
    
    // Cria múltiplos inputs (idênticos ou não caso haja alguma condição dinâmica)
    public function createInputs($quantity, $input, $themeclass = "") { 
        //$objects = array();
        for($i = 0; $i < $quantity; $i++) {
            //array_push($objects, $this->createInput($input, $themeclass));
            echo $this->createInput($input, $themeclass);
        } 
        //return $objects;
    }
    /***** FIM ESBOÇO */
    
    // Define tema padrão (obs: se um input receber um tema específico, 
    // usará o tema que lhe foi definido ao invés do padrão)
    public function setDefaultTheme($newDefault){
        $this->default = $newDefault;
    }
    
    public function getDefaultTheme(){
        return $this->default;
    }        
    
    public function setAlternateFolder($newFolder){
        $this->alternateFolder = $newFolder;
    }
    
    public function getAlternateFolder(){
        return $this->alternateFolder;
    }           
}