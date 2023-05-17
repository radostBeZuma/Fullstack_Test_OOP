<div class="container">
    <div class="detail">
        <div class="detail__layout">
            <h2 class="detail__title"><?= $oneNews['title'] ?></h2>
            <div class="detail__date mb-3"><?= $oneNews['date_created'] ?></div>
            <img class="detail__img float-start pb-3 pe-3" src="<?= $oneNews['detail_url'] ?>" alt="">
            <div class="detail__text"><?= $oneNews['detail_text'] ?></div>
        </div>
        <div class="detail__backurl mb-4">
            <a href="/"><-- Список новостей</a>
        </div>
    </div>
</div>
