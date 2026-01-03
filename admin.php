<?php
include "db.php";

// TOTAL USERS
$totalUsers = $conn->query("SELECT COUNT(*) total FROM users")
    ->fetch_assoc()['total'];

// STRESS LEVEL STATS
$stressData = [];
$res = $conn->query("SELECT stress, COUNT(*) c FROM users GROUP BY stress");
while ($r = $res->fetch_assoc()) {
    $stressData[$r['stress']] = $r['c'];
}

// NOISE LEVEL STATS
$noiseData = [];
$res = $conn->query("SELECT noise, COUNT(*) c FROM users GROUP BY noise");
while ($r = $res->fetch_assoc()) {
    $noiseData[$r['noise']] = $r['c'];
}

// RECENT USERS
$latest = $conn->query(
    "SELECT name, sleep_time, wake_time, stress, noise, created_at
 FROM users ORDER BY created_at DESC LIMIT 5"
);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Analytics</title>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: #0f2027;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .panel {
            width: 900px;
            padding: 30px;
            background: rgba(255, 255, 255, .1);
            backdrop-filter: blur(14px);
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .6);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .box {
            background: rgba(0, 0, 0, .35);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
        }

        .box h3 {
            margin: 0;
            font-size: 28px;
            color: #4facfe
        }

        .box p {
            margin-top: 6px;
            opacity: .8
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, .2);
            font-size: 14px;
        }

        th {
            text-align: left;
            opacity: .9
        }
    </style>
</head>

<body>

    <div class="panel">
        <h2>Admin Sleep Analytics 📊</h2>

        <div class="stats">
            <div class="box">
                <h3><?= $totalUsers ?></h3>
                <p>Total Users</p>
            </div>

            <div class="box">
                <h3><?= $stressData['high'] ?? 0 ?></h3>
                <p>High Stress Users</p>
            </div>

            <div class="box">
                <h3><?= $noiseData['high'] ?? 0 ?></h3>
                <p>High Noise Users</p>
            </div>
        </div>

        <h3>Recent Submissions</h3>

        <table>
            <tr>
                <th>Name</th>
                <th>Sleep</th>
                <th>Wake</th>
                <th>Stress</th>
                <th>Noise</th>
                <th>Date</th>
            </tr>

            <?php while ($u = $latest->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= $u['sleep_time'] ?></td>
                    <td><?= $u['wake_time'] ?></td>
                    <td><?= ucfirst($u['stress']) ?></td>
                    <td><?= ucfirst($u['noise']) ?></td>
                    <td><?= $u['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>

        </table>
    </div>

</body>

</html>