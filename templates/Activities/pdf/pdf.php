<!DOCTYPE html>
<html lang="en">

<head>
    <title>Permohonan Pengesahan Aktiviti Kelab UiTM Puncak Perdana</title>
    <style>
        @page {
            margin: 0px !important;
            padding: 0px !important;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }

        .right {
            text-align: right;
            padding-right: 50px;
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
            margin-bottom: 50px;
            overflow: auto;
            text-align: justify;
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

        .table td,
        .table th {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .approval-status {
            font-weight: bold;
        }

        .approved {
            color: green;
        }

        .rejected {
            color: red;
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
            <td width="78%" style="vertical-align: top;">
                <p>
                    <strong>Alamat:</strong><br>
                    Universiti Teknologi MARA (UiTM) Puncak Perdana<br />
                    Jalan Pulau Angsa U10/1<br />
                    Seksyen U10<br />
                    40150 Shah Alam,<br />
                    Selangor<br />
                    <strong>Malaysia</strong>
                </p>
           
                <strong>Untuk Perhatian: <?= h($activity->user->fullname) ?></strong>
                <br><br>
                <strong style="text-align: justify; white-space: nowrap;">PERMOHONAN PENGESAHAN AKTIVITI KELAB DI UiTM PUNCAK PERDANA</strong>

                <br><br>
            </td>

            <td width="50%" style="vertical-align: top;">
                <table width="100%">
                    <tr>
                        <td width="50%" class="text-end">Surat Kami &nbsp;: &nbsp;</td>
                        <td>
                            <?= !empty($activity->ref_no) ? h($activity->ref_no) : 'Tiada Nombor Rujukan' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end">Tarikh &nbsp;: &nbsp;</td>
                        <td>
                            <?= !empty($activity->modified) ? h($activity->modified->format('d F Y')) : '-' ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="table table-bordered table-sm capital">
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
            <td><?=date ('d M, Y', strtotime($activity->date)) ?></td>
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
            <td>STATUS KELULUSAN</td>
            <td>:</td>
            <td class="approval-status <?= $activity->approvalstatus == 1 ? 'approved' : 'rejected' ?>">
                <?= $activity->approvalstatus == 1 ? '<span class="approved">DILULUSKAN</span>' : '<span class="rejected">TIDAK DILULUSKAN</span>' ?>
            </td>
        </tr>
    </table>

    <br />

    <div class="justify">
        <?php if ($activity->approvalstatus == 1) { ?>
            3. Sukacita dimaklumkan bahawa permohonan aktiviti ini telah <strong class="approved">DILULUSKAN</strong>. Sila pastikan semua peraturan dipatuhi:
            <ul>
                <li>Mematuhi semua garis panduan keselamatan universiti.</li>
                <li>Mendapatkan kelulusan bertulis dari pihak keselamatan jika melibatkan kawasan luar kampus.</li>
                <li>Menyerahkan laporan aktiviti selepas program selesai.</li>
            </ul>
        <?php } else { ?>
            3. Dukacita dimaklumkan bahawa permohonan aktiviti ini <strong class="rejected">TIDAK DILULUSKAN</strong> kerana:
            <ul>
                <li><?= h($activity->rejection_reason) ?></li>
            </ul>
        <?php } ?>
       
    </div>



    <table width="100%">
    <tr>
        <td width="85%" style="vertical-align: bottom;">
            Sekian, Terima Kasih
            <br />
            <?= $activity->status == 0 
                ? '<strong class="text-danger">[Dalam Proses Semakan]</strong>' 
                : ($activity->status == 1 
                    ? 'Yang menjalankan tugas,<br/><strong>Pegawai Bertanggungjawab</strong><br />Bahagian Hal Ehwal Pelajar<br />
                    Universiti Teknologi MARA (UiTM) Puncak Perdana<br /><strong>CETAKAN BERKOMPUTER. TIDAK PERLU TANDATANGAN</strong>' 
                    : 'Rejected') ?>
        </td>
        <td width="5%" class="right" style="vertical-align: bottom;">
            <img src="http://localhost/scm3/js/qr-pdf/qrcode.php?s=qrh&d=<?= $this->request->getUri(); ?>" class="qr" style="width: 85px; height: 85px;">
        </td>
    </tr>
</table>

<hr style="margin: 5px 0;" />

<!-- Logo Section (Bottom-Aligned) -->
<div class="right" style="text-align: right; display: flex; justify-content: flex-end; align-items: flex-end; gap: 30px;">

    <?php echo $this->Html->image('/img/surat/ISO.png', ['width' => '70px', 'fullBase' => true]); ?>
    <?php echo $this->Html->image('/img/surat/uitmdihatiku.png', ['width' => '80px', 'fullBase' => true]); ?>
</div>

</body>
</html>

