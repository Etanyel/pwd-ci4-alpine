<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>ID Card</title>

    <style>
        body {
            background: dimgrey;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* FULL CANVAS WITH BLEED */
        .card-container {
            width: 91.6mm;
            height: 60mm;
            position: relative;
            background: white;
            overflow: hidden;
        }

        /* ACTUAL CARD SIZE */
        .card {
            position: absolute;
            top: 3mm;
            left: 3mm;
            width: 85.6mm;
            height: 54mm;
            overflow: hidden;
        }

        /* BACKGROUND IMAGE */
        .card img.bg {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* SAFE ZONE CONTENT */
        .content {
            position: absolute;
            top: 5mm;
            left: 1mm;
            right: 5mm;
            bottom: 5mm;
            color: black;
            font-family: Arial, sans-serif;
        }

        .name {
            font-size: 10pt;
            position: absolute;
            bottom: 20mm;
            text-align: center;
            left: 5mm;
            font-weight: bold;
        }

        .disability {
            font-size: 8pt;
            position: absolute;
            bottom: 13mm;
            left: 4mm;
            text-align: center;
            font-weight: bold;
        }

        .pwd_no {
            font-size: 7pt;
            position: absolute;
            bottom: 28.2mm;
            left: 9mm;
            font-weight: bold;
        }

        .photo {
            position: absolute;
            right: -1mm;
            left: 1;
            top: 19mm;
            width: 22mm;
            height: 22mm;
            object-fit: cover;
            border: .2px solid #000;
        }
    </style>

</head>

<body>

    <?php
    $disability = $record['disability'];
    $length = strlen($disability);

    $fontSize = 8;
    if ($length > 25) $fontSize = 7;
    if ($length > 40) $fontSize = 6;
    ?>

    <div class="card-container">
        <div class="card">
            <!-- Background -->
            <img src="<?= base_url('id_template/id_front.png') ?>" class="bg">

            <!-- Content -->
            <div class="content">
                <div class="pwd_no"><?= $record['pwd_no'] ?></div>
                <div class="name"><?= $record['firstname'] . ' ' . ($record['middlename'] == '' | null ? ' ' : $record['middlename'] . ' ') . $record['lastname'] ?></div>
                <div class="disability" style="font-size: <?= $fontSize ?>pt;">
                    <?= $disability ?>
                </div>

                <!-- Example Photo -->
                <img src="<?= base_url($record['img'] ?? '') ?>" class="photo">
            </div>
        </div>
    </div>

</body>

</html>