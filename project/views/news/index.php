<div class="container">
    
    <nav>
        <ul class="pagination">
            <li class="page-item <?= ($pag['current_page'] == reset($pag['count_page'])) ? ('disabled') : ('') ?>">
                <a class="page-link" href="<?= ($pag['current_page'] != reset($pag['count_page'])) ? ('/page/' . $prevPage = $pag['current_page'] - 1 . '/') : ('#') ?>">Предыдущая</a>
            </li>
            <? foreach ($pag['count_page'] as $page) : ?>
                <li class="page-item <?= ($page == $pag['current_page']) ? ('active') : ('') ?>">
                    <a class="page-link" href="<?= '/page/' . $page . '/' ?>"><?= $page ?></a>
                </li>
            <? endforeach; ?>
            <li class="page-item <?= ($pag['current_page'] == end($pag['count_page'])) ? ('disabled') : ('') ?>">
                <a class="page-link" href="<?= ($pag['current_page'] != end($pag['count_page'])) ? ('/page/' . $nextPage = $pag['current_page'] + 1 . '/') : ('#') ?>">Следующая</a>
            </li>
        </ul>
    </nav>

    <div class="news mb-12">
        <div class="row">
            <? foreach ($allNews as $news) : ?>
                <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch mb-4">
                    <div class="card">
                        <img class="news__card-img card-img-top" src="<?= $news['announce_url'] ?>" alt="<?= $news['title'] ?>" title="<?= $news['title'] ?>">
                        <div class="card-body">
                            <div class="news__date d-inline-block fs-11 p-1 mb-2"><?= $news['date_created'] ?></div>
                            <a class="" href="<?= '/' . $news['id'] . '/' ?>">
                                <h5 class="card-title"><?= $news['title'] ?></h5>
                            </a>
                            <div class="card-text text-150"><?= $news['announce_text'] ?></div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>

</div>

<div class="panel-tools position-fixed bottom-0 start-0 end-0 bg-white p-4">
    <div class="container">
        <div class="panel-tools__wrap d-flex justify-content-end">
            <button class="panel-tools__btn-add btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#addModal">Добавить</button>
            <!--<button class="panel-tools__btn-add btn btn-danger" type="button">Удалить</button>-->
        </div>
    </div>
</div>

<div class="news-add-modal modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить новость</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form class="news-add-modal__form" action="">
                    <div class="mb-3">
                        <label for="InputTitle" class="form-label">Заголовок</label>
                        <input type="text" class="form-control" id="InputTitle">
                    </div>
                    <div class="mb-3">
                        <label for="TextareaAnounce" class="form-label">Анонсный текст</label>
                        <textarea class="form-control" id="TextareaAnounce" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="FileAnounceImg" class="form-label">Анонсная картинка</label>
                        <input class="form-control form-control-sm" type="file" id="FileAnounceImg">
                    </div>
                    <div class="mb-3">
                        <label for="TextareaDetail" class="form-label">Детальный текст</label>
                        <textarea class="form-control" id="TextareaDetail" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="FileDetailImg" class="form-label">Детальная картинка</label>
                        <input class="form-control form-control-sm" type="file" id="FileDetailImg">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>