<?php
/**
  * @var \App\View\AppView $this
  * @var \Dwdm\Users\Model\Entity\User $entity
  */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __d('users', 'Login') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
        ?>
    </fieldset>
    <?= $this->Form->button(__d('users', 'Login')) ?>
    <?= $this->Form->end() ?>
</div>
