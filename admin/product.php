

<?php
    spl_autoload_register(function ($class) {
        include './models/' . $class . '.php';
    });

    $instance = new Product;
    $get_product = $instance->get_product();
    $product = [];
    if($get_product != null){
        $product = $get_product;
    }
    // echo $product;
    function tr_color($qty){
        if($qty <= 0){
            return 'tr-error';
        }else if($qty <= 50){
            return 'tr-warning';
        }else{
            '';
        }
    }
    include('./link/header.php');
    include('./link/appbar.php');
?>
<div class="container-fluid">
    <div class="row">
        <?php
            include('./link/sidebar.php');
        ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Product</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addProductModal('add')">Add New</button>
                    </div>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-primary btn-sm" onclick="addProductModal('existing')">Add Existing</button>
                    </div>
                </div>
            </div>

            <!-- <h2>Section title</h2> -->
            <?php foreach ($product as $category => $item) {?>
                <div class="table-responsive small table-container-product">
                    <table class="table table-striped table-sm">
                        <caption>
                            <?= $category?>
                        </caption>
                        <thead>
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Brand Name</th>
                                <?php if($category == 'health-care'){ ?>
                                    <th scope="col">Generic Name</th>
                                <?php }?>
                                
                                <th scope="col">Price</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($item as $key => $value) { ?>
                                <tr class="<?= tr_color($value['quantity']) ?>">
                                    <td>
                                        <img src="<?= $value['imageUrl']?>" width="20" height="20">
                                    </td>
                                    <td><?= $value['brandName']?></td>
                                    <?php if($category == 'health-care'){ ?>
                                        <td><?= $value['genericName']?></th>
                                    <?php }?>
                                    <td><?= $value['price']?></td>
                                    <td><?= $value['quantity']?></td>
                                    <td>
                                        <form method="POST" action="delete_product.php"  enctype="multipart/form-data">
                                            <input type="hidden" name="product_category" value="<?= $category; ?>">
                                            <input type="hidden" name="product_name" value="<?= $value['brandName']; ?>">
                                            <button class="btn btn-primary d-inline-flex align-items-center lh-1" type="submit" <?= intval($value['quantity']) > 0 ? 'disabled' : '';?>>
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php 
                            } 
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>
            
        </main>
    </div>
</div>


<div class="modal-overlay" id="newProduct">
    <div class="modal modal-sheet position-static d-block p-4 py-md-5" tabindex="-1" role="dialog" id="modalAddProduct">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-3 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Add Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="closeModal()"></button>
                </div>

                <div class="modal-body p-3 pt-0">
                    <?php include('./modal/add_new_product.php') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-overlay" id="existingProduct">
    <div class="modal modal-sheet position-static d-block p-4 py-md-5" tabindex="-1" role="dialog" id="modalAddProduct">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-3 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Add Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="closeModal()"></button>
                </div>

                <div class="modal-body p-3 pt-0">
                    <?php include('./modal/add_existing_product.php') ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .modal-overlay{
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(159, 159, 159, 0.5);
        z-index: 1021;
        justify-content: center;
        align-items: center;
        display: none;
    }
</style>
<script>
    function addProductModal(mode) {
        if(mode === "add"){
            // document.querySelector(".modal-overlay").style.display = "flex";
            document.getElementById('newProduct').style.display = "flex";
        }else if(mode === 'existing' ){
            document.getElementById('existingProduct').style.display = "flex";
        }
        // document.getElementById("modalAddProduct").style.display = "flex";
        // document.querySelector(".overlay").style.display = "block";
    }

    function closeModal() {
        // document.getElementById("myModal").style.display = "none";
        document.getElementById('newProduct').style.display = "none";
        document.getElementById('existingProduct').style.display = "none";
    }
</script>