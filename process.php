<?php
include "db.php";

// ✅ STOP direct access or refresh
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// ✅ Safe POST handling
$name = $_POST['name'] ?? '';
$age = $_POST['age'] ?? 0;
$sleep_time = $_POST['sleep_time'] ?? '';
$wake_time = $_POST['wake_time'] ?? '';
$stress = $_POST['stress'] ?? '';
$noise = $_POST['noise'] ?? '';

// ✅ Basic validation
if ($name === '' || $sleep_time === '' || $wake_time === '') {
    header("Location: index.php");
    exit;
}

// ✅ SAFE SQL (no errors, no injection)
$stmt = $conn->prepare("
INSERT INTO users (name, age, sleep_time, wake_time, stress, noise)
VALUES (?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "sissss",
    $name,
    $age,
    $sleep_time,
    $wake_time,
    $stress,
    $noise
);
$stmt->execute();


// ---------------- SLEEP CALCULATION ----------------
$sleepHours = (strtotime($wake_time) - strtotime($sleep_time)) / 3600;
if ($sleepHours < 0)
    $sleepHours += 24;

$score = 10;
$advice = "";

// Duration logic
if ($sleepHours < 6) {
    $score -= 3;
    $advice .=
        "Sleep Duration Analysis:
    You are sleeping only " . round($sleepHours, 1) . " hours, which is significantly below the recommended amount.
    Adults normally need 7–9 hours of sleep for proper brain function, immunity, and energy.
    Chronic short sleep can cause fatigue, poor focus, and mood problems.
    Try sleeping earlier, limit mobile usage before bed, and maintain a fixed sleep schedule.";
} elseif ($sleepHours < 7) {
    $score -= 1;
    $advice .=
        "Sleep Duration Analysis:
    Your sleep duration is slightly below ideal.
    Increasing your sleep by 30–60 minutes can improve concentration and daily performance.
    Going to bed a little earlier consistently will help.";
} else {
    $advice .=
        "Sleep Duration Analysis:
    Good sleep duration detected.
    You're getting enough rest to support mental and physical health.
    Keep maintaining this healthy sleep routine.";
}

// Stress logic
if ($stress === "high") {
    $score -= 3;
    $advice .=
        "Stress Level Analysis:
    High stress severely affects sleep quality and reduces deep sleep stages.
    Stress hormones keep your brain active even during sleep.
    Try meditation, deep breathing, calming music, or journaling before bedtime.
    Managing stress can greatly improve sleep quality.";
} elseif ($stress === "medium") {
    $score -= 1;
    $advice .=
        "Stress Level Analysis:
    Moderate stress detected.
    While it may not fully disrupt sleep, it can reduce sleep depth.
    Light exercise, reading, or relaxation techniques before bed can help.";
} else {
    $advice .=
        "Stress Level Analysis:
    Low stress level detected.
    This is ideal for achieving deep and restful sleep.
    Keep following stress-free routines before bedtime.";
}

// Noise logic
if ($noise === "high") {
    $score -= 2;
    $advice .=
        "Environmental Noise Analysis:
    High noise levels can wake you up multiple times during the night and prevent deep sleep.
    Continuous noise exposure may lead to sleep fragmentation.
    Consider earplugs, closing windows, or using white noise for better sleep quality.";
} elseif ($noise === "medium") {
    $score -= 1;
    $advice .=
        "Environmental Noise Analysis:
    Medium noise levels may slightly reduce sleep quality.
    Try minimizing background sounds or improving room insulation for better rest.";
} else {
    $advice .=
        "Environmental Noise Analysis:
    Quiet environment detected.
    This supports uninterrupted and high-quality sleep.
    Your sleep environment is well optimized.";
}


// ✅ Clamp score
if ($score < 0)
    $score = 0;
if ($score > 10)
    $score = 10;

// ✅ Color logic
$color = "#4facfe";
if ($score <= 4) {
    $color = "#ff6b6b";
} elseif ($score <= 7) {
    $color = "#feca57";
}

$dash = ($score / 10) * 251;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Sleep Report</title>

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: url('assets/img/sleeep_2.jpg') no-repeat center center / cover;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
        }

        .card {
            position: relative;
            width: 600px;
            padding: 35px 30px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            color: #fff;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
        }

        h2 {
            margin-bottom: 8px;
            font-weight: 600;
        }

        .sub {
            opacity: .85;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .score-box {
            position: relative;
            width: 170px;
            height: 170px;
            margin: 0 auto 25px;
        }

        svg {
            transform: rotate(-90deg);
        }

        circle {
            fill: none;
            stroke-width: 12;
            stroke-linecap: round;
        }

        .bg {
            stroke: rgba(255, 255, 255, 0.2);
        }

        .progress {
            stroke:
                <?php echo $color; ?>
            ;
            stroke-dasharray: 251;
            stroke-dashoffset: calc(251 -
                    <?php echo $dash; ?>
                );
            animation: fill 1.5s ease;
        }

        @keyframes fill {
            from {
                stroke-dashoffset: 251;
            }
        }

        .score-text {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: bold;
        }

        .advice {
            font-size: 15px;
            line-height: 1.6;
            opacity: .95;
        }
    </style>

</head>

<body>

    <div class="overlay"></div>

    <div class="card">
        <h2><?php echo htmlspecialchars($name); ?>'s Sleep Report</h2>
        <div class="sub">Overall Sleep Quality Score</div>

        <div class="score-box">
            <svg width="170" height="170">
                <circle class="bg" cx="85" cy="85" r="40" />
                <circle class="progress" cx="85" cy="85" r="40" />
            </svg>
            <div class="score-text"><?php echo $score; ?>/10</div>
        </div>

        <div class="advice"><?php echo htmlspecialchars($advice); ?></div>
    </div>

</body>

</html>