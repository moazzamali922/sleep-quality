<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$name = $_POST['name'] ?? '';
$age = $_POST['age'] ?? 0;
$sleep_time = $_POST['sleep_time'] ?? '';
$wake_time = $_POST['wake_time'] ?? '';
$stress = $_POST['stress'] ?? 'low';
$noise = $_POST['noise'] ?? 'low';
$routine = $_POST['routine'] ?? '';

if ($name === '' || $sleep_time === '' || $wake_time === '') {
    header("Location: index.php");
    exit;
}

// Save user data
$stmt = $conn->prepare("INSERT INTO users (name, age, sleep_time, wake_time, stress, noise, routine) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sisssss", $name, $age, $sleep_time, $wake_time, $stress, $noise, $routine);
$stmt->execute();

// ---------------- SLEEP CALCULATION ----------------
$sleepHours = (strtotime($wake_time) - strtotime($sleep_time)) / 3600;
if ($sleepHours < 0) $sleepHours += 24;

$score = 10;
$adviceArray = [];

// Duration
if ($sleepHours < 6) {
    $score -= 3;
    $adviceArray[] = "Sleep Duration Analysis: You are sleeping only " . round($sleepHours,1) . " hours. Try sleeping earlier and maintain a fixed schedule.";
} elseif ($sleepHours < 7) {
    $score -= 1;
    $adviceArray[] = "Sleep Duration Analysis: Your sleep duration is slightly below ideal. Consider sleeping 30–60 min longer.";
} else {
    $adviceArray[] = "Sleep Duration Analysis: Good sleep duration detected.";
}

// Stress
if ($stress === "high") {
    $score -= 3;
    $adviceArray[] = "Stress Level Analysis: High stress affects sleep. Try meditation or journaling.";
} elseif ($stress === "medium") {
    $score -= 1;
    $adviceArray[] = "Stress Level Analysis: Moderate stress detected. Relaxation before bed can help.";
} else {
    $adviceArray[] = "Stress Level Analysis: Low stress level detected. Ideal for deep sleep.";
}

// Noise
if ($noise === "high") {
    $score -= 2;
    $adviceArray[] = "Environmental Noise Analysis: High noise affects sleep. Use earplugs or white noise.";
} elseif ($noise === "medium") {
    $score -= 1;
    $adviceArray[] = "Environmental Noise Analysis: Medium noise may slightly reduce sleep quality.";
} else {
    $adviceArray[] = "Environmental Noise Analysis: Quiet environment detected. Good for sleep.";
}

// Recommendations
$recommendations = [
    "Maintain a consistent sleep schedule.",
    "Reduce screen time before bed.",
    "Practice relaxation techniques like meditation.",
    "Keep your bedroom quiet, dark, and cool.",
    "Avoid caffeine and heavy meals before bedtime."
];

// Clamp score
$score = max(0, min(10, $score));

// Score color
if ($score <= 4) {
    $color = "#ff6b6b"; // red
    $sleepLevel = "Poor";
} elseif ($score <= 7) {
    $color = "#feca57"; // yellow
    $sleepLevel = "Average";
} else {
    $color = "#2ecc71"; // green
    $sleepLevel = "Excellent";
}

// SVG calculation
$radius = 70;
$circumference = 2 * pi() * $radius;
$dashOffset = $circumference * (1 - $score / 10);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sleep Quality Certificate</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #6dd5ed, #2193b0);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .certificate {
            background: #fff;
            color: #333;
            width: 750px;
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            padding: 40px;
            text-align: center;
            position: relative;
        }

        .certificate-header {
            background: #4facfe;
            background: linear-gradient(to right, #43e97b, #38f9d7);
            border-radius: 15px 15px 0 0;
            padding: 20px;
            color: white;
        }

        .certificate-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .certificate-header h3 {
            margin: 5px 0 0;
            font-weight: normal;
            opacity: 0.85;
        }

        .score-box {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 25px auto;
        }

        svg {
            transform: rotate(-90deg);
        }

        circle {
            fill: none;
            stroke-width: 14;
            stroke-linecap: round;
        }

        .bg {
            stroke: rgba(0,0,0,0.1);
        }

        .progress {
            stroke: <?= $color ?>;
            stroke-dasharray: <?= $circumference ?>;
            stroke-dashoffset: <?= $circumference ?>;
            animation: fill 1.5s forwards;
        }

        @keyframes fill {
            to {
                stroke-dashoffset: <?= $dashOffset ?>;
            }
        }

        .score-text {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: bold;
        }

        .score-text span {
            font-size: 16px;
            opacity: 0.8;
            margin-top: 5px;
        }

        .section {
            text-align: left;
            margin: 20px 0;
        }

        .section h4 {
            font-size: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .section ul {
            margin-left: 20px;
            line-height: 1.6;
        }

        .analysis p {
            margin: 8px 0;
        }

        .important-note {
            margin-top: 25px;
            background: #ffe6e6;
            color: #c00;
            padding: 15px;
            border-left: 6px solid #c00;
            font-size: 14px;
        }

        @media(max-width:780px){
            .certificate{width:95%;padding:30px;}
            .score-box{width:150px;height:150px;}
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="certificate-header">
            <h1>Certified Sleep Quality Report</h1>
            <h3><?= htmlspecialchars($name) ?>, Age <?= $age ?></h3>
        </div>

        <div class="score-box">
            <svg width="180" height="180">
                <circle class="bg" cx="90" cy="90" r="<?= $radius ?>" />
                <circle class="progress" cx="90" cy="90" r="<?= $radius ?>" />
            </svg>
            <div class="score-text">
                <?= $score ?>/10
                <span><?= $sleepLevel ?></span>
            </div>
        </div>

        <div class="section">
            <h4>Recommendations to Improve Sleep</h4>
            <ul>
                <?php foreach($recommendations as $rec): ?>
                    <li><?= htmlspecialchars($rec) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="section analysis">
            <h4>Analysis Details</h4>
            <?php foreach ($adviceArray as $line): ?>
                <p><?= htmlspecialchars($line) ?></p>
            <?php endforeach; ?>
        </div>

        <div class="important-note">
            <strong>Important:</strong> This report is for guidance only. If you experience persistent sleep problems, consult a doctor or sleep specialist.
        </div>
    </div>
</body>
</html>
