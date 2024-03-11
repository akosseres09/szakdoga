<?php
/**
 * @var array $tabs
 * @var string $tab
 */

?>


<ul class="user-profile-tabs">
    <?php foreach ($tabs as $site) {
        $active = $site['site'] === $tab;
        ?>
        <li class="d-flex justify-content-center align-items-center">
            <span class="user-link <?= $active ? 'active' : '' ?>" data-href="<?= $site['link'] ?>">
                <?php if($site['active'] && $site['passive']) { ?>
                    <div class="<?= $active ? $site['active'] : $site['passive'] ?>"></div>
                <?php } ?>
                <?= ucfirst($site['site']) ?>
            </span>
        </li>
    <?php } ?>
</ul>
