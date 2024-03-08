<!-- <div class="container-appbar">
    <div>
        <a href="./index" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
            <span class="fs-4">3J's Pharmacy</span>
        </a>
    </div>
    <div class="logout">
        <a href="./queries/logout.php" class="text-decoration-none" color="white">
            Logout
        </a>
    </div>
</div> -->
<header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">
        3J's Pharmacy
    </a>

    <ul class="navbar-nav flex-row d-md">
        <li class="nav-item text-nowrap">
            <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                <a href="./queries/logout.php" class="text-decoration-none" color="white">
                    Logout
                </a>
            </button>
        </li>
        <!-- <li class="nav-item text-nowrap">
        <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="bi"><use xlink:href="#list"/></svg>
        </button>
        </li> -->
    </ul>

    <div id="navbarSearch" class="navbar-search w-100 collapse">
        <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
    </div>
</header>