<?php
/**
  * @var \App\View\AppView $this
  * @var \Dwdm\Users\Model\Entity\User $entity
  */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($entity) ?>
    <fieldset>
        <legend><?= __d('users', 'Register') ?></legend>
        <?php
            echo $this->Form->control('email');
            echo $this->Form->control('password');
            echo $this->Form->control('verify');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
