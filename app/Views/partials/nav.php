<!-- main menu-->

    <!-- sidebar links-->
    <p class="menu-group mb-3"><?=session()->user['restaurant_name']?></p>
    <ul class="list-group-flush">
        <li class="list-group-item"><a href="<?= site_url('products') ?>"><i class="fa-solid fa-burger me-3"></i>Produtos</a></li>
        <li class="list-group-item"><a href="<?= site_url('/stocks')?>"><i class="fa-solid fa-layer-group me-3"></i>Stocks</a>
        </li>
        <li class="list-group-item"><a href="#"><i class="fa-solid fa-chart-column me-3"></i>Dados
                Estatísticos</a></li>
        <!--<li class="list-group-item"><a href="#">Item 4</a></li>
        <li class="list-group-item"><a href="#">Item 5</a></li>
        <li class="list-group-item"><a href="#">Item 6</a></li>
        <li class="list-group-item"><a href="#">Item 7</a></li>
        <li class="list-group-item"><a href="#">Item 8</a></li>
        <li class="list-group-item"><a href="#">Item 9</a></li>-->
    </ul>
