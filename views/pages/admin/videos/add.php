<?php

/**
 * @var \App\Kernel\View\View $view
 * @var \App\Kernel\Session\SessionInterface $session
 */

?>
<?php $view->component('start') ?>

<h1>Добавление нового видео</h1>

<form action="/admin/videos/add" method="post" enctype="multipart/form-data">
    <p>Имя</p>
    <div>
        <input type="text" name="name">
    </div>
    <?php if ($session->has('name')): ?>
        <div>
            <ul>
                <?php foreach ($session->getFlash('name') as $error): ?>
                    <li style="color: red;">
                        <?= $error ?>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>
    <div>
        <input type="file" name="image">
    </div>
    <div>
        <button>
            Добавить
        </button>
    </div>
</form>
<?php $view->component('end') ?>