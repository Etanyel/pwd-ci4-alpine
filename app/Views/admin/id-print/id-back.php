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

        .address {
            font-size: x-small;
            position: relative;
            top: -2mm;
            left: 14mm;
            /* text-align: left; */
        }

        .birthdate {
            font-size: x-small;
            position: relative;
            top: -.6mm;
            left: 20mm;
        }

        .sex {
            font-size: x-small;
            position: relative;
            top: -3.5mm;
            left: 65mm;
        }

        .date_issued {
            font-size: x-small;
            position: relative;
            top: -2mm;
            left: 18mm;
        }

        .bloodtype {
            font-size: x-small;
            position: relative;
            top: -5mm;
            left: 68mm;
        }

        .valid {
            font-size: x-small;
            position: relative;
            top: -3.5mm;
            left: 18mm;
        }

        .status {
            font-size: x-small;
            position: relative;
            top: -6.8mm;
            left: 65mm;
        }

        .parent {
            font-size: small;
            position: relative;
            top: 6mm;
            left: -21mm;
            text-align: center;
        }

        .contactNumber {
            font-size: small;
            position: relative;
            top: 2mm;
            left: 24mm;
            text-align: center;
        }
    </style>

</head>

<body>

    <?php


    if ($person['fathers_name'] == null || empty($person['fathers_name'])) {
        if ($person['mothers_name'] == null || empty($person['mothers_name'])) {
            $parent = null;
        } else {
            $parent = $person['mothers_name'];
        }
    } else {
        $parent = $person['fathers_name'];
    }

    // $issue_date = new DateTime(date('F j, Y'));
    // $expiry_date = clone $issue_date;
    // $expiry_date->modify('+5 years');
    $issue_date = new DateTime();
    $expiry_date = (clone $issue_date)->modify('+5 years');
    ?>

    <div class="card-container">
        <div class="card">
            <!-- Background -->
            <img src="<?= base_url('id_template/id_back.jpg') ?>" class="bg">

            <!-- Content -->
            <div class="content">
                <div class="address"><?= $person['barangay'] . ', ' . $person['city_municipality'] ?></div>
                <div class="birthdate"><?= strtoupper(date('F j, Y', strtotime($person['birthdate']))) ?></div>
                <div class="sex"><?= strtoupper($person['sex']) ?></div>
                <div class="date_issued"><?= strtoupper(date('F j, Y')) ?></div>
                <div class="bloodtype"><?= $person['bloodtype'] ?></div>
                <div class="valid"><?= $expiry_date->format('F j, Y') ?></div>
                <div class="status">NEW</div>
                <div class="parent"><?= $parent ?></div>
                <div class="contactNumber"><?= $person['mobile_no'] ?? null ?></div>

                <!-- Example Photo -->
                <!-- <img src="" class="photo"> -->
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>

</html>