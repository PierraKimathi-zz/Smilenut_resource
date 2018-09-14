<?php
$uploads_directory = "uploads";

function set_message($msg){

if(!empty($msg)) {


    $SESSION['message'] = $msg;

} else {


    $msg = "";
}



}

function display_message() {


    if(isset($_SESSION['message'])) {

        echo $_SESSION['message']; 
        unset($_SESSION['message']);
    }
}
function redirect($location){
    header("Location: $location");
}

function query($sql){
    
    global $connection;
    return mysqli_query($connection,$sql);
}

function confirm($result){
    global $connection;
    
    if(!$result){
        
        die("QUERY FAILED" . mysqli_error($connection));
    }
}


function escape_string($string){
    global $connection;
    
    return mysqli_real_escape_string($connection,$string);
}

function fetch_array($result){
    
    
    return mysqli_fetch_array($result);
}


function get_product(){



    $query = query("SELECT * FROM product");

    confirm($query);

    while($row = fetch_array($query)){

$image = display_image($row['image']);

 $product = <<<DELIMETER
   <div class="col-sm-4
 col-lg-4 col-md-4">
   <div class="thumbnail">
  <a href = "item.php?id={$row['product_id']}"><img src="../resource/{$image}" alt=""></a>
   <div class="caption">
   <h4 class="pull-right">ksh{$row['price']}</h4>
   <h4><a href="item.php?id={$row['product_id']}">{$row['product_name']}</a>
  </h4>
  <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
  <a class="btn btn-primary" target="_blank" href="../resource/cart.php?add={$row['product_id']}">Add to cart</a>
  </div>

</div>
</div>

        
DELIMETER;
echo $product;
        
    }
}



function get_category(){
     $query=query("SELECT * FROM category");  
            confirm($query);
                   while($row = fetch_array($query)){
                    
$category_link = <<<DELIMETER

<a href="category.php?id={$row['category_ID']}" class="list-group-item">{$row['category_name']}</a>       
      
      
DELIMETER;
            
echo $category_link;   
                       
           } 
    
    
}



function get_product_from_category_page(){
    
    $query=query("SELECT * FROM product WHERE product_category_ID= " . escape_string($_GET['id']) . " ");
    confirm($query);
    
    while($row=fetch_array($query)){
        
$product = <<<DELIMETER
        
    <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

        
DELIMETER;
echo $product;
        
       
        
    }
}



function get_product_from_shop_page(){
    
    $query=query("SELECT * FROM product");
    confirm($query);
    
    while($row=fetch_array($query)){
        $image = display_image($row['image']);
$product = <<<DELIMETER
        
    <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resource/{$image}" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resource/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

        
DELIMETER;
echo $product;
        
       
        
    }
}

function get_products_in_cat_page(){
    
     $query=query("SELECT * FROM product WHERE product_category_ID= " . escape_string($_GET['id']) . " ");
    confirm($query);
    
    while($row=fetch_array($query)){
        $image = display_image($row['image']);
$product = <<<DELIMETER
        
    <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="../resource/{$image}" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="../resource/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

        
DELIMETER;
echo $product;
        
       
        
    }
}

function login_user(){

if(isset($_POST['submit'])){



   $username = escape_string($_POST['username']);
   $password = escape_string($_POST['password']);


   $query = query("SELECT * FROM users WHERE username = '{$username}' and password = '{$password}'");
    confirm($query);
    

    if(mysqli_num_rows($query) == 0) {

set_message("Your username or password are wrong");
        redirect("login.php");
    } else {
        $_SESSION['username']=$username;
        redirect("admin"); 
    }
}




}

function send_message(){

 if(isset($_POST['submit'])){

    $to        = "pierramwende@gmail.com";
    $from_name = $_POST['name'];
    $subject   = $_POST['subject'];
    $email     = $_POST['email'];
    $message   = $_POST['message'];


$headers = "From: {$from_name} {$email}";

$result = mail($to, $subject, $message, $headers);

if(!$result){


 set_message("Sorry we could not sent your message");
redirect("contact.php");
} else {


    set_message("Your Message has been sent");
    redirect("contact.php");
}


    }
}


/****************************BACK END FUNCTIONS**********************************/


function display_orders() {


$query=query("SELECT * FROM orders");
    confirm($query);

while($row = fetch_array($query)){
        
$orders = <<<DELIMETER

<tr>
<td>{$row['orders_id']}</td>
<td>{$row['amount']}</td>
<td>{$row['transaction']}</td>
<td>{$row['status']}</td>
<td>{$row['currency']}</td>
<td><a class="btn btn-danger" href="../../resource/templates/back/delete_order.php?id={$row['orders_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>


DELIMETER;

echo $orders;
}

}


/*****************************Admin Products page **************************/
function display_image($picture){

global $uploads_directory;
    return $uploads_directory . DS .$picture;
}


function get_products_in_admin(){

    $query = query("SELECT * FROM product");

    confirm($query);

    while($row = fetch_array($query)){
$category = show_product_category_name($row['product_category_ID']);

$image = display_image($row['image']);

 $product = <<<DELIMETER
    <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_name']} <br>
              <a href="index.php?edit_product&id={$row['product_id']}"><img width='100' src="../../resource/$image" alt=""></a>
            </td>
            <td>{$category}</td>
            <td>{$row['price']}</td>
            <td>{$row['quantity']}</td>
            <td><a class="btn btn-danger" href="../../resource/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>
      

        
DELIMETER;
echo $product;
        
    }


}


function show_product_category_name($product_category_ID){


$category_query = query("SELECT * FROM category WHERE category_ID = '{$product_category_ID}' ");

confirm($category_query);

while($category_row = fetch_array($category_query)) {
 
    return $category_row['category_name'];
}




}






/********************************Add products in admin***************************/
function add_product(){

if(isset($_POST['publish'])) {

$product_name        = escape_string($_POST['product_name']);
$product_category_ID = escape_string($_POST['product_category_ID']);
$description         = escape_string($_POST['description']);
$price               = escape_string($_POST['price']);
$quantity            = escape_string($_POST['quantity']);
$image               = escape_string($_FILES['file']['name']);
$image_temp_location = escape_string($_FILES['file']['tmp_name']);
 move_uploaded_file($image_temp_location , UPLOAD_DIRECTORY . DS . $image);
 

 $query = query("INSERT INTO product(product_name, product_category_ID, description, price, quantity, image) VALUES('{$product_name}', '{$product_category_ID}', '{$description}', '{$price}', '{$quantity}', '{$image}')");

confirm($query);
set_message("New Product was Added");
redirect("index.php?products");


  
}






}

function show_categories_add_product_page(){
     $query=query("SELECT * FROM category");  
    confirm($query);
    while($row = fetch_array($query)){
                    
$category_options = <<<DELIMETER

 <option value="{$row['category_ID']}">{$row['category_name']}</option>      
      
DELIMETER;
            
echo $category_options;   
                       
           } 
    
    
}

/***************** Updating product  code **************************/


function update_product(){

if(isset($_POST['update'])) {

$product_name        = escape_string($_POST['product_name']);
$product_category_ID = escape_string($_POST['product_category_ID']);
$description         = escape_string($_POST['description']);
$price               = escape_string($_POST['price']);
$quantity            = escape_string($_POST['quantity']);
$image               = escape_string($_FILES['file']['name']);
$image_temp_location = escape_string($_FILES['file']['tmp_name']);
 
if(empty($image)) {


    $get_pic = query("SELECT image FROM product WHERE product_id =" .escape_string($_GET['id']). " ");

confirm($get_pic);

while($pic =fetch_array($get_pic)) {

    $image = $pic['image'];


}

}    


 move_uploaded_file($image_temp_location , UPLOAD_DIRECTORY . DS . $image);
 

 $query ="UPDATE product SET ";
$query .="product_name        = '{$product_name}'        , ";
$query .="product_category_ID = '{$product_category_ID}' , ";
$query .="description         = '{$description}'         , ";
$query .="price               = '{$price}'               , ";
$query .="quantity            = '{$quantity}'              ";
$query .="WHERE product_id=" . escape_string($_GET['id']);






$send_update_query = query($query);
confirm($send_update_query);
set_message("Product has been Updated");
redirect("index.php?products");


  
}






}


/**********************categories in admin *******************************/

function show_categories_in_admin() {



$category_query = query("SELECT * FROM category");
confirm($category_query);

while($row = fetch_array($category_query)) {

    $category_ID = $row['category_ID'];
    $category_name = $row['category_name'];

$category = <<<DELIMETER

         <tr>
            <td>{$category_ID}</td>
            <td>{$category_name}</td>
        </tr>      
DELIMETER;
            
echo $category;   

   }

}


function add_category() {

    if(isset($_POST['add_category'])) {

    $category_name = escape_string($_POST['category_name']);
    $insert_cat = query("INSERT INTO category(category_name) VALUES('{$category_name}') ");
    confirm($insert_cat);
    redirect("index.php?categories");

    }
}


?>
 