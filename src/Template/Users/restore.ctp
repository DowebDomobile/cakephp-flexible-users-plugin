<?php
/**
 * @var \App\View\AppView $this
 * @var \Dwdm\Users\Model\Entity\User $user
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __d('users', 'Restore password') ?></legend>
        <?php echo $this->Form->control('email'); ?>
    </fieldset>
    <?= $this->Form->button(__d('users', 'Restore')) ?>
    <?= $this->Form->end() ?>
</div>
