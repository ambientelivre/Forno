var cobaia;
var coluna = ".row_item";
var add_item = ".add_item";
var remove_item = ".remove_item";
var produto = ".produto";
var produto_nome = ".produto_nome";
var produto_qtd = ".produto_qtd";
var produto_valor = ".produto_valor";
var produto_total = ".produto_total";
var pedido_total_txt = ".pedido_total_txt";
var pedido_total = ".pedido_total";
var money = 1;
var chosen_element = "select";

jQuery(document).ready(function($){   
    cobaia = $(coluna+":first").clone(true); // clone   
    sumAll();
    $(add_item).click(function() {
        addItem();
    });    
    // ao adicionar um novo elemento clone 
    rearrangeCart();
});

function addItem() {
    var parent_item = $(coluna).last();
    cobaia.clone(true).insertAfter(parent_item);        
    rearrangeCart();
}

function refreshCartList(item) {
    var parentItem = $(item).closest(coluna)    
    var product = $("option:selected", parentItem.find(produto));
    var value = product.data("valunit");
    var qtd = parentItem.find(produto_qtd);
    
    if (product.val() == "") {
        qtd.attr("readonly", true).val("");        
        parentItem.find(produto_nome).val("");
        parentItem.find(produto_valor).val("");
        parentItem.find(produto_total).val("");
    } else {    
        qtd.attr("readonly", false); 
        if (qtd.val() == "") {
            qtd.val('1');
        }             
        parentItem.find(produto_nome).val(product.text());
        if (money == 1) {            
            parentItem.find(produto_valor).val(parseFloat(value).toFixed(2));            
            if (!isNaN(value)) {
                parentItem.find(produto_total).val(parseFloat(value * qtd.val()).toFixed(2));
            }        
        }
    }
    sumAll();
}

function sumAll() {
    if (money == 1) {
        var total = 0;
        $(produto_total).each(function(){
            var valor = parseFloat($(this).val());
            if (!isNaN(valor)) {
                total += valor;
            }
        });
        $(pedido_total_txt).html(total.toFixed(2));
        $(pedido_total).val(total.toFixed(2));
    }
}

function removeItem(item) {
    var itemLength = $(coluna).length;
    if(itemLength > 1){ // Manter pelo menos uma coluna para produto
        $(item).remove();
    }
    sumAll();
}

/*** Ao criar um novo elemento clone, é preciso resetar os eventos
 * de cada clone existente na lista  */
function rearrangeCart() {   
    // seta chosen no clone após processá-lo completamente, evitando bug de width com valor 'undefined'
    setChosen(chosen_element);
    
    $(produto).change(function() {
        refreshCartList(this);
    });       
    $(produto_qtd).click(function() {
       refreshCartList(this);
    });
    $(produto_qtd).keyup(function() {
        if (!$.isNumeric($(this).val()) || $(this).val() <= 0) {
            $(this).val("1");            
        }
        refreshCartList(this);
    });    
    $(remove_item).click(function(){
        removeItem($(this).closest(coluna));
    });       
}

function setChosen(element) {
    if ($(element).length) {  
    	$(element).chosen(); 
    }
}

function setMoney(value) {
    money = value;
}
