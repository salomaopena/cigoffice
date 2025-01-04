<?= $this->extend('layouts/layout-dashboard') ?>
<?= $this->section('content') ?>
<!-- your dashboard content here -->
<div class="content-box mb-3">
    <p class="content-title">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis, consectetur!
    </p>

    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusamus ad alias animi architecto aut
    commodi
    corporis debitis dignissimos distinctio doloribus earum eos expedita facere facilis fuga fugit harum id
    inventore iure magnam maxime minus modi neque nisi numquam odit omnis perferendis porro provident qui
    quidem repellat repellendus rerum saepe sed sequi soluta suscipit tempora tenetur temporibus ut vel vero
    voluptas voluptates.

    <div class="mt-3">
        <a href="#" class="btn btn-cig">
            <i class="fa-solid fa-link"></i>
            <span>Link</span>
        </a>

        <a href="#" class="btn btn-cig-outline">
            <i class="fa-solid fa-link"></i>
            <span>Link Outline</span>
        </a>
    </div>

</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-12 p-0">
            <div class="content-box">
                <h1>Lorem, ipsum dolor.</h1>
                <h2>Lorem, ipsum dolor.</h2>
                <h3>Lorem, ipsum dolor.</h3>
                <h4>Lorem, ipsum dolor.</h4>
                <h5>Lorem, ipsum dolor.</h5>
                <h6>Lorem, ipsum dolor.</h6>

            </div>
        </div>

        <div class="col-lg-6 col-12 p-0">
            <div class="content-box">
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Header 1</th>
                            <th>Header 2</th>
                            <th>Header 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Data 1</td>
                            <td>Data 2</td>
                            <td>Data 3</td>
                        </tr>
                        <tr>
                            <td>Data 4</td>
                            <td>Data 5</td>
                            <td>Data 6</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>