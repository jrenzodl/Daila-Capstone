<?php include "includes/sections/header.php"; ?>
<?php include "includes/sections/navbar.php"; ?>
<!-- heading sections -->

<?php
  // checks if logged in ung user else pupunta sa logout.php to end session
  if (!isset($_SESSION['userType'])){
    echo "<script>window.location='logout.php'</script>";
  }
?>

<!-- put all the contents here  -->

<div class="container">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><br><br>
                  View Inventory
              </h1>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
                    <table class="table table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $result = mysqli_query($conn,'SELECT product.name AS productname,
                                                                 product.quantity AS quantity,
                                                                 productType.name AS producttypename,
                                                                 product.productPrice,
                                                                 product.productID AS ID
                                                          FROM product
                                                          INNER JOIN productType ON product.productTypeID=productType.productTypeID');
                            while($row = mysqli_fetch_array($result)){
                              $id = $row['ID'];
                              $prodName = $row['productname'];
                              $prodType = $row['producttypename'];
                              $quantity = $row['quantity'];
                              $price = $row['productPrice'];
                                  echo '<tr>';
                                    echo '<td><a href="viewIndivProduct.php?id='.$id.'">';
                                      echo $prodName;
                                    echo '</a></td>';
                                    echo '<td>';
                                      echo $quantity;
                                    echo '</td>';
                                    echo '<td>';
                                      echo $prodType;
                                    echo'</td>';
                                    echo '<td>';
                                      echo $price;
                                    echo'</td>';
                                    echo '<td class="text-center">';
                                      echo '<a href="makeJobOrder.php?ids='.$id.'&name='.$prodName.'"><button type="button" class="btn btn-primary btn-sm">Restock</button></a> ';
                                    echo '</td>';
                                  echo '</tr>';
                            }
                            echo '<br /><br />';
                            ?>
                            </tbody></table>

          </div>
      </div>
</div>
<br><br><br>

<div class="container">
      <div class="row">
          <div class="col-lg-12">
              <h1 class="page-header"><br><br>
                  View Inventory
              </h1>
          </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
                    <table class="table table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Restock Point</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                            $result = mysqli_query($conn,'SELECT product.name AS productname,
                                                                product.quantity AS quantity,
                                                                productType.name AS producttypename,
                                                                product.productPrice,
                                                                product.productID AS ID,
                                                                ROUND(AVG(productsales.quantity)) AS average
                                                                FROM product
                                                                JOIN productType ON product.productTypeID=productType.productTypeID
                                                                JOIN productsales ON product.productID=productsales.productID
                                                                GROUP BY product.name ');


//                            $result2 = mysqli_query($conn, "SELECT product.name, ROUND(AVG(productsales.quantity))
//                                                                  FROM productsales
//                                                                  JOIN product on productsales.productID=product.productID
//                                                                  GROUP BY product.name ");
//
//
//                            while ($row = mysqli_fetch_array($result2)){
//                                $
//                            }


                            while($row = mysqli_fetch_array($result)){
                              $id = $row['ID'];
                              $prodName = $row['productname'];
                              $prodType = $row['producttypename'];
                              $quantity = $row['quantity'];
                              $price = $row['productPrice'];
                              $reorderPoint = $row['average'];

                              if ($reorderPoint>$quantity){
                                  echo '<div class="alert alert-warning"><strong>Warning!</strong> Product ';
                                  echo $prodName;
                                  echo ' has reached optimal restocking point. Restocking recommended';
                                  echo '</div>';
                              }

                                  echo '<tr>';
                                    echo '<td><a href="viewIndivProduct.php?id='.$id.'">';
                                      echo $prodName;
                                    echo '</a></td>';
                                    echo '<td>';
                                      echo $quantity;
                                    echo '</td>';
                                    echo '<td>';
                                      echo $prodType;
                                    echo'</td>';
                                    echo '<td>';
                                      echo $price;
                                    echo'</td>';
                                    echo '<td>';
                                        echo $reorderPoint;
                                    echo'</td>';
                                    echo '<td class="text-center">';
                                      echo '<a href="makeJobOrder.php?ids='.$id.'&name='.$prodName.'"><button type="button" class="btn btn-primary btn-sm">Restock</button></a> ';
                                    echo '</td>';
                                  echo '</tr>';


                            }

                            echo '<br /><br />';

                            ?>
                            </tbody></table>

          </div>
      </div>
</div>
<br><br><br>

<!-- end of content -->


<?php include "includes/sections/footer.php"; ?>
