

<?php
    spl_autoload_register(function ($class) {
        include './models/' . $class . '.php';
    });

    $instance = new Order;
    $order = $instance->get_order();
    if($_SESSION['mode'] == 'orders'){
        $order = $instance->get_order();
        $alter = 'delivered';
    }else{
        $order = $instance->get_delivered();
        $alter = 'orders';
    }
    $productGet = $instance->get_product();
    $product = $productGet[0];
    $toCheckProduct = $productGet[1];
    // print_r($toCheckProduct);
    function checkDeliverDisabled($data,$toCheckProduct,$status){
        $toReturn = '';
        if($status == 'delivered' && !in_array($data['status'],['In Transit'])){
            return 'disabled';
        }

        foreach ($toCheckProduct as $key => $value) {
            if($value['brandName'] == $data['itemName']){
                if($data['quantity'] <= $value['quantity']){
                    $toReturn = '';
                }else{
                    $toReturn = 'disabled';
                }
            }
        }
        // if($status == 'out_of_stock' || $toReturn == 'disabled'){
        //     $toReturn = 'disabled';
        // }else if($)
        if($status == 'out_of_stock' && (in_array($data['status'],['In Transit','Delivered']) || $toReturn == 'disabled')){
            $toReturn = '';
        }
        if($status == 'in_transit' && (in_array($data['status'],['Delivered','In Transit']) || $toReturn == 'disabled')){
            $toReturn = 'disabled';
        }
        return $toReturn;
    }
    function checkSCUser($name){
        if($name != null){
            return $name;
        }
        return 0;
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
                <h1 class="h2">Order</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-primary btn-sm" onclick="toggleWalkin()">Walk In</button>
                    </div>
                    <div class="btn-group me-2">
                        <form method="POST" action="link.php"  enctype="multipart/form-data" class="mb-0">
                            <input type="hidden" name="mode" value="<?= $alter?>">
                            <input type="hidden" name="year" value="<?= $_SESSION['selected_year']?>">
                            <button type="submit" class="btn btn-primary btn-sm" ><?= $_SESSION['mode'] == 'orders'? 'Delivered':'Orders'?></button>
                        </form>
                    </div>
                    <!-- <div class="btn-group me-2">
                        
                            <button class="btn btn-primary btn-sm" type="submit">
                                Delivered
                            </button>
                    </div> -->
                    
                </div>
            </div>

            <!-- <h2>Section title</h2> -->
            <div class="table-responsive small table-container">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Customer</th>
                            <th scope="col">Address</th>
                            <th scope="col">ID No.</th>
                            <th scope="col">Item</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Price</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="<?= $_SESSION['mode'] == 'delivered' ? 'd-none' : ''?>">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order as $key => $item) { ?>
                            <tr>
                                <td><?= $item['fullName']; ?></td>
                                <td><?= $item['shipAddress']; ?></td>
                                <td><?= checkSCUser(array_key_exists('seniorCitizenId', $item) ? $item['seniorCitizenId'] : 0)?></td>
                                <td><?= $item['itemName']; ?></td>
                                <td><?= $item['dateOrder']; ?></td>
                                <td><?= $item['quantity']; ?></td>
                                <td><?= $item['unitPrice']; ?></td>
                                <td><?= $item['totalPay']; ?></td>
                                <td><?= $item['status']; ?></td>
                                <td  class="<?= $_SESSION['mode'] == 'delivered' ? 'd-none' : ''?>">
                                    <div class="d-inline-block">
                                        <form method="POST" action="deliver.php"  enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $key; ?>">
                                            <input type="hidden" name="status" value="outofstock">
                                            <button class="btn btn-danger d-inline-flex align-items-center lh-1" type="submit" <?= checkDeliverDisabled($item,$toCheckProduct,'out_of_stock')?>>
                                                cancel
                                            </button>
                                        </form>
                                    </div>
                                    <div class="d-inline-block">
                                        <form method="POST" action="deliver.php"  enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $key; ?>">
                                            <input type="hidden" name="status" value="intransit">
                                            <button class="btn btn-success d-inline-flex align-items-center lh-1" type="submit" <?= checkDeliverDisabled($item,$toCheckProduct,'in_transit')?>>
                                                in transit
                                            </button>
                                        </form>
                                    </div>
                                    <div class="d-inline-block">
                                        <form method="POST" action="deliver.php"  enctype="multipart/form-data">
                                            <input type="hidden" name="id" value="<?= $key; ?>">
                                            <input type="hidden" name="status" value="delivered">
                                            <button class="btn btn-primary d-inline-flex align-items-center lh-1" type="submit" <?= checkDeliverDisabled($item,$toCheckProduct,'delivered')?>>
                                                deliver
                                            </button>
                                        </form>
                                    </div>
                                    
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<div class="modal-overlay" id="walkin">
    <div class="modal modal-sheet position-static d-block p-4 py-md-5" tabindex="-1" role="dialog" id="modalWalkin">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-3 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Walkin Order</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"  onclick="closeWalkin()"></button>
                </div>

                <div class="modal-body p-3 pt-0">
                    <?php include('./modal/add_walkin_order.php') ?>
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
    function toggleWalkin(mode) {
            // document.querySelector(".modal-overlay").style.display = "flex";
            document.getElementById('walkin').style.display = "flex";
        // document.getElementById("modalAddProduct").style.display = "flex";
        // document.querySelector(".overlay").style.display = "block";
    }

    function closeWalkin(){
        document.getElementById('walkin').style.display = "none";
    }
</script>


