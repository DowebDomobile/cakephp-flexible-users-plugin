<?php
/**
  * @var \App\View\AppView $this
  * @var \Cake\Datasource\EntityInterface $user
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List User Contacts'), ['controller' => 'UserContacts', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User Contact'), ['controller' => 'UserContacts', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Password') ?></th>
            <td><?= h($user->password) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Token') ?></th>
            <td><?= h($user->token) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Registered') ?></th>
            <td><?= h($user->registered) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Expiration') ?></th>
            <td><?= h($user->expiration) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related User Contacts') ?></h4>
        <?php if (!empty($user->user_contacts)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('User Id') ?></th>
                <th scope="col"><?= __('Name') ?></th>
                <th scope="col"><?= __('Value') ?></th>
                <th scope="col"><?= __('Is Login') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Updated') ?></th>
                <th scope="col"><?= __('Replace') ?></th>
                <th scope="col"><?= __('Token') ?></th>
                <th scope="col"><?= __('Expiration') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->user_contacts as $userContacts): ?>
            <tr>
                <td><?= h($userContacts->id) ?></td>
                <td><?= h($userContacts->user_id) ?></td>
                <td><?= h($userContacts->name) ?></td>
                <td><?= h($userContacts->value) ?></td>
                <td><?= h($userContacts->is_login) ?></td>
                <td><?= h($userContacts->created) ?></td>
                <td><?= h($userContacts->updated) ?></td>
                <td><?= h($userContacts->replace) ?></td>
                <td><?= h($userContacts->token) ?></td>
                <td><?= h($userContacts->expiration) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'UserContacts', 'action' => 'view', $userContacts->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'UserContacts', 'action' => 'edit', $userContacts->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'UserContacts', 'action' => 'delete', $userContacts->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userContacts->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
