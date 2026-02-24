<?php 

require_once "./components/header.php";
require_once "./components/navbar.php";
require_once "./distinations.php";

$id = $_GET["id"];
?>

<div class="container mt-3">
    <?php foreach($dists as $dist): ?>
        <?php if($id == $dist["id"]): ?>
            <div class="card mx-auto" style="width: fit-content;">
                <img class="card-img-top" style="width: 500px;" src="./images/<?= $dist["img"] ?>" alt="Title" />
                <div class="card-body">
                    <h4 class="card-title"><?= $dist["title"] ?></h4>
                    <p class="card-text"><?= $dist["desc"] ?></p>
                </div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
</div>