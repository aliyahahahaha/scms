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
                <?= $this->Html->link(__('List Activities'), ['action' => 'index'], ['class' => 'dropdown-item']) ?>
            </div>
        </div>
    </div>
</div>
<div class="line mb-4"></div>

<!-- Form Card -->
<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow-sm">
    <div class="card-body text-body-secondary">
        <?= $this->Form->create($activity, ['class' => 'needs-validation', 'novalidate' => true]) ?>
        <fieldset>
            <legend class="text-primary mb-4"><?= __('Add Activity') ?></legend>

            <!-- Form Fields -->
            <div class="row g-3">
            
            <?= $this->Form->hidden('user_id', ['value' => 1]); ?>
            <!-- Faculty Selection -->
            <div class="col-md-6">
                    <?= $this->Form->control('faculty_id', ['options' => $faculties, 'label' => 'Faculty', 'class' => 'form-control']); ?>
                </div>
                <!-- Program Selection -->
                <div class="col-md-6">
                    <?= $this->Form->control('program_id', ['options' => $programs, 'label' => 'Program', 'class' => 'form-control']); ?>
                </div>

                <!-- Semester Selection -->
                <div class="col-md-6">
                    <?= $this->Form->control('semester_id', ['options' => $semesters, 'label' => 'Semester', 'class' => 'form-control']); ?>
                </div>

                <!-- Club Selection -->
                <div class="col-md-6">
                    <?= $this->Form->control('club_id', ['options' => $clubs, 'label' => 'Club', 'class' => 'form-control']); ?>
                </div>

                <!-- Activity Name -->
                <div class="col-md-6">
                    <?= $this->Form->control('name', ['label' => 'Activity Name', 'class' => 'form-control']); ?>
                </div>

                <!-- Date -->
                <div class="col-md-6">
                    <?= $this->Form->control('date', ['label' => 'Date', 'type' => 'date', 'class' => 'form-control']); ?>
                </div>

                <!-- Location -->
                <div class="col-md-6">
                    <?= $this->Form->control('location', ['label' => 'Location', 'class' => 'form-control']); ?>
                </div>

                <!-- Budget -->
                <div class="col-md-6">
                    <?= $this->Form->control('budget', ['label' => 'Budget (RM)', 'type' => 'number', 'step' => '0.01', 'class' => 'form-control']); ?>
                </div>

                <!-- Activity Description -->
                <div class="col-md-12">
                    <?= $this->Form->control('activitydescription', ['label' => 'Activity Description', 'type' => 'textarea', 'rows' => 3, 'class' => 'form-control']); ?>
                </div>

                <!-- Time -->
                <div class="col-md-6">
                    <?= $this->Form->control('time', ['label' => 'Time', 'type' => 'time', 'class' => 'form-control']); ?>
                </div>

                <!-- Number of Participants -->
                <div class="col-md-6">
                    <?= $this->Form->control('participant', ['label' => 'Number of Participants', 'type' => 'number', 'class' => 'form-control']); ?>
                </div>

                <!-- Reference Number -->
                <div class="col-md-6">
                    <?= $this->Form->control('ref_no', ['label' => 'Reference No.', 'class' => 'form-control']); ?>
                </div>


                <!-- Approval Status -->
                <div class="col-md-6">
                        <?= $this->Form->control('approvalstatus', [
                            'label' => 'Approval Status',
                            'type' => 'select',
                            'options' => [
                                2 => 'Rejected',
                                1 => 'Approved',
                                0 => 'Pending',
                            ],
                            'class' => 'form-control'
                        ]); ?>
                    </div>

                <!-- Approval Date -->
                <?php echo $this->Form->control('approvaldate'); ?>
                <!-- Approval By -->
                <div class="col-md-6">
                    <?= $this->Form->control('approvalby', ['label' => 'Approved By', 'class' => 'form-control']); ?>
                </div>

                <!-- Status (Active/Inactive) -->
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

        <!-- Form Buttons -->
        <div class="text-end mt-4">
            <?= $this->Form->button('Reset', ['type' => 'reset', 'class' => 'btn btn-outline-warning px-4']); ?>
            <?= $this->Form->button(__('Submit'), ['type' => 'submit', 'class' => 'btn btn-outline-primary px-4']); ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
