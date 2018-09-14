
<div class="container-fluid">

<div class="row">

<h1 class="page-header">
   All Products

</h1>
<h3 class= "bg-success"><?php display_message();?></h3>
<table class="table table-hover">


    <thead>

      <tr>
           <th>Id</th>
           <th>Name</th>
           <th>category</th>
           <th>Price</th>
           <th>quantity</th>
      </tr>
    </thead>
    <tbody>

 <?php get_products_in_admin(); ?>

  </tbody>
</table>











                
                 


             </div>

            </div>
            <!-- /.container-fluid -->

        