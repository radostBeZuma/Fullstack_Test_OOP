<div class="container">
    <div class="detail">
        <div class="detail__layout">
            <h2 class="detail__title"><?= $oneNews['title'] ?></h2>
            <div class="detail__date mb-3"><?= $oneNews['date_created'] ?></div>
            <button class="btn btn-warning mb-3 d-flex align-items-center" title="Редактировать" type="button" data-bs-toggle="modal" data-bs-target="#updateModal" data-bs-id="<?= $oneNews['id'] ?>"">
                <img src="/project/webroot/assets/build/img/update.png" alt="Редактировать" width="15" height="15">
                <span class="text-white ms-2">Редактировать</span>
            </button>
            <img class="detail__img float-none float-sm-start mb-3 pe-0 pe-sm-3" src="<?= $oneNews['detail_url'] ?>" alt="<?= $oneNews['title'] ?>" title="<?= $oneNews['title'] ?>">
            <div class="detail__text"><?= $oneNews['detail_text'] ?></div>
        </div>
        <div class="detail__backurl mb-4">
            <a href="/"><-- Список новостей</a>
        </div>
    </div>
</div>
