<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PDMHS</title>
    <link href="https://fonts.googleapis.com/css2?family=Albert+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #3b82f6;
            --accent: #60a5fa;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f1f5f9;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --gradient: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #f8fafc, #e0f2fe);
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .register-container {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 48px;
            box-shadow: 0 32px 64px rgba(30, 64, 175, 0.15);
            border: 1px solid rgba(30, 64, 175, 0.1);
            width: 800px;
            min-height: fit-content;
            position: relative;
            overflow: visible;
            margin: 2rem auto;
        }

        .register-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--gradient);
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-header h1 {
            font-size: 40px;
            font-weight: 900;
            margin-bottom: 8px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .register-header p {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 800;
            color: var(--gray);
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-row {
            display: flex;
            gap: 16px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--light);
            border-radius: 20px;
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #e9ecef;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-group select option {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 600;
            font-size: 16px;
            padding: 8px;
        }

        /* Enhanced Date Picker Styling */
        input[type="date"] {
            position: relative;
            cursor: pointer;
        }

        /* Hide default calendar picker */
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            position: absolute;
            right: 15px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        /* Custom calendar icon */
        input[type="date"] {
            position: relative;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e40af' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='15' rx='2' ry='2'/%3E%3Cline x1='16' y1='2' x2='16' y2='6'/%3E%3Cline x1='8' y1='2' x2='8' y2='6'/%3E%3Cline x1='3' y1='10' x2='21' y2='10'/%3E%3Ccircle cx='8' cy='14' r='1'/%3E%3Ccircle cx='12' cy='14' r='1'/%3E%3Ccircle cx='16' cy='14' r='1'/%3E%3Ccircle cx='8' cy='17' r='1'/%3E%3Ccircle cx='12' cy='17' r='1'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 20px 20px;
            padding-right: 45px;
        }

        /* Enhanced hover effect */
        input[type="date"]:hover {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%233b82f6' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='15' rx='2' ry='2'/%3E%3Cline x1='16' y1='2' x2='16' y2='6'/%3E%3Cline x1='8' y1='2' x2='8' y2='6'/%3E%3Cline x1='3' y1='10' x2='21' y2='10'/%3E%3Ccircle cx='8' cy='14' r='1'/%3E%3Ccircle cx='12' cy='14' r='1'/%3E%3Ccircle cx='16' cy='14' r='1'/%3E%3Ccircle cx='8' cy='17' r='1'/%3E%3Ccircle cx='12' cy='17' r='1'/%3E%3C/svg%3E");
        }

        /* Focus state */
        input[type="date"]:focus {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%231e40af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='4' width='18' height='15' rx='2' ry='2'/%3E%3Cline x1='16' y1='2' x2='16' y2='6'/%3E%3Cline x1='8' y1='2' x2='8' y2='6'/%3E%3Cline x1='3' y1='10' x2='21' y2='10'/%3E%3Ccircle cx='8' cy='14' r='1'/%3E%3Ccircle cx='12' cy='14' r='1'/%3E%3Ccircle cx='16' cy='14' r='1'/%3E%3Ccircle cx='8' cy='17' r='1'/%3E%3Ccircle cx='12' cy='17' r='1'/%3E%3C/svg%3E");
        }

        /* Date input text styling */
        input[type="date"]:valid {
            color: var(--dark);
        }

        input[type="date"]:invalid {
            color: var(--gray);
        }

        /* Calendar Popup Styling */
        input[type="date"]::-webkit-datetime-edit {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
        }

        /* Style the calendar popup */
        ::-webkit-calendar-picker-indicator {
            filter: invert(0.5);
        }

        /* Custom calendar dropdown styling */
        input[type="date"]:focus::-webkit-datetime-edit {
            background: transparent;
        }

        /* Calendar popup container */
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            background: rgba(30, 64, 175, 0.1);
            border-radius: 4px;
        }

        /* Global calendar popup styling */
        input[type="date"]::-webkit-datetime-edit-fields-wrapper {
            padding: 0;
        }

        input[type="date"]::-webkit-datetime-edit-text {
            color: var(--gray);
            padding: 0 0.3em;
        }

        input[type="date"]::-webkit-datetime-edit-month-field,
        input[type="date"]::-webkit-datetime-edit-day-field,
        input[type="date"]::-webkit-datetime-edit-year-field {
            font-family: 'Albert Sans', sans-serif;
            font-weight: 500;
            color: var(--dark);
            padding: 0 0.2em;
        }

        input[type="date"]::-webkit-datetime-edit-month-field:focus,
        input[type="date"]::-webkit-datetime-edit-day-field:focus,
        input[type="date"]::-webkit-datetime-edit-year-field:focus {
            background: rgba(30, 64, 175, 0.1);
            border-radius: 4px;
            outline: none;
        }

        .form-group input::placeholder {
            color: var(--gray);
        }

        .btn {
            width: 100%;
            padding: 16px 32px;
            border: none;
            border-radius: 20px;
            font-family: 'Albert Sans', sans-serif;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .btn-primary {
            background: var(--gradient);
            color: var(--white);
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(30, 64, 175, 0.4);
        }

        .register-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--light);
        }

        .register-footer p {
            color: var(--gray);
            font-size: 14px;
        }

        .register-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .register-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-container {
                margin: 2rem;
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Welcome! Create a Account</h1>
            <p>Sign up to access the PDMHS High School Clinic</p>
        </div>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" placeholder="Enter your middle name">
                    <div style="margin-top: 8px;">
                        <input type="checkbox" id="no_middle_name" style="width: auto; display: inline-block; margin-right: 8px;">
                        <label for="no_middle_name" style="display: inline; font-weight: normal; font-size: 14px;">I don't have middle name</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="birthday">Birthday</label>
                    <input type="date" id="birthday" name="birthday" required style="color: var(--gray);" onfocus="this.style.color='var(--dark)'" onblur="if(!this.value) this.style.color='var(--gray)'">
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" placeholder="Enter your complete address" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="tel" id="contact_number" name="contact_number" placeholder="Enter your contact number" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required>
                </div>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select your role</option>
                    <option value="clinic_staff">Clinic Staff</option>
                    <option value="adviser">Adviser</option>
                    <option value="student">Student</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Create Account
            </button>
        </form>
    </div>

    <script>
        // Handle "I don't have middle name" checkbox
        document.getElementById('no_middle_name').addEventListener('change', function() {
            const middleNameInput = document.getElementById('middle_name');
            if (this.checked) {
                middleNameInput.value = '';
                middleNameInput.disabled = true;
                middleNameInput.required = false;
                middleNameInput.style.backgroundColor = '#f1f5f9';
            } else {
                middleNameInput.disabled = false;
                middleNameInput.style.backgroundColor = '#ffffff';
            }
        });
    </script>
</body>
</html>
