# Vaccine Registration System UI Guidelines

1. Start the PHP Server with `php artisan serve` and go to `/user/register` route for Registration Page.

2. There are 2 Tasks Scheduled: one for Scheduling Vaccination Date for User `ScheduleVaccineDate` (Job) & another for checking Whether the Vaccination Date for a User is expired or not `CheckVaccinationDateExpiry` (Job).

3. There are 2 Commands that run the scheduled tasks: `ScheduleVaccinationDateAndSendEmail` to schedule vaccination date and send email notification to the user & `CheckVaccinationDateExpiryCommand` to check the vaccination date expiry of user.

4. Don't forget to run the `queue:listen` or `queue:work` command to dispatch the queued jobs.
