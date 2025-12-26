# Enhance Adviser Dashboard - Make Visits, Allergies, and Pending Visits Work

## Issues Identified
1. **Student profiles not clickable**: Advisers cannot access student profile pages (routes protected by admin middleware)
2. **Visit details not accessible**: Advisers cannot view clinic visit details
3. **Allergies not displayed**: Only count is shown, no detailed allergy information
4. **Pending visits not manageable**: No way for advisers to manage pending visits
5. **UI/UX improvements needed**: Dashboard could be more informative and user-friendly

## Tasks
- [x] Add adviser routes for viewing student profiles (read-only)
- [x] Add adviser routes for viewing clinic visits (read-only)
- [x] Create adviser-specific student show view
- [x] Create adviser-specific clinic visit show view
- [x] Improve allergies display in dashboard
- [x] Add pending visits management section
- [x] Enhance UI/UX with better styling and information
- [x] Update DashboardController with adviser methods
- [x] Test all functionality

## Files to Edit
- routes/web.php (add adviser routes)
- DashboardController.php (add adviser methods)
- adviser-dashboard.blade.php (improve UI/UX)
- Create adviser-specific views for students and visits

## Expected Results
- Advisers can click on student names to view read-only profiles
- Advisers can view clinic visit details
- Allergies are displayed with details in dashboard
- Pending visits section allows advisers to see and manage pending visits
- Improved UI/UX with better information layout
