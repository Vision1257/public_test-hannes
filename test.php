<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechteck Berechnung</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #111827;
            color: #f3f4f6;
            min-height: 100vh;
            padding: 60px 20px;
        }

        .container {
            max-width: 850px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            margin-bottom: 45px;
        }

        header h1 {
            font-size: 32px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 12px;
        }

        header p {
            color: #9ca3af;
            font-size: 15px;
        }

        .karten-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
        }

        .karte {
            background: #1f2937;
            border: 1px solid #374151;
            border-radius: 14px;
            padding: 28px;
            transition: 0.3s ease;
        }

        .karte:hover {
            border-color: #3b82f6;
            transform: translateY(-4px);
        }

        .karte h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #60a5fa;
        }

        .wert {
            display: flex;
            justify-content: space-between;
            padding: 13px 0;
            border-bottom: 1px solid #374151;
            font-size: 14px;
        }

        .wert:last-of-type {
            border-bottom: none;
        }

        .wert span:first-child {
            color: #9ca3af;
        }

        .wert span:last-child {
            color: #f9fafb;
            font-weight: 600;
        }

        .ergebnis {
            margin-top: 20px;
            padding: 14px;
            background: #172554;
            border-radius: 9px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ergebnis span:first-child {
            color: #93c5fd;
            font-size: 14px;
        }

        .status {
            margin-top: 18px;
            padding: 10px 14px;
            border-radius: 8px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        .ja {
            background: #064e3b;
            color: #6ee7b7;
        }

        .nein {
            background: #374151;
            color: #d1d5db;
        }

        footer {
            text-align: center;
            margin-top: 45px;
            color: #6b7280;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            body {
                padding: 35px 15px;
            }

            header h1 {
                font-size: 26px;
            }

            .karte {
                padding: 22px;
            }
        }
    </style>
</head>

<body>

<?php

class Rechteck {
    public float $breite = 0.0;
    public float $höhe = 0.0;

    function fläche(): float {
        return $this->breite * $this->höhe;
    }

    function umfang(): float {
        return 2 * ($this->breite + $this->höhe);
    }

    function isQuadrat(): bool {
        return $this->breite === $this->höhe;
    }
}

$figur1 = new Rechteck();
$figur1->breite = 4.0;
$figur1->höhe = 2.5;

$figur2 = new Rechteck();
$figur2->breite = 3.0;
$figur2->höhe = 3.0;

$figuren = [$figur1, $figur2];

?>

<div class="container">

    <header>
        <h1>Rechteck Berechnung</h1>
        <p>Geometrische Eigenschaften und Berechnungsergebnisse</p>
    </header>

    <div class="karten-container">

        <?php foreach ($figuren as $index => $figur): ?>

            <div class="karte">

                <h2>Rechteck <?= $index + 1 ?></h2>

                <div class="wert">
                    <span>Breite</span>
                    <span><?= $figur->breite ?> cm</span>
                </div>

                <div class="wert">
                    <span>Höhe</span>
                    <span><?= $figur->höhe ?> cm</span>
                </div>

                <div class="ergebnis">
                    <span>Fläche</span>
                    <strong><?= $figur->fläche() ?> cm²</strong>
                </div>

                <div class="ergebnis">
                    <span>Umfang</span>
                    <strong><?= $figur->umfang() ?> cm</strong>
                </div>

                <div class="status <?= $figur->isQuadrat() ? 'ja' : 'nein' ?>">
                    Quadrat: <?= $figur->isQuadrat() ? 'Ja' : 'Nein' ?>
                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <footer>
        Geometrische Berechnung · PHP Klassen und Objekte
    </footer>

</div>

</body>
</html>
