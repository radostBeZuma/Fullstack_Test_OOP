<div class="detail">
    <div class="detail__layout">
        <h2 class="detail__title"><?= $oneNews['title'] ?></h2>
        <div class="detail__date"><?= $oneNews['date_created'] ?></div>
        <img class="detail__img" src="<?= $oneNews['detail_url'] ?>" alt="">
        <div class="detail__text"><?= $oneNews['detail_text'] ?></div>
    </div>
    <div class="detail__backurl">
        <a href="/"><-- Список новостей</a>
    </div>
</div>
