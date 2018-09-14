
<?php



if(isset($_GET['id'])) {


$query = query("SELECT * FROM product WHERE product_id = " . escape_string($_GET['id']) . " ");
confirm($query);

while($row = fetch_array($query)){

$product_name        = escape_string($row['product_name']);
$product_category_ID = escape_string($row['product_category_ID']);
$description         = escape_string($row['description']);
$price               = escape_string($row['price']);
$quantity            = escape_string($row['quantity']);
$image               = escape_string($row['image']);


$image = display_image($row['image']);


}


update_product();

}




?>



<div class="col-md-12">

<div class="row">
<h1 class="page-header">
   Edit Product

</h1>
</div>
               


<form action="" method="post" enctype="multipart/form-data">


<div class="col-md-8">

<div class="form-group">
    <label for="product-title">Product Title </label>
        <input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>">
       
    </div>


    <div class="form-group">
           <label for="product-title">Product Description</label>
      <textarea name="description" id="" cols="30" rows="10" class="form-control"><?php echo $description; ?></textarea>
    </div>



    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-price">Product Price</label>
        <input type="number" name="price" class="form-control" size="60" value="<?php echo $price; ?>">
      </div>
    </div>



    
    

</div><!--Main Content-->


<!-- SIDEBAR-->


<aside id="admin_sidebar" class="col-md-4">

     
     <div class="form-group">
       <input type="submit" name="draft" class="btn btn-warning btn-lg" value="Draft">
        <input type="submit" name="update" class="btn btn-primary btn-lg" value="update">
    </div>


     <!-- Product Categories-->

    <div class="form-group">
         <label for="product-title">Product Category</label>
          
        <select name="product_category_ID" id="" class="form-control">
            <option value="<?php echo $product_category_ID; ?>"><?php echo show_product_category_name($product_category_ID); ?></option>
           
           <?php show_categories_add_product_page(); ?>

        </select>


</div>





    <!-- Product Brands-->


    <div class="form-group row">

      <div class="col-xs-3">
        <label for="product-title">Product Quantity</label>
        <input type="number" name="quantity" class="form-control" size="60" value="<?php echo $quantity; ?>">
      </div>
    </div>



<!-- Product Tags -->


   <!-- <div class="form-group">
          <label for="product-title">Product Keywords</label>
          <hr>
        <input type="text" name="product_tags" class="form-control">
    </div>
s-->
    <!-- Product Image -->
    <div class="form-group">
        <label for="product-title">Product Image</label>
        <input type="file" name="file"> <br>
      
      <img width='200' src="../../resource/<?php echo $image; ?>" alt="">

    </div>



</aside><!--SIDEBAR-->


    
</form>

