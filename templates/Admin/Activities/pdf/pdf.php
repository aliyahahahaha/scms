<!DOCTYPE html>
<html lang="en">
<head>
  
    <title>Activity</title>
    <style>
        @page {
            margin: 0px !important;
            padding: 0px !important;
        }

        .body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

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

.content {
    margin-left: 70px;
    margin-right: 70px;
}
    </style>

</head>
<body>
    <section class="top">
            <div class="one"></div>
            <div class="two"></div>
    </section>

    <div class="text-end my-4 me-5">
        <?php echo $this->Html->image('../img/surat/logouitm.png',['width'=>'180px', 'fullBase' => true]) ?>
    </div>

    <hr />

    <div class="content">
    <table width="100%">
    <tr>
        <td width="78%" class="text-end">Surat Kami &nbsp; : &nbsp; </td>
        <td>
            <?php 
            if ($activity->approvalstatus == 0) {
                echo 'Pending';
            } elseif ($activity->approvalstatus == 1) {
                echo 'Approve';
            } elseif ($activity->approvalstatus == 2) {
                echo 'Rejected';

            } else 
                echo 'Error';
        
            ?>
        </td>
    </tr>

    <tr>
        <td class="text-end">Tarikh &nbsp; : &nbsp; </td>
        <td>
            
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

    <strong>Untuk Perhatian: <?= h($activity->user->fullname) ?></strong>
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

        
    </div>

<table width="100%">
    <tr>
        <td width="85%">
        Sekian, Terima Kasih.
        <br></br>
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
        <td width="5%" class="right">
        <img src="<?php echo 'http://localhost/scm/js/qr-pdf/qrcode.php?-s=qrh&d=' . urlencode($this->request->getUri()); ?>" class="qr">


        </td>
    </tr>


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
    </div>  

<hr />
<<div class="text-end my-4 me-5">
    <?php echo $this->Html->image('/img/surat/ISO.jpg', ['width' => '150px', 'fullBase' => true]); ?>
</div>

<div class="text-end my-4 me-5">
    <?php echo $this->Html->image('/img/surat/uitmdihatiku.png', ['width' => '150px', 'fullBase' => true]); ?>
</div> 
 
</body>
</html>