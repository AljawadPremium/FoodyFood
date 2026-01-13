<?php

use CodeIgniter\Pager\PagerRenderer;


$pager->setSurroundCount(1);

// echo "<pre>";
// print_r($pager);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
	<ul class="pagination">
		<?php if ($pager->hasPrevious()) : ?>
			<li>
				<a data-id="<?= $pager->getFirst_number() ?>" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
					<span aria-hidden="true"><?= lang('Pager.first') ?></span>
				</a>
			</li>
			<li>
				<a data-id="<?= $pager->getPrevious_number() ?>" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
					<span aria-hidden="true"><?= lang('Pager.previous') ?></span>
				</a>
			</li>
		<?php endif ?>

		<?php foreach ($pager->links() as $link) : ?>
			<li <?= $link['active'] ? 'class="active"' : '' ?>>
				<a data-id="<?php echo $link['title']; ?>" href="<?= $link['uri'] ?>">
					<?= $link['title'] ?>
				</a>
			</li>
		<?php endforeach ?>

		<?php if ($pager->hasNext()) : ?>
            <?php // print_r($pager); ?>
			<li>
				<a data-id="<?= $pager->getNext_number() ?>" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
					<span aria-hidden="true"><?= lang('Pager.next') ?></span>
				</a>
			</li>
			<li>
				<a data-id="<?= $pager->getLast_number() ?>" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
					<span aria-hidden="true"><?= lang('Pager.last') ?></span>
				</a>
			</li>
		<?php endif ?>
	</ul>
</nav>
