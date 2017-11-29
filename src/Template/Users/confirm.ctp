<?php
/**
 * @var \App\View\AppView $this
 * @var \Dwdm\Users\Model\Entity\User $entity
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($entity) ?>
    <fieldset>
        <legend><?= __d('users', 'Enter new password') ?></legend>
        <?php echo $this->Form->control('password'); ?>
        <?php echo $this->Form->control('verify'); ?>
    </fieldset>
    <?= $this->Form->button(__d('users', 'Restore')) ?>
    <?= $this->Form->end() ?>
</div>
