<?php
/**
 * @var \App\View\AppView $this
 * @var \Dwdm\Users\Model\Entity\UserContact $entity
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($entity) ?>
    <fieldset>
        <legend><?= __d('users', 'Confirm contact') ?></legend>
        <?php
        echo $this->Form->control('email');
        echo $this->Form->control('token');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
