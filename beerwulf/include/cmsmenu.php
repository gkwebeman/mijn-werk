<?php
$items = [
    [
        'title' => 'Stijlen',
        'link' => '../stijlen/index.php',
    ],
    [
        'title' => 'Stijl toevoegen',
        'link' => '../stijlen/create.php',
    ],
    [
        'title' => 'Smaken',
        'link' => '../smaken/index.php',
    ],
    [
        'title' => 'Smaak toevoegen',
        'link' => '../smaken/create.php'
    ],
    [
        'title' => 'Brouwers',
        'link' => '../brouwers/index.php'
    ],
    [
        'title' => 'Brouwer toevoegen', 
        'link' => '../brouwers/create.php'
    ],
    [
        'title' => 'Producten',
        'link' => '../producten/index.php'
    ],
    [
        'title' => 'Product toevoegen',
        'link' => '../producten/create.php'
    ],
]; 

function comparePath($path) {
    $urlPath = array_slice(explode('/', $_SERVER['SCRIPT_FILENAME']), -2);
    $linkPath = array_slice(explode('/', $path), -2);

    return $urlPath[0] == $linkPath[0] && $urlPath[1] == $linkPath[1];
}

?>

<nav class="navigation">
    <ul class="navigation__list">
<?php

        foreach ($items as $item) {
            $className = 'navigation__link' . (comparePath($item['link']) ? ' active' : '');
?>
            <li class="navigation__list-item">
                <a href="<?= $item['link'] ?>" class="<?= $className ?>">
                    <?= $item['title'] ?>
                </a>
            </li>
<?php   
        }
?>
    </ul>
</nav>
