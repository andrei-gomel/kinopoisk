<?php

/**
 * @var \App\Kernel\View\View $view
 */
?>
<?php $view->component('start') ?>

<main>
    <div class="container">
        <h3 class="mt-3">Новинки</h3>
        <hr>
        <div class="movies">
            <a href="#" class="card text-decoration-none movies_item">
                <img src="https://www.timeout.ru/wp-content/uploads/2022/10/asanova.jpg">
                <div class="card-body">
                    <h5 class="card-title">Пацаны</h5>
                    <p class="card-text">Оценка <span class="badge bg-warning warn_badge">7.9</span></p>
                    <p class="card-text">Действие сериала разворачивается в мире, где существуют супергерои. Именно они являются настоящими звездами</p>
                </div>
            </a>

            <?php //foreach ($movies as $movie): 
            ?>
            <?php //$view->component('movie', ['movie' => $movie]); 
            ?>
            <?php //endforeach 
            ?>
        </div>
    </div>
</main>

<?php $view->component('end'); ?>