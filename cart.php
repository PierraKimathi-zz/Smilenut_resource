<?php require_once("config.php");?>


<?php

if(isset($_GET['add'])){

$query=query("SELECT * FROM product WHERE product_id=" . escape_string($_GET['add']) . " ");
confirm($query);


while($row=fetch_array($query)){
    
    
if($row['quantity']!= $_SESSION['product_' . $_GET['add']]) {
    
 $_SESSION['product_' . $_GET['add']] +=1;   
    
    redirect("../public/checkout.php");    
}
else{
    
 set_message("We only have" . $row['quantity'] . " " . "available");
    
redirect("../public/checkout.php");
    
    
}     
    
}
}

if(isset($_GET['remove'])){
    
  $_SESSION['product_' . $_GET['remove']]--;

    if( $_SESSION['product_' . $_GET['remove']]<1){
        
unset($_SESSION['item_total']);
unset($_SESSION['item_quantity']);
        
        redirect("../public/checkout.php");
    }else{
        
        redirect("../public/checkout.php");
    }
    
}

if(isset($_GET['delete'])){
  
    $_SESSION['product_' . $_GET['delete']]='0';
    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);
    
     redirect("../public/checkout.php");
}


function cart(){

$total=0;
$item_quantity=0;
$item_name=1;
$item_number=1;
$amount=1;
$quantity=1;
    
foreach($_SESSION as $name => $value){
    
if($value > 0){
   
    if(substr($name,0,8)== "product_"){
      
$length= strlen($name-8);

$id=substr($name,8,$length);
        
$query=query("SELECT * FROM product WHERE product_id= " . escape_string($id) . " ");
confirm($query);
    
while($row=fetch_array($query)){
    
$subtotal=$row['price']*$value;
$item_quantity+=$value;
$product_image = display_image($row['image']);
$product = <<<DELIMETER

 <tr>
<td>{$row['product_name']}<br>

<img width='100' src='../resource/{$product_image}'>
</td>
<td>ksh{$row['price']}</td>
<td>$value</td>
<td>ksh$subtotal</td>
<td><a href="../resource/cart.php?remove={$row['product_id']}">Remove&nbsp</a> 
<a href="../resource/cart.php?add={$row['product_id']}">Add&nbsp</a>
<a href="../resource/cart.php?delete={$row['product_id']}">Delete</a>
</td>              
</tr>

<input type="hidden" name="item_name_{$item_name}" value="{$row['product_name']}">
<input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
<input type="hidden" name="amount_{$amount}" value="{$row['price']}">
<input type="hidden" name="quantity_{$quantity}" value="{$row['quantity']}">

DELIMETER;
    
echo $product;
 
$item_name++;
$item_number++;
$amount++;
$quantity++; 
    
}    
       
 $_SESSION['item_total']=$total+=$subtotal;
$_SESSION['item_quantity']=$item_quantity;       
    }
        
}

}
    

    
}

function show_paypal(){
 
if(isset($_SESSION['item_quantity'])){
    
$paypal_button= <<<DELIMETER

  <input type="image" name="upload"border="0"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">

DELIMETER;
    
return $paypal_button;
    
    }
    
}








?>