
<?php 
    // link

    function pageActive($active){
        if($_SESSION['page'] == $active){
            return 'active';
        }else{
            return '';
        }
    }
?>
<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
    <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 <?= pageActive('dashboard')?>" aria-current="page" href="dashboardLink.php">
                        <svg class="bi"><use xlink:href="#house-fill"/></svg>
                        Sales Report
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2  <?= pageActive('orders')?>" href="OrderLink.php">
                        <svg class="bi"><use xlink:href="#cart"/></svg>
                        Order
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2  <?= pageActive('product')?>" href="productLink.php">
                        <svg class="bi"><use xlink:href="#cart"/></svg>
                        Products
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="./js/sidebars.js"></script>