<?php
function renderProductCard($product) {
    $imagePaths = explode(",", $product['image_path']);
    ?>
    <div class="col-md-4">
        <div class="card mb-4">
            <div id="carousel<?= $product['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($imagePaths as $index => $imagePath): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= htmlspecialchars(trim($imagePath)) ?>" class="d-block w-100" alt="Product Image">
                        </div>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?= $product['id'] ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel<?= $product['id'] ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
            <div class="card-body text-start d-flex flex-column justify-content-between">
                <h5 class="card-title"><?= htmlspecialchars($product['item_name']) ?></h5>
                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($product['city']) ?>, <?= strtoupper(htmlspecialchars($product['state'])) ?></p>
                <p class="card-text"><strong>Price:</strong> $<?= htmlspecialchars($product['price']) ?></p>
                <p class="card-text"><strong>Condition:</strong> <?= htmlspecialchars($product['condition']) ?></p>
                <p class="card-text"><strong>Description:</strong><br><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                <a href="#" class="btn btn-primary">View More Details</a>
            </div>
        </div>
    </div>
    <?php
}
?>