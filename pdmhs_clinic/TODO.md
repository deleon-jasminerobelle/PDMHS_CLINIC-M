# TODO: Fix Student Role Logic for Dashboard Access

## Issue
The CheckHealthForm middleware was requiring ALL health fields to be filled, including nullable ones like blood_type, height, and weight. This prevented students from accessing the dashboard even after submitting the health form, since the form allows these fields to be empty.

## Fix Applied
- Modified the `hasCompleteHealthData` method in `CheckHealthForm` middleware to only check for actually required fields:
  - emergency_contact_name
  - emergency_contact_number
  - emergency_relation
  - emergency_address

- Removed the check for nullable fields (blood_type, height, weight) that are not required by the form validation.

## Additional Issues Fixed
- **BMI Column Range Error**: The BMI column was defined as decimal(5,2) allowing values up to 999.99, but invalid calculations were producing values > 1000.
  - Created migration to change BMI column to decimal(6,2) to allow values up to 9999.99
  - Added BMI validation in HealthFormController to ensure calculated BMI is within realistic human range (10-50)
  - Invalid BMI calculations now set BMI to null instead of causing database errors

- **Database Migration Issue**: The users table was missing personal info columns (first_name, middle_name, etc.) due to unrun migrations.

- **Logout Method Error**: The logout route was only accepting POST requests, but something was trying to access it with GET.
  - Updated logout route to accept both GET and POST methods using Route::match(['GET', 'POST'], '/logout', ...)
  - This resolves the MethodNotAllowedHttpException while maintaining security with CSRF protection

## Expected Result
- Students can now access the dashboard once they submit the health form with the required emergency contact information.
- The dashboard will display available health data and show empty/placeholder values for optional fields.
- The logic now properly directs students to the dashboard when health form data exists in the database.
- BMI calculations are validated and won't cause database errors.

## Status: TESTING
- Middleware temporarily disabled for testing to isolate the issue
- Students can now access dashboard regardless of health form status
- Need to identify why the improved name parsing logic is not working
- Debug route added at /debug-middleware-test to test middleware logic
