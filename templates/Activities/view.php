<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Activity $activity
 */
?>
<!--Header-->
<div class="row text-body-secondary">
	<div class="col-10">
		<h1 class="my-0 page_title"><?php echo $title; ?></h1>
		<h6 class="sub_title text-body-secondary"><?php echo $system_name; ?></h6>
	</div>
	<div class="col-2 text-end">
		<div class="dropdown mx-3 mt-2">
			<button class="btn p-0 border-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa-solid fa-bars text-primary"></i>
			</button>
				<div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
							<li><?= $this->Html->link(__('Edit Activity'), ['action' => 'edit', $activity->id], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Form->postLink(__('Delete Activity'), ['action' => 'delete', $activity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activity->id), 'class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><hr class="dropdown-divider"></li>
				<li><?= $this->Html->link(__('List Activities'), ['action' => 'index'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
				<li><?= $this->Html->link(__('New Activity'), ['action' => 'add'], ['class' => 'dropdown-item', 'escapeTitle' => false]) ?></li>
							</div>
		</div>
    </div>
</div>
<div class="line mb-4"></div>
<!--/Header-->

<div class="row">
	<div class="col-md-9">
		<div class="card rounded-0 mb-3 bg-body-tertiary border-0 shadow">
			<div class="card-body text-body-secondary">
           
            <style>

    .top {
        width: 100%;
        margin: auto;
    }

    .one {
        width: 72%;
        height: 25px;
        background: #292983;
        float: left;
    }

    .two {
        margin-left: 28%;
        height: 25px;
        background: #912891;
    }

    .capital {
        text-transform: uppercase;
    }

    .content {
        padding: 20px;
        margin-bottom: 50px; /* Space for footer */
        overflow: auto; /* Clear floats inside the content */
    }

    .address {
        font-size: 14px;
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        margin-top: 20px;
    }

    .table-bordered {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    .table-sm {
        font-size: 12px;
    }

    .table td, .table th {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    .signature {
        margin-top: 40px;
    }

    .justify {
        text-align: justify;
    }

    .text-end {
        text-align: right;
    }

    .activity-data-container {
    position: fixed;
    top: 150px;  
    right: 20px; 
    width: 300px;
    z-index: 1000; 
}


        </style>

        <section class="top">
            <div class="one"></div>
            <div class="two"></div>
    </section>

    <div class="text-end my-4 me-5">
        <?php echo $this->Html->image('../img/surat/logouitm.png',['width'=>'200px']) ?>
    </div>

    <hr />

    <table width="100%">
    <tr>
        <td width="78%" class="text-end">Surat Kami &nbsp; : &nbsp; </td>
        <td>
            <?php 
            if ($activity->approvalstatus == 0) {
                echo '-';
            } elseif ($activity->approvalstatus == 1) {
                echo $activity->ref_no;
            } else 
                echo 'Rejected';
            
            ?>
        </td>
    </tr>

    <tr>
        <td class="text-end">Tarikh &nbsp; : &nbsp; </td>
        <td>
            <?php 
            if ($activity->approvalstatus == 0) {
                echo '-';
            } elseif ($activity->approvalstatus == 1) {
                echo date('d F Y', strtotime($activity->modified));
            } else 
                echo 'Rejected';
            
            ?>
        </td>
    </tr>
</table>

<div class="content">
    <div class="address">
        Universiti Teknologi MARA (UiTM) Puncak Perdana<br />
        Jalan Pulau Angsa U10/1<br />
        Seksyen U10<br />
        40150 Shah Alam,<br />
        Selangor<br />
        <strong>Malaysia</strong>
    </div>

    <br><br>

    <strong>Untuk Perhatian: <?= h($activity->club->name) ?></strong>
    <br><br>
    <strong>PERMOHONAN PENGESAHAN AKTIVITI KELAB DI UiTM PUNCAK PERDANA</strong>
    <br><br>

    <div class="justify">
        Dengan segala hormatnya, perkara di atas adalah dirujuk.
        <br /><br />

        2. Pihak pengurusan UiTM Puncak Perdana telah meneliti permohonan aktiviti yang dikemukakan oleh pihak kelab <strong><?= h($activity->club->name) ?></strong> seperti berikut:
    </div>
    

    <br />


    <table class="table table-bordered table-sm capital table_transparent">
        <tr>
            <td>NAMA AKTIVITI</td>
            <td>:</td>
            <td><?= h($activity->name) ?></td>
        </tr>
        <tr>
            <td>NAMA PEMOHON</td>
            <td>:</td>
            <td><?= h($activity->user->fullname) ?></td>
        </tr>
        <tr>
            <td>FAKULTI</td>
            <td>:</td>
            <td><?= h($activity->faculty->name) ?></td>
        </tr>
        <tr>
            <td>PROGRAM</td>
            <td>:</td>
            <td><?= h($activity->program->name) ?></td>
        </tr>
        <tr>
            <td>SEMESTER</td>
            <td>:</td>
            <td><?= h($activity->semester->code) ?></td>
        </tr>
        <tr>
            <td>NAMA KELAB</td>
            <td>:</td>
            <td><?= h($activity->club->name) ?></td>
        </tr>
        <tr>
            <td>TARIKH</td>
            <td>:</td>
            <td><?= h($activity->date) ?></td>
        </tr>
        <tr>
            <td>MASA</td>
            <td>:</td>
            <td><?= h($activity->time) ?></td>
        </tr>
        <tr>
            <td>BUDGET</td>
            <td>:</td>
            <td><?= h($activity->budget) ?></td>
        </tr>
        <tr>
            <td>PESERTA</td>
            <td>:</td>
            <td><?= h($activity->participant) ?></td>
        </tr>

        <tr>
            <td><strong>Kelulusan</strong></td>
            <td>:</td>
            <td>
                <?php if ($activity->approvalstatus == 1) { ?>
                    <span style="color: green; font-weight: bold;">DILULUSKAN</span>
                <?php } else { ?>
                    <span style="color: red; font-weight: bold;">TIDAK DILULUSKAN</span>
                <?php } ?>
            </td>
        </tr>

    </table>

    <br />
    <div class="justify">
        <?php if ($activity->approvalstatus == 1) { ?>
            3. Sukacita dimaklumkan bahawa permohonan aktiviti ini telah <strong>DILULUSKAN</strong>. Namun, pihak kelab diminta untuk memastikan semua peraturan dan prosedur yang ditetapkan oleh pihak universiti dipatuhi. Antara syarat yang perlu diikuti adalah:
            <ul>
                <li>Mematuhi semua garis panduan keselamatan universiti.</li>
                <li>Mendapatkan kelulusan bertulis dari pihak keselamatan jika melibatkan kawasan luar kampus.</li>
                <li>Menyerahkan laporan aktiviti selepas program selesai.</li>
            </ul>
            4. Sebarang pertanyaan lanjut boleh diajukan kepada pihak pengurusan UiTM Puncak Perdana.
        <?php } else { ?>
            3. Dukacita dimaklumkan bahawa permohonan aktiviti ini <strong>TIDAK DILULUSKAN</strong> atas sebab-sebab berikut:
            <ul>
                <li><?= h($activity->rejection_reason) ?></li>
            </ul>
            4. Pihak kelab boleh mengemukakan permohonan semula dengan menepati garis panduan yang telah ditetapkan.

            
        <?php } ?>
        <br /> <br />

        Sekian, Terima Kasih.
    </div>
    

<div class="content">
    <!-- Signature content -->
    <div class="signature">
        Yang menjalankan tugas,<br />
        <br></br>
        <strong>Pegawai Bertanggungjawab</strong><br />
        Bahagian Hal Ehwal Pelajar<br />
        Universiti Teknologi MARA (UiTM) Puncak Perdana
<br></br>
        <strong><i>CETAKAN BERKOMPUTER. TIDAK PERLU TANDATANGAN.</i></strong>
    </div>
       

<hr />
<div class="text-end my-4 me-5">
        <?php echo $this->Html->image('../img/surat/ISO.jpg',['width'=>'150px']) ?>
    </div>
    <div class="text-end my-4 me-5">
        <?php echo $this->Html->image('../img/surat/uitmdihatiku.png',['width'=>'150px']) ?>
    </div>

    <div class="activity-data-container">
    <div class="card bg-body-tertiary border-0 shadow rounded-0">
        <div class="card-body">
            <div class="card-title text-center mb-3">Activity Data</div>
            <div class="tricolor_line"></div>

            <table class="table table-sm table-hover">
                <tr>
                    <td>Application Date</td>
                    <td><?php echo date('M d, Y (h:i A)', strtotime($activity->created)); ?></td>
                </tr>
                <tr>
                    <td>Approval Date</td>
                    <td><?php echo date('M d, Y (h:i A)', strtotime($activity->modified)); ?></td>
                </tr>
                <tr>
                    <td>Application Status</td>
                    <td>
                        <?php 
                        if ($activity->approvalstatus == 0) {
                            echo '<span class="badge bg-warning">Pending</span>';
                        } elseif ($activity->approvalstatus == 1) {
                            echo '<span class="badge bg-success">Approved</span>';
                        } elseif ($activity->approvalstatus == 2) {
                            echo '<span class="badge bg-danger">Rejected</span>';
                        } else {
                            echo '<span class="badge bg-danger">Error</span>';
                        }
                        ?>
                    </td>
                </tr>
            </table>
           
                <div class="text-end">
        <?php echo $this->Html->link('Download PDF', ['action' => 'pdf', $activity->id], ['class' => 'btn btn-sm btn-outline-primary', 'escapeTitle' => false]); ?>
     

</div>
            </div>
            </div>

</div>