<?php
/**
 * @var \App\View\AppView $this
 * @var \Dwdm\Users\Model\Entity\UserContact $userContact
 */
?>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($userContact); ?>
    <fieldset>
        <legend><?= __d('users', 'Confirm contact') ?></legend>
        <?php
        echo $this->Form->control('replace', ['label' => __d('users', 'Contact')]);
        echo $this->Form->control('token', ['value' => '']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
