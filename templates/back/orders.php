<?php require_once("../../resource/config.php");?>
        
<?php include(TEMPLATE_BACK . "/headers.php");?>



        <div id="page-wrapper">

            <div class="container-fluid">


                


        <div class="col-md-12">
<div class="row">
<h1 class="page-header">
   All Orders


</h1>

<h4 class= "bg-success"><?php display_message();?></h4>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>orders_id</th>
           <th>amount</th>
           <th>transaction</th>
           <th>status</th>
           <th>currency</th>
           
      </tr>
    </thead>
    <tbody>
    
   <?php display_orders(); ?>
 </tbody>
</table>
</div>











            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

   <?php include(TEMPLATE_BACK . "/footer.php"); ?>