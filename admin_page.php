<?php
@include 'config.php';
if( isset($_POST['add_product'])){
    $product_name=$_POST['product_name'];
    $product_price=$_POST['product_price'];
    $product_image=$_FILES['product_image']['name'];
    $product_image_tmp_name=$_FILES['product_image']['tmp_name'];
    $product_image_folder='uploaded_img/'.$product_image;
    if(empty($product_name) || empty($product_price)|| empty($product_image)){
        $message[]='please fill out all';
    }else{
        $insert="INSERT INTO products(name, price,image)values('$product_name',' $product_price',
       '$product_image' )";
       $upload = mysqli_query($conn,$insert);
       if($upload){
           move_uploaded_file($product_image_tmp_name, $product_image_folder);
           $message[]='new product added successfuly';
       }else{
           $message[]='could not add the product';
       }
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    if(isset($message)){
        foreach($message as $message){
            echo '<span class="message">'.$message.'</span>';
        }
    }
    ?>
    <div class="container">
        <div class="admin-product-form-container">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <h3>add new product</h3>
            <input type="text" placeholder="enter product " name="product_name" class="box">
            <input type="number" placeholder="enter product price" name="product_price" class="box">
            <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
            <input type="submit" class="btn" name="add_product" value="add product"  >
        </form>
        </div>
        <?php
        $select =mysqli_query($conn,"SELECT * FROM products");

        ?>
        <div class="product-display">
            <table class="product-display-table">
                <thead>
                    <tr>
                        <td>
                            products image
                        </td>
                        <td>
                            products name
                        </td>

                        <td>
                            products price
                        </td>
                        <td>
                            action
                        </td>
                    </tr>
                </thead>
                <?php
                while($row= mysqli_fetch_assoc($select)){
                  
            
                ?>
                  <tr>
                    <td>
                      <img src="uploaded_img/<?php echo $row['image']; ?> "height="100" alt="">
                    </td>
                    <td>
                       <?php echo $row['name']; ?>
                    </td>

                    <td>
                       $ <?php echo $row['price']; ?>
                    </td>
                    <td>
                        action
                    </td>
                </tr>
                <?php
                };
                ?>
            </table>

        </div>
    </div>
    
</body>
</html>