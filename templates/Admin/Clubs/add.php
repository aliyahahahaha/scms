<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Club $club
 */
?>
<!-- Header Section -->
<div class="row text-body-secondary mb-4">
    <div class="col-10">
        <h1 class="my-0 page_title"><?= h($title) ?></h1>
        <h6 class="sub_title text-muted"><?= h($system_name) ?></h6>
    </div>
    <div class="col-2 text-end">
        <div class="dropdown mx-3 mt-2">
            <button class="btn p-0 border-0" type="button" id="orderStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-bars text-primary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orderStatistics">
                <?= $this->Html->link(__('List Clubs'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?>
            </div>
        </div>
    </div>
</div>
<div class="line mb-4"></div>

<!-- Form Card -->
<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow-sm">
    <div class="card-body text-body-secondary">
        <?= $this->Form->create($club, ['class' => 'needs-validation', 'novalidate' => true]) ?>
        <fieldset>
            <legend class="text-primary mb-4"><?= __('Add Club') ?></legend>

            <!-- Form Fields -->
            <div class="row g-3">
                <div class="col-md-6">
                    <?= $this->Form->control('name', [
                        'label' => 'Club Name',
                        'class' => 'form-control',
                        'placeholder' => 'Enter club name',
                    ]); ?>
                </div>
                <div class="col-md-6">
                    <?= $this->Form->control('status', [
                        'label' => 'Status',
                        'type' => 'select',
                        'options' => [
                            1 => 'Active',
                            0 => 'Inactive',
                        ],
                        'class' => 'form-control'
                    ]); ?>
                </div>
            </div>
        </fieldset>

        <!-- Action Buttons -->
        <div class="text-end mt-4">
            <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning px-4']); ?>
            <?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-outline-primary px-4']); ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
