This is the notetaking app created using Laravel and Vue using TailwindCSS to style the forms 

It is using PHP Version 8.4 and Node Version 20

ENV Variables need adding to the .env file

Example:
PROJECT_NAME=notetakingapp
PHP_VERSION=8.4
NODE_VERSION=20
PROJECT_BASE_URL=notetakingapp.local #change this to your local domain
DOCKER_ENV=dev #change this to dev or prod
USER_ID=1001 #change this to your user id


It was setup via Docker.

### Getting Started

1. **Clone the repository**
   ```bash
   git clone https://github.com/jorrel1995/notetakingapp.git
   ```
2. **Install dependencies:**
   ```bash
   docker compose up --build -d
   ```
3. **Initialize environment:**
   ```bash
   docker compose exec -it app bash
   cp .env.example .env 
   composer install
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   ```
5. **Run the application:**
   - The application will be available at [http://localhost](http://localhost).
   - To watch for frontend changes, run:
     ```bash
     npm run dev
     
     
Additional Task Queries 
Note: value in json given was spelt as "will.monetry_gifts" instead of "will.monetary_gifts" so the queries below are based on that

Query to retrieve all submissions with more than 2 trustees
```sql
SELECT *
FROM submissions
WHERE JSON_LENGTH(JSON_EXTRACT(answers, '$."will.trustees"')) > 2;

Explanation: Select all columns from the submissions table where the JSON_LENGTH function returns the number of trustees in the answers column (alias as j) and the WHERE clause filters the results to only include submissions where the JSON_LENGTH function returns a value greater than 2.
```

Query to get the sum of all monetary gifts across all submssions where the company ID = 2
```sql
SELECT SUM(j.amount) AS total_monetary_gifts
FROM submissions s
JOIN JSON_TABLE(
  s.answers,
  '$."will.monetry_gifts"[*]'
  COLUMNS (
    amount INT PATH '$.amount'
  )
) j
WHERE s.company_id = 2;

Explanation: Select the sum of the amount column (alias as total_monetary_gifts) from the submissions table (alias as s) and join the JSON_TABLE function to extract the monetary gifts from the answers column (alias as j). The JSON_TABLE function is used to extract the monetary gifts from the answers column and return them as a table with the amount column. The WHERE clause filters the results to only include submissions where the company_id is 2.
```

Query to  get the sum of of monetary gifts given to charities in submission with
ID = 1
```sql
SELECT SUM(j.amount) AS charity_total
FROM submissions s
JOIN JSON_TABLE(
  s.answers,
  '$."will.monetry_gifts"[*]'
  COLUMNS (
    amount INT PATH '$.amount',
    is_charity BOOLEAN PATH '$.gift.recipient.is_charity'
  )
) j
WHERE s.id = 1
  AND j.is_charity = true;

Explanation: Select the sum of the amount column (alias as charity_total) from the submissions table (alias as s) and join the JSON_TABLE function to extract the monetary gifts from the answers column (alias as j). The JSON_TABLE function is used to extract the monetary gifts from the answers column and return them as a table with the amount and is_charity columns. The WHERE clause filters the results to only include submissions where the id is 1 and the is_charity column is true.
```

Eloquent - Submission (Model Name )- return submissions which have 2 or more female trustees

```php
use App\Models\Submission;

function getSubmissionsWithFemaleTrustees()
{
    $submissions = Submission::all()->filter(function ($submission) {
        $trustees = $submission->answers['will.trustees'] ?? [];

        $femaleCount = collect($trustees)
            ->where('gender', 'female')
            ->count();
    
        if ($femaleCount >= 2) {
            return $submission;
        }

        return null;
    });

}

Explanation: Use the Submission model to retrieve all submissions and filter them using the filter method. The filter method takes a callback function that takes a submission as an argument and returns a boolean value. The callback function uses the data_get function to retrieve the trustees from the answers column of the submission. The trustees are then filtered using the where method to only include trustees with a gender of 'female'. The count method is then used to count the number of trustees with a gender of 'female'. If the count is greater than or equal to 2, the submission is returned. If the count is less than 2, null is returned.
```