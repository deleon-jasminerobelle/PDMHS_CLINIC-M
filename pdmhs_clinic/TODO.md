# TODO: Fix Routes After Form Submission and Login

## Tasks
- [x] Update HealthFormController::store to set session('student_profile') and redirect to 'student.dashboard'
- [x] Update LoginController::login to redirect to 'student.dashboard' if session('student_profile') exists
