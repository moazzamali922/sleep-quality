<!DOCTYPE html>
<html>

<head>
    <title>Smart Sleep Quality Advisor</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: url('https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3') no-repeat center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .container {
            position: relative;
            width: 500px;
            padding: 35px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
            color: #fff;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .row {
            display: flex;
            gap: 15px;
        }

        .field {
            flex: 1;
            margin-top: 15px;
        }

        label {
            font-size: 13px;
            opacity: .9;
        }

        input, select {
            width: 100%;
            padding: 11px;
            margin-top: 6px;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            background: transparent;
            border: 1px solid white;
            color: white;
        }

        option { color: black; }

        button {
            width: 100%;
            margin-top: 30px;
            padding: 13px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>

    <div class="container">
        <h2><i>Sleep Quality Advisor 🌙</i></h2>

        <form action="process.php" method="POST">

            <div class="row">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="field">
                    <label>Age</label>
                    <input type="number" name="age" required>
                </div>
            </div>

            <div class="row">
                <div class="field">
                    <label>Sleep Time</label>
                    <input type="time" name="sleep_time" required>
                </div>
                <div class="field">
                    <label>Wake Time</label>
                    <input type="time" name="wake_time" required>
                </div>
            </div>

            <div class="row">
                <div class="field">
                    <label>Stress Level</label>
                    <select name="stress">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="field">
                    <label>Noise Level</label>
                    <select name="noise">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
            </div>

            <button type="submit">Analyze My Sleep</button>
        </form>
    </div>
</body>
</html>
