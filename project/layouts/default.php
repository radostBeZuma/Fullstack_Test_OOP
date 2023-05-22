<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?></title>

    <link rel="icon" type="image/png" href="/favicon.png"/>

    <link rel="stylesheet" href="/project/webroot/assets/build/css/style.min.css">
</head>
<body>
    <div class="container">
        <h1 class="layout-title fs-4 fw-bold my-4 text-uppercase"><?= $title ?></h1>
    </div>
    <?= $content ?>

    <div class="news-update-modal modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Редактирование новости</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="updateForm">
                        <div class="mb-3">
                            <label for="InputTitleUpdate" class="col-form-label">Заголовок новости:</label>
                            <input type="text" class="form-control" id="InputTitleUpdate">
                        </div>
                        <div class="mb-3">
                            <label for="TextareaAnounceUpdate" class="form-label">Анонсный текст:</label>
                            <textarea class="form-control" id="TextareaAnounceUpdate" rows="6" aria-describedby="anounceUpdateHelp"></textarea>
                            <div id="anounceUpdateHelp" class="form-text">Необходимо вводить поля с тегами &lt;p&gt; &lt;/p&gt;</div>
                        </div>
                        <div class="mb-3">
                            <label for="FileAnounceImgUpdate" class="form-label">Анонсная картинка:</label>
                            <input class="form-control form-control-sm" type="file" id="FileAnounceImgUpdate" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="TextareaDetailUpdate" class="form-label">Детальный текст:</label>
                            <textarea class="form-control" id="TextareaDetailUpdate" rows="6" aria-describedby="detailUpdateHelp"></textarea>
                            <div id="detailUpdateHelp" class="form-text">Необходимо вводить поля с тегами &lt;p&gt; &lt;/p&gt;</div>
                        </div>
                        <div class="mb-3">
                            <label for="FileDetailImgUpdate" class="form-label">Детальная картинка:</label>
                            <input class="form-control form-control-sm" type="file" id="FileDetailImgUpdate" accept="image/*">
                        </div>
                        <div>
                            <input type="hidden" id="InputIdUpdate">
                        </div>
                        <div class="news-update-modal__all-error text-danger"></div>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-secondary me-2" data-bs-dismiss="modal" type="button">Закрыть</button>
                            <button class="btn btn-primary" type="submit" formaction="updateForm">Редактировать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="/project/webroot/assets/build/js/main.min.js"></script>
</body>
</html>
