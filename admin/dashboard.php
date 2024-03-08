

<?php
    spl_autoload_register(function ($class) {
        include './models/' . $class . '.php';
    });

    $instance = new StockIn;
    $order = $instance->get_sales();
    // $generateYear = 
    $daily = $order[0];
    $weekly = $order[1];
    $monthly = $order[2];
    $yearly = $order[3];
    function generateYearArray() {
        $startYear = 2022;
        $currentYear = date('Y');
        $years = range($startYear, $currentYear);
        // echo "<pre>";
        // print_r($years);
        // echo "</pre>";
        return $years;
    }
    $optionYear = generateYearArray();

    include('./link/header.php');
    include('./link/appbar.php');
?>
<style>
    body {
      font-family: Arial, sans-serif;
    }
    .modal {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      border: 1px solid #ccc;
      background-color: #fff;
      padding: 20px;
      z-index: 1000;
    }
    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 900;
    }
    button {
      cursor: pointer;
    }
  </style>
<div class="container-fluid">
    <div class="row">
        <?php
            include('./link/sidebar.php');
        ?>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sales Report</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <form method="POST" action="link.php"  enctype="multipart/form-data" class="mb-0">
                        <div class="btn-group me-2">
                            <select class="form-control rounded-3 d-flex gap-1" id="year" name="year" value="<?= $_SESSION['selected_year']?>">
                                <?php foreach ($optionYear as $key => $value) { ?>
                                    <option value="<?= $value?>" <?= $value == $_SESSION['selected_year'] ? 'selected' : ''?>><?= $value?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="btn-group me-2">
                            <button type="submit" class="btn btn-primary btn-sm" >sort by year</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- <h2>Section title</h2> -->
            <div class="table-responsive small table-container-product">
                <table class="table table-striped table-sm">
                    <caption>
                        Daily
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($daily as $key => $item) { ?>
                            <tr>
                                <td><?= $key?></td>
                                <td><?= $item['profit']?></td>
                                <td><?= $item['expenses']?></td>
                                <td><?= $item['sales']?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive small table-container-product">
                <table class="table table-striped table-sm">
                    <caption>
                        Weekly
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($weekly as $key => $item) { ?>
                            <tr>
                                <td><?= $key?></td>
                                <td><?= $item['profit']?></td>
                                <td><?= $item['expenses']?></td>
                                <td><?= $item['sales']?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive small table-container-product">
                <table class="table table-striped table-sm">
                    <caption>
                        Monthly
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($monthly as $key => $item) { ?>
                            <tr>
                                <td><?= $key?></td>
                                <td><?= $item['profit']?></td>
                                <td><?= $item['expenses']?></td>
                                <td><?= $item['sales']?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive small table-container-product">
                <table class="table table-striped table-sm">
                    <caption>
                        Yearly
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Profit</th>
                            <th scope="col">Capital</th>
                            <th scope="col">Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($yearly as $key => $item) { ?>
                            <tr>
                                <td><?= $key?></td>
                                <td><?= $item['profit']?></td>
                                <td><?= $item['expenses']?></td>
                                <td><?= $item['sales']?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>