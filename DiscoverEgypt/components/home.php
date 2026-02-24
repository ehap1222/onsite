<?php 

    require_once "./components/header.php";
    require_once "./components/navbar.php";
    require_once "./components/slide.php";
    require_once "./distinations.php";

?>

<div class="container mt-3">
    <div class="parent">
        <?php foreach($dists as $dist): ?>
            <div class="card">
                <img class="card-img-top" src="./images/<?= $dist["img"] ?>" alt="Title" />
                <div class="card-body">
                    <h4 class="card-title"><?= $dist["title"] ?></h4>
                    <p class="card-text"><?= $dist["desc"] ?></p>
                    <a class="btn btn-outline-primary d-block" href="details.php?id=<?= $dist["id"] ?>">Details</a>
                </div>
            </div>
            
        <?php endforeach ?>
    </div>
</div>

<?php 

require_once "./components/footer.php";

?>