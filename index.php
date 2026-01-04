<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Sleep Quality Advisor</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <style>
        /* Basic & Reset */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            min-height: 100vh;
            background: url('https://images.unsplash.com/photo-1444703686981-a3abbc4d4fe3') no-repeat center/cover;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 500px;
            padding: 40px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            color: #fff;
            overflow: hidden;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            font-style: italic;
        }

        form .step {
            display: none;
        }

        form .step.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .field {
            margin-top: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.7);
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        input::placeholder,
        textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        select option {
            color: black;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #4facfe;
            box-shadow: 0 0 10px rgba(79, 172, 254, 0.5);
            background: rgba(255, 255, 255, 0.15);
        }

        button {
            padding: 12px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .next-btn {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: #fff;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            margin-right: 10px;
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>

    <div class="container">
        <h2>Sleep Quality Advisor 🌙</h2>

        <form id="sleepForm" action="process.php" method="POST">

            <!-- Step 1 -->
            <div class="step active">
                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Enter your name" required>
                </div>
                <div class="field">
                    <label>Age</label>
                    <input type="number" name="age" placeholder="Enter your age" required>
                </div>
                <button type="button" class="next-btn">Next</button>
            </div>

            <!-- Step 2 -->
            <div class="step">
                <div class="field">
                    <label>Gender</label>
                    <select name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="field">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="">Select Status</option>
                        <option value="child">Child</option>
                        <option value="student">Student</option>
                        <option value="employee">Employee</option>
                        <option value="self_employed">Self Employed</option>
                    </select>
                </div>

                <button type="button" class="back-btn">Back</button>
                <button type="button" class="next-btn">Next</button>
            </div>

            <!-- Step 3 -->
            <div class="step">
                <div class="field">
                    <label>Sleep Time</label>
                    <input type="time" name="sleep_time" required>
                </div>

                <div class="field">
                    <label>Wake Time</label>
                    <input type="time" name="wake_time" required>
                </div>

                <div class="field">
                    <label>Noise Level</label>
                    <select name="noise">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <button type="button" class="back-btn">Back</button>
                <button type="button" class="next-btn">Next</button>
            </div>

            <!-- Step 4 -->
            <div class="step">
                <div class="field">
                    <label>Daily Routine</label>
                    <textarea name="routine" placeholder="Describe your daily routine..." rows="4"></textarea>
                </div>
                <button type="button" class="back-btn">Back</button>
                <button type="submit" class="next-btn">Submit</button>
            </div>

        </form>
    </div>

    <script>
        $(document).ready(function () {
            var currentStep = 0;
            var steps = $(".step");

            function showStep(index) {
                steps.removeClass("active").eq(index).addClass("active");
            }

            $(".next-btn").click(function () {
                if (currentStep < steps.length - 1) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            $(".back-btn").click(function () {
                if (currentStep > 0) {
                    currentStep--;
                    showStep(currentStep);
                }
            });
        });
    </script>
</body>

</html>
