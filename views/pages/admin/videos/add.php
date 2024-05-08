<?php

/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\SessionInterface $session
 * @var array<\App\Models\Category> $categories
 */

?>
<?php $view->component('start') ?>

<main>
    <div class="container">
        <h3 class="mt-3">Добавление нового фильма</h3>
        <hr>
    </div>
    <div class="container">
        <form action="/admin/videos/add" method="post" class="d-flex flex-column justify-content-center w-50 gap-2 mt-5 mb-5" enctype="multipart/form-data">
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control <?php echo $session->has('name') ? 'is-invalid' : '' ?>" id="name" name="name" placeholder="Иван Иванов">
                        <label for="name">Название</label>
                        <?php if ($session->has('name')) { ?>
                            <div id="name" class="invalid-feedback">
                                <?php echo $session->getFlash('name')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="form-floating">
                        <textarea style="height: 100px" type="text" class="form-control <?php echo $session->has('description') ? 'is-invalid' : '' ?>" id="description" name="description" placeholder="Крутой фильм про...">
                        </textarea>
                        <label for="description">Описание</label>
                        <?php if ($session->has('description')) { ?>
                            <div id="description" class="invalid-feedback">
                                <?php echo $session->getFlash('description')[0] ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <div class="col-md">
                    <div class="mb-3">
                        <label for="image" class="form-label">Изображение</label>
                        <input class="form-control" type="file" name="image" id="image">
                    </div>
                </div>
            </div>
            <div class="row g-2">
                <select class="form-select" name="category">
                    <option selected>Жанр</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category->id() ?>"><?= $category->name() ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="row g-2">
                <button class="btn btn-success">Добавить</button>
            </div>
        </form>
    </div>
</main>

<?php $view->component('end') ?>