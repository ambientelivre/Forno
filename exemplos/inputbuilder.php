<?php
    // deve ser incluida a clase principal do inputbuilder
    include_once '../apps/modules/mod_inputbuilder/InputBuilder.php';
    
    function getProducts() {
        $productsarray = array(
            array("Produto1", "Produto1"),
            array("Produto2", "Produto2")
        );
        return $productsarray;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Teste Input Builder by Ramon</title>
    </head>
    <body>
        <h2>InputBuilder by Ramon91rm - Página de exemplo</h2>
	<h3>Pense no input como uma receita de bolo, mas você monta a sua própria receita!<br>
	Você personaliza o seu input com um array, o qual permite diversos parâmetros, em um estilo que lembra um pouco o CakePHP...
	</h3> 
	<p>
	
	Para instanciar:
	Na pasta do componente (mod_inputbuilder/layouts) ficam as classes de temas, você pode utilizá-las ou criar suas próprias classes.
        A classe Shared é reutilizada entre todas as classes de layout.
	Pegamos por exemplo a classe IB_Chronoforms5.php:
	<pre>	
	$inputbuilder = new InputBuilder();
	$inputbuilder->setDefaultTheme("Chronoforms5"); // o prefixo 		pode ser definido
	Agora é só criar os inputs:

        Obs: não se assuste com a quantidade de linhas,
        ainda assim o código pode ser mais legível e fácil de manusear do que em html comum...
	</pre>
	</p>       
        <fieldset>
            <legend>
                <b>createInput(array($dados)) - Inputs individuais</b>
            </legend>
	<pre>
        echo $inputbuilder->createInput(
            array(                    
                'type' => "select",
                'name' => "teste_class",
                'id' => "teste_id",
                'class' => "teste_class",     
                //'extra_param' => 'size="30"',
                'label' => "Teste testado2",
                'label_for' => "teste_id",
                'input_label' => "radio ou checkbox",
                'data' => "data_value",
                'data_name' => "nome",
                'data_options_name' => "option_data_name",
                //'data_options_value' => "option_data_value",
                'value' => "valor",
                'select_options' => array(
                    array("valor1 - name", "valor1 - value")
                )
            )  
        );
        </pre>
        <?php 
            $inputbuilder = new InputBuilder();
            $inputbuilder->setDefaultTheme("ChronoForms5");

            echo $inputbuilder->createInput(
            array(                    
                'type' => "select",
                'name' => "teste_class",
                'id' => "teste_id",
                'class' => "teste_class",     
                //'extra_param' => 'size="30"',
                'label' => "Teste testado2",
                'label_for' => "teste_id",
                'input_label' => "radio ou checkbox",
                'data' => "data_value",
                'data_name' => "nome",
                'data_options_name' => "option_data_name",
                //'data_options_value' => "option_data_value",
                'value' => "valor",
                'select_options' => array(
                    array("valor1 - name", "valor1 - value")
                )
            )  
        );
        ?>
        </fieldset>
        <br></br>
        <fieldset>
            <legend>
                <b>
                    createInputs($quantidade, array($dados)) - Um único método criando múltiplos inputs
                </b>
            </legend>
        <pre>
        $inputbuilder->createInputs(
            2,
            array(
                'type' => 'text',
                'value'=> 'teste'
            )                
        );
        </pre>
        <?php
        $inputbuilder->createInputs(
            2,
            array(
                'type' => 'text',
                'value'=> 'teste'
            )                
        );
        ?>
        </fieldset>
        <br></br>     
        <fieldset>
            <legend><b>createDataTable(array($dados)) - Uma tabela customizada</b></legend>    
        <pre>
        $inputbuilder->createDataTable(
            array(      
                'extra_param' => 'border="1"',
                'labels' => array(
                    'Produto',
                    'Quantidade',
                    'Valor Unitário (R$)',
                    'Valor Total (R$)',
                    'Detalhes',
                    'Editar',
                    'Excluir'
                    ),
                'hasPrice' => true,
                'extraHeaderRow' => array(
                    array(
                        'content' => 'Teste',
                        'params'  => 'colspan="7" align="center"'
                        )
                ),
                'inputs' => array(
                    array(                 
                        'type' => "select",
                        'name' => "produto[]",
                        'class'=> "chosen-select produto",
                        'select_options' => getProducts()),
                    array(                 
                        'type' => "text",
                        'name' => "qtd[]",
                        'class'=> "qtd",
                        'post_content' => 'CXS')
                ),
                'actions' => array(
                    'details' => 'Detalhes',
                    'edit' => 'Editar',
                    'delete' => 'Excluir'
                ),
                'extraFooterRow' => array(
                    array(
                        'content' => '< button >Adicionar Linha< /button >',
                        'params'  => 'colspan="7" align="center"'
                        )
                )
            )                    
        );
        </pre>
        <?php     
        $inputbuilder->createDataTable(
            array(      
                'extra_param' => 'border="1"',
                'labels' => array(
                    'Produto',
                    'Quantidade',
                    'Valor<br>Unitário<br>(R$)',
                    'Valor<br>Total<br>(R$)',
                    'Detalhes',
                    'Editar',
                    'Excluir'
                    ),
                'hasPrice' => true,
                'extraHeaderRow' => array(
                    array(
                        'content' => 'Teste',
                        'params'  => 'colspan="7" align="center"'
                        )
                ),
                'inputs' => array(
                    array(                 
                        'type' => "select",
                        'name' => "produto[]",
                        'class'=> "chosen-select produto",
                        'select_options' => getProducts()),
                    array(                 
                        'type' => "text",
                        'name' => "qtd[]",
                        'class'=> "qtd",
                        'post_content' => 'CXS')
                ),
                'actions' => array(
                    'details' => 'Detalhes',
                    'edit' => 'Editar',
                    'delete' => 'Excluir'
                ),
                'extraFooterRow' => array(
                    array(
                        'content' => '<button>Adicionar Linha</button>',
                        'params'  => 'colspan="7" align="center"'
                        )
                )
            )                    
        );
        /***** FIM ESBOÇO */
        ?>
        </fieldset>
    </body>
</html>
