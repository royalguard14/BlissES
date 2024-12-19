<?php 
require_once 'BaseController.php'; 


class AdviserMngtController extends BaseController { 

    public function __construct($db) { 
        parent::__construct($db, ['9','8','7']);  

    } 


    public function generateGradeRecord(){
        try {
            $adviserId = $_SESSION['user_id'];
            $result = $this->getAdviserSectionAndGrade($adviserId);
        // Fetch advisory class information
        $stmt = $this->db->prepare("
            SELECT 
            s.id AS section_id, 
            s.section_name, 
            s.daytime, 
            COALESCE(p.lrn, 'No Data') AS lrn, 
            CONCAT(
                COALESCE(p.last_name, ''), ', ',
                COALESCE(p.first_name, ''), ' ',
                COALESCE(
                    CASE
                    WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                    THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                    ELSE ''
                    END, 
                    '') 
                ) AS fullname,
            p.profile_id, 
            p.sex,
            eh.id AS eh_id 
            FROM 
            sections s
            LEFT JOIN 
            enrollment_history eh ON eh.section_id = s.id
            LEFT JOIN 
            profiles p ON eh.user_id = p.profile_id
            WHERE 
            s.adviser_id = :adviser_id
            Order by p.last_name ASC
            ");
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();
        $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);



        // Fetch all subjects in the grade level
        $stmt = $this->db->prepare("
            SELECT 
            s.id AS subject_id,
            s.name AS subject_name
            FROM 
            subjects s
            WHERE 
            FIND_IN_SET(s.id, (
                SELECT 
                gl.subject_ids
                FROM 
                grade_level gl
                WHERE 
                gl.id = :grade_level
                )) > 0
            ");
        $stmt->bindValue(':grade_level', $result['grade_level_id'], PDO::PARAM_INT);
        $stmt->execute();
        $allSubjectInGrade = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Sanitize and check if arrays are empty before querying grades
        $studentIds = array_column($advisoryClass, 'profile_id');
        $subjectIds = array_column($allSubjectInGrade, 'subject_id');



    #echo '<pre>'.var_export($studentIds,true).'</pre>';




$gradesStmt = $this->db->prepare("
    SELECT 
        gr.user_id, 
        gr.subject_id, 
        SUM(IFNULL(gr.grade, 0)) / 4 AS average_grade
    FROM 
        grade_records gr
    WHERE 
        gr.user_id IN (" . implode(',', array_map('intval', $studentIds)) . ")
        AND gr.subject_id IN (" . implode(',', array_map('intval', $subjectIds)) . ")
    GROUP BY 
        gr.user_id, gr.subject_id
");
$gradesStmt->execute();
$grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);


$gradeMap = [];
foreach ($grades as $grade) {
    $gradeMap[$grade['user_id']][$grade['subject_id']] = round($grade['average_grade'], 2); // Round to 2 decimal places
}


echo '<table border="1" style="width: 100%; text-align: center; border-collapse: collapse;">';
echo '<thead>';
echo '<tr>';
echo '<th style="padding: 10px; text-align: left;">Student Name</th>';

// Add subjects as column headers
foreach ($allSubjectInGrade as $subject) {
    echo '<th style="padding: 10px;">' . htmlspecialchars($subject['subject_name']) . '</th>';
}
echo '<th style="padding: 10px;">Gen. Ave</th>'; // Add Average column
echo '</tr>';
echo '</thead>';

echo '<tbody>';
foreach ($advisoryClass as $student) {
    echo '<tr>';
    // Student name in the first column
    echo '<td style="padding: 10px; text-align: left;">' . htmlspecialchars($student['fullname']) . '</td>';
    
    $totalGrade = 0;
    $subjectsTaken = 0;

    // Grades for each subject
    foreach ($allSubjectInGrade as $subject) {
        $grade = $gradeMap[$student['profile_id']][$subject['subject_id']] ?? 0; // Use 0 if no grade
        echo '<td style="padding: 10px;">' . $grade . '</td>';
        
        // Only count non-zero grades for averaging
        if ($grade > 0) {
            $totalGrade += $grade;
            $subjectsTaken++;
        }
    }
    
    // Compute the average, avoid division by zero
    $average = $subjectsTaken > 0 ? round($totalGrade / $subjectsTaken, 2) : 0;
    echo '<td style="padding: 10px;">' . $average . '</td>'; // Display the average
    echo '</tr>';
}
echo '</tbody>';
echo '</table>';








        } catch (Exception $e) {

            echo $e->getMessage();
            return; 
        }
    }

    public function generateStudentList(){
        try {
            $adviserId = $_SESSION['user_id'];
            $result = $this->getAdviserSectionAndGrade($adviserId);
            $_SESSION['section_id'] = $result['section_id'];
            $stmt = $this->db->prepare("
                SELECT 
                s.id as section_id, 
                s.section_name, 
                s.daytime, 
                COALESCE(p.lrn, 'No Data') AS lrn, 
                CONCAT(
                    COALESCE(p.last_name, ''), ', ',
                    COALESCE(p.first_name, ''), ' ',
                    COALESCE(
                        CASE
                        WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                        THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                        ELSE ''
                        END, 
                        '') 
                    ) AS fullname,
                p.profile_id, 
                p.sex
                FROM sections s
                LEFT JOIN enrollment_history eh ON eh.section_id = s.id
                LEFT JOIN profiles p ON eh.user_id = p.profile_id
                WHERE s.adviser_id = :adviser_id
                ");
            $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
            $stmt->execute();
            $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Separate male and female students
            $maleStudents = array_filter($advisoryClass, fn($student) => $student['sex'] === 'M');
            $femaleStudents = array_filter($advisoryClass, fn($student) => $student['sex'] === 'F');




        } catch (Exception $e) {

            echo $e->getMessage();
            return; 
        }
        echo '
        <table border="1" style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
        <tr>
        <th style="width: 50%; padding: 10px;">Male</th>
        <th style="width: 50%; padding: 10px;">Female</th>
        </tr>
        </thead>
        <tbody>';

        $maxRows = max(count($maleStudents), count($femaleStudents));
        $maleList = array_values($maleStudents);
        $femaleList = array_values($femaleStudents);

        for ($i = 0; $i < $maxRows; $i++) {
            echo '<tr>';
    // Male column
            echo '<td style="padding: 10px;">';
            if (isset($maleList[$i])) {
                echo $maleList[$i]["fullname"];
            }
            echo '</td>';

    // Female column
            echo '<td style="padding: 10px;">';
            if (isset($femaleList[$i])) {
                echo $femaleList[$i]["fullname"];
            }
            echo '</td>';
            echo '</tr>';
        }

        echo '
        </tbody>
        </table>';

    }












    public function generateSF2Report(){
        try {
            $month_id = $_GET['month_id'];
          // Get the current grading from campus_info table
            $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 8");
            $stmt->execute();
            $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
            $currentGrading = (int)$campusInfoData['function'];
            $stmt = $this->db->prepare("SELECT * FROM campus_info WHERE id = 6");
            $stmt->execute();
            $CampusInfoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $present_school_year = (int) $CampusInfoData[0]['function'];
    // Get the adviser ID from the session
            $adviserId = $_SESSION['user_id'];
            $result = $this->getAdviserSectionAndGrade($adviserId);
            $_SESSION['section_id'] = $result['section_id'];
 // Fetch the adviser's section student for this year
            $stmt = $this->db->prepare("SELECT
                eh.id,p.sex,eh.user_id
                FROM enrollment_history eh
                LEFT JOIN profiles p ON p.profile_id = eh.user_id
                WHERE 
                eh.grade_level_id = :grade_level_id 
                AND eh.section_id = :section_id
                AND adviser_id = :adviser_id
                AND academic_year_id = :academic_year_id
                ");
            $stmt->bindValue(':grade_level_id', $result['grade_level_id'], PDO::PARAM_INT);
            $stmt->bindValue(':section_id', $result['section_id'], PDO::PARAM_INT);
            $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
            $stmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
            $stmt->execute();
            $mystudent = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Extract the user IDs from $mystudent array to filter only your students
            $studentUserIds = array_map(function($student) {
                return $student['user_id'];
            }, $mystudent);

// Convert the array of user IDs to a comma-separated string
            $userIdsString = implode(',', $studentUserIds);

// Prepare the query with a LEFT JOIN to ensure users without attendance records are included
            $stmt = $this->db->prepare("
                SELECT
                p.sex,
                ar.user_id,
                ar.date,
                COUNT(CASE WHEN ar.status = 'P' THEN 1 END) AS present_count,
                COUNT(CASE WHEN ar.status = 'A' THEN 1 END) AS absent_count,
                COUNT(CASE WHEN ar.status = 'T' THEN 1 END) AS tardy_count,
                COUNT(CASE WHEN ar.status = 'E' THEN 1 END) AS excused_count
                FROM profiles p
                LEFT JOIN attendance_records ar ON p.profile_id = ar.user_id AND DATE_FORMAT(ar.date, '%Y-%m') = :month
    WHERE p.profile_id IN ($userIdsString)  -- Filter for your specific students
    GROUP BY p.profile_id
    ");
$stmt->bindValue(':month', $month_id, PDO::PARAM_STR);  // Bind the month in 'YYYY-MM' format
$stmt->execute();
// Fetch the results
$attendanceData = $stmt->fetchAll(PDO::FETCH_ASSOC);





$year = 2024;
$firstFridayOfJune = date('Y-m-d', strtotime("first Friday of June $year"));
$oneMonthBefore = date('Y-m-d', strtotime("$firstFridayOfJune -1 month")); // May 2024
// Query 1: Get enrollments one month before the first Friday of June
$stmt1 = $this->db->prepare("
    SELECT 
    p.sex, 
    COUNT(*) AS count
    FROM enrollment_history eh
    JOIN profiles p ON p.profile_id = eh.user_id
    WHERE eh.enrollment_date <= :firstFridayOfJune
    AND eh.enrollment_date > :oneMonthBefore
    AND eh.user_id IN ($userIdsString)
    GROUP BY p.sex
    ");
$stmt1->bindValue(':firstFridayOfJune', $firstFridayOfJune, PDO::PARAM_STR);
$stmt1->bindValue(':oneMonthBefore', $oneMonthBefore, PDO::PARAM_STR);
$stmt1->execute();
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
// Default result structure for Query 1
$defaultResult1 = [
    ['sex' => 'M', 'count' => 0],
    ['sex' => 'F', 'count' => 0]
];
// Update the default structure with actual counts for Query 1
foreach ($result1 as $row) {
    foreach ($defaultResult1 as &$defaultRow1) {
        if ($defaultRow1['sex'] === $row['sex']) {
            $defaultRow1['count'] = $row['count'];
            break;
        }
    }
}



// Get the first Friday of June
$firstFridayOfJune = date('Y-m-d', strtotime("first Friday of June $year"));

// Get the last day of the month specified by $month_id (e.g., November 2024)
$lastDayOfMonth = date('Y-m-t', strtotime($month_id)); // 'Y-m-t' gives the last day of the month

// Query 3: Get enrollments from the first Friday of June until the end of the specified month (e.g., 2024-11)
$stmt3 = $this->db->prepare("
    SELECT 
    p.sex, 
    COUNT(*) AS count
    FROM enrollment_history eh
    JOIN profiles p ON p.profile_id = eh.user_id
    WHERE eh.enrollment_date BETWEEN :start_date AND :end_date
    AND eh.user_id IN ($userIdsString)
    GROUP BY p.sex
    ");
$stmt3->bindValue(':start_date', $firstFridayOfJune, PDO::PARAM_STR);
$stmt3->bindValue(':end_date', $lastDayOfMonth, PDO::PARAM_STR);
$stmt3->execute();
$result3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

// Default result structure for Query 3
$defaultResult3 = [
    ['sex' => 'M', 'count' => 0],
    ['sex' => 'F', 'count' => 0]
];

// Update the default structure with actual counts for Query 3
foreach ($result3 as $row) {
    foreach ($defaultResult3 as &$defaultRow3) {
        if ($defaultRow3['sex'] === $row['sex']) {
            $defaultRow3['count'] = $row['count'];
            break;
        }
    }
}



// Calculate the total for Query 1
$enrollie1stofjuneM = $defaultResult1[0]['count'];
$enrollie1stofjuneF = $defaultResult1[1]['count'];
$enrollie1stofjuneT = $enrollie1stofjuneM + $enrollie1stofjuneF;

// Calculate the total for Query 3
$enrolliepassofjuneM = $defaultResult3[0]['count'];
$enrolliepassofjuneF = $defaultResult3[1]['count'];
$enrolliepassofjuneT = $enrolliepassofjuneM + $enrolliepassofjuneF;

// Query 4: Get the sum of all males and females across all queries
$totalMales = $enrollie1stofjuneM +  $enrolliepassofjuneM;
$totalFemales = $enrollie1stofjuneF +  $enrolliepassofjuneF;
$total = $totalMales + $totalFemales;


$totalPresentM = 0;
$totalAbsentM = 0;
$totalPresentF = 0;
$totalAbsentF = 0;
$weekdayCount = 0;

// Get the first and last day of the month
$firstDayOfMonth = date('Y-m-d', strtotime("$month_id-01"));
$lastDayOfMonth = date('Y-m-t', strtotime($firstDayOfMonth));
// Initialize a counter for weekdays (Monday to Friday)

// Loop through each day of the month
$currentDate = $firstDayOfMonth;
while ($currentDate <= $lastDayOfMonth) {
    // Check if the current day is Monday to Friday (1 to 5 in the 'N' format)
    if (date('N', strtotime($currentDate)) <= 5) {
        $weekdayCount++;
    }
    // Move to the next day
    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}




$maleAttendance = array_filter($attendanceData, fn($data) => $data['sex'] === 'M');
foreach ($maleAttendance as &$data) {
    $data['totalPresent'] = $data['present_count'] + $data['tardy_count'];
    $data['totalAbsent'] = $weekdayCount - ($data['present_count'] + $data['tardy_count']);
    $totalPresentM += $data['totalPresent'];
    $totalAbsentM += $data['totalAbsent'];
}

$femaleAttendance = array_filter($attendanceData, fn($data) => $data['sex'] === 'F');
foreach ($femaleAttendance as &$data) {
    $data['totalPresent'] = $data['present_count'] + $data['tardy_count'];
    $data['totalAbsent'] = $weekdayCount - ($data['present_count'] + $data['tardy_count']);
    $totalPresentF += $data['totalPresent'];
    $totalAbsentF+= $data['totalAbsent'];
}


// Male attendance calculations
$totalAttendanceM = (($totalMales * $weekdayCount) - $totalAbsentM);
$adaM = ($weekdayCount != 0) ? intval(round($totalAttendanceM / $weekdayCount)) : 0;
$paM = ($totalMales != 0) ? intval(round(($adaM / $totalMales) * 1)) : 0;
$poeM = ($enrollie1stofjuneM != 0) ? intval(round(($totalMales / $enrollie1stofjuneM) * 1)) : 0;

// Female attendance calculations
$totalAttendanceF = (($totalFemales * $weekdayCount) - $totalAbsentF);
$adaF = ($weekdayCount != 0) ? intval(round($totalAttendanceF / $weekdayCount)) : 0;
$paF = ($totalFemales != 0) ? intval(round(($adaF / $totalFemales) * 1)) : 0;
$poeF = ($enrollie1stofjuneF != 0) ? intval(round(($totalFemales / $enrollie1stofjuneF) * 1)) : 0;

// Total attendance calculations
$poeT = ($enrollie1stofjuneT != 0) ? intval(round(($total / $enrollie1stofjuneT) * 1)) : 0;
$adaT = ($weekdayCount != 0) ? intval(round(($totalAttendanceM + $totalAttendanceF) / $weekdayCount)) : 0;
$paT = ($total != 0) ? intval(round(($adaT / $total) * 1)) : 0;




// para sa MGa absent, include na din sa data ang mga araw na na absenan nila kada month na binabato!


// Helper function to get all weekdays in a month
function getWeekdaysInMonth($month_id) {
    $startDate = new DateTime("$month_id-01");
    $endDate = new DateTime($startDate->format('Y-m-t')); // Last day of the month
    $weekdays = [];

    while ($startDate <= $endDate) {
        // Add to weekdays if it's a weekday (Monday to Friday)
        if (in_array($startDate->format('N'), [1, 2, 3, 4, 5])) {
            $weekdays[] = $startDate->format('Y-m-d');
        }
        $startDate->modify('+1 day');
    }
    return $weekdays;
}

// Fetch all attendance data for the month
$stmt = $this->db->prepare("
    SELECT
    p.profile_id AS user_id,
    p.sex,
    ar.date,
    ar.status
    FROM profiles p
    LEFT JOIN attendance_records ar ON p.profile_id = ar.user_id
    WHERE p.profile_id IN ($userIdsString) -- Filter for specific users
    AND DATE_FORMAT(ar.date, '%Y-%m') = :month -- Filter by the specified month
    ORDER BY ar.user_id, ar.date
    ");
$stmt->bindValue(':month', $month_id, PDO::PARAM_STR);
$stmt->execute();
$attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all weekdays in the month
$weekdays = getWeekdaysInMonth($month_id);

// Initialize the attendance data structure
$userAttendanceData = [];
foreach (explode(',', $userIdsString) as $userId) {
    $userAttendanceData[$userId] = [
        'user_id' => $userId,
        'sex' => null, // This will be populated from attendance records
        'attendance' => [
            'present' => [],
            'absent' => [],
        ],
    ];
}

// Process attendance records
foreach ($attendanceRecords as $record) {
    $userId = $record['user_id'];
    $date = $record['date'];
    $status = $record['status'];
    $sex = $record['sex'];

    // Skip if the user is not in the list
    if (!isset($userAttendanceData[$userId])) {
        continue;
    }

    // Set gender if not already set
    if (is_null($userAttendanceData[$userId]['sex'])) {
        $userAttendanceData[$userId]['sex'] = $sex;
    }

    // Record presence or absence
    if ($status === 'P') {
        $userAttendanceData[$userId]['attendance']['present'][] = $date;
    } elseif (in_array($status, ['A', 'E'])) {
        $userAttendanceData[$userId]['attendance']['absent'][] = $date;
    }
}

// Ensure all weekdays are accounted for (marking absent if no record exists)
foreach ($userAttendanceData as $userId => &$data) {
    foreach ($weekdays as $date) {
        if (!in_array($date, $data['attendance']['present']) && !in_array($date, $data['attendance']['absent'])) {
            $data['attendance']['absent'][] = $date;
        }
    }
}

// Count students with 5 consecutive absences
$totalMalesWith5ConsecutiveAbsences = 0;
$totalFemalesWith5ConsecutiveAbsences = 0;

foreach ($userAttendanceData as $data) {
    $absentDates = $data['attendance']['absent'];
    sort($absentDates); // Ensure dates are in chronological order
    $consecutiveCount = 0;

    foreach ($absentDates as $index => $date) {
        if ($index > 0 && (strtotime($date) - strtotime($absentDates[$index - 1]) === 86400)) {
            $consecutiveCount++;
            if ($consecutiveCount >= 4) { // Total 5 consecutive days including the current one
                if ($data['sex'] === 'M') {
                    $totalMalesWith5ConsecutiveAbsences++;
                } elseif ($data['sex'] === 'F') {
                    $totalFemalesWith5ConsecutiveAbsences++;
                }
                break;
            }
        } else {
            $consecutiveCount = 0; // Reset count if not consecutive
        }
    }
}


#


#echo '<pre>'.var_export($userAttendanceData, true).'</pre>';
} catch (Exception $e) {
   echo $e->getMessage();
   return; 
}
echo '
<table>
<thead>
<tr>
<th rowspan="2">Month of<br>'.DateTime::createFromFormat('Y-m', $month_id)->format('F Y').'</th>

<th rowspan="2">No. of Days of Classes</th>
<th colspan="3" class="summary">Summary</th>
</tr>
<tr>
<th>M</th>
<th>F</th>
<th>Total</th>
</tr>
</thead>
<tbody>
<!-- Enrolment as of (1st Friday of June) -->
<tr>
<td colspan="2" style="text-align: left;">Enrolment as of (1st Friday of June)</td>
<td>' . $enrollie1stofjuneM . '</td>
<td>' . $enrollie1stofjuneF . '</td> 
<td>' . $enrollie1stofjuneT. '</td> 
</tr>
<!-- Late Enrollment during the month (beyond cut-off) -->
<tr>
<td colspan="2" style="text-align: left;">Late Enrollment during the month (beyond cut-off)</td>
<td>' . $enrolliepassofjuneM . '</td>
<td>' . $enrolliepassofjuneF . '</td> 
<td>' . $enrolliepassofjuneT. '</td> 
</tr>
<!-- Registered Learners as of end of the month -->
<tr>
<td colspan="2" style="text-align: left;">Registered Learners as of end of the month</td>
<td>' . $totalMales . '</td>
<td>' . $totalFemales . '</td> 
<td>' . $total . '</td> 
</tr>
<!-- Percentage of Enrolment as of end of the month -->
<tr>
<td colspan="2" style="text-align: left;">Percentage of Enrolment as of end of the month</td>
<td>'.$poeM.'%</td>
<td>'.$poeF.'%</td>
<td>'.$poeT.'%</td>
</tr>
<!-- Average Daily Attendance -->
<tr>
<td colspan="2" style="text-align: left;">Average Daily Attendance</td>
<td>'.$adaM.'</td>
<td>'.$adaF.'</td> 
<td>'.$adaT.'</td> 
</tr>
<!-- Percentage of Attendance for the month -->
<tr>
<td colspan="2" style="text-align: left;">Percentage of Attendance for the month</td>
<td>'.$paM.'%</td>
<td>'.$paF.'%</td> 
<td>'.$paT.'%</td> 

</tr>
<!-- Number of students absent for 5 consecutive days -->
<tr>
<td colspan="2" style="text-align: left;">Number of students absent for 5 consecutive days</td>
<td>'.$totalMalesWith5ConsecutiveAbsences.'</td>
<td>'.$totalFemalesWith5ConsecutiveAbsences.'</td> 
<td>'.($totalFemalesWith5ConsecutiveAbsences + $totalMalesWith5ConsecutiveAbsences).'</td> 
</tr>
<!-- Drop out -->
<tr>
<td colspan="2" style="text-align: left;">Drop out</td>
<td></td>
<td></td> 
<td></td> 
</tr>
<!-- Transferred out -->
<tr>
<td colspan="2" style="text-align: left;">Transferred out</td>
<td></td>
<td></td> 
<td></td> 
</tr>
<!-- Transferred in -->
<tr>
<td colspan="2" style="text-align: left;">Transferred in</td>
<td></td>
<td></td> 
<td></td> 
</tr>
</tbody>
</table>';
}

public function getAvailableDate() {
    // Query the database to get all unique months and years in MM-YYYY format
    $stmt = $this->db->prepare("
        SELECT 
        DATE_FORMAT(date, '%Y-%m') AS month_id,
        CONCAT(MONTHNAME(date), ' ', YEAR(date)) AS date
        FROM attendance_records
        GROUP BY month_id
        ORDER BY date ASC
        ");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the result in JSON format
    echo json_encode($result);
}














public function show() {

 $adviserId = $_SESSION['user_id'];
 try {
    $result = $this->getAdviserSectionAndGrade($adviserId);
    $_SESSION['section_id'] = $result['section_id'];
    $stmt = $this->db->prepare("
        SELECT 
        s.id as section_id, 
        s.section_name, 
        s.daytime, 
        COALESCE(p.lrn, 'No Data') AS lrn, 
        CONCAT(
            COALESCE(p.last_name, ''), ', ',
            COALESCE(p.first_name, ''), ' ',
            COALESCE(
                CASE
                WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                ELSE ''
                END, 
                '') 
            ) AS fullname,
        p.profile_id, 
        p.sex
        FROM sections s
        LEFT JOIN enrollment_history eh ON eh.section_id = s.id
        LEFT JOIN profiles p ON eh.user_id = p.profile_id
        WHERE s.adviser_id = :adviser_id
        ");
    $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
    $stmt->execute();
    $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);



        // Query to get unenrolled students
    $stmt = $this->db->prepare("
        SELECT 
        COALESCE(p.lrn, 'No Data') AS lrn, 
        CONCAT(
            COALESCE(p.last_name, ''), ', ',
            COALESCE(p.first_name, ''), ' ',
            COALESCE(
                CASE
                WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                ELSE ''
                END, 
                '') 
            ) AS fullname,
        u.user_id, 
        p.sex as gender
        FROM users u
        LEFT JOIN profiles p ON u.user_id = p.profile_id
        LEFT JOIN enrollment_history eh ON eh.user_id = u.user_id AND eh.academic_year_id = :acads
        WHERE u.role_id = 3 AND eh.user_id IS NULL
        ");
    $stmt->bindValue(':acads', $this->acadsyear, PDO::PARAM_INT);
    $stmt->execute();
    $unenrolledStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);




} catch (Exception $e) {
    echo $e->getMessage();
    return;
}
include 'views/adviser/advisoryClass.php';
}
public function enroll() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['students']) && isset($_SESSION['section_id'])) {
            $studentIds = $_POST['students']; 
            $sectionId = (int) $_SESSION['section_id']; 
            // Fetch section data to ensure the adviser is correct
            $stmt = $this->db->prepare("SELECT adviser_id FROM sections WHERE id = :section_id");
            $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
            $stmt->execute();
            $sectionData = $stmt->fetch(PDO::FETCH_ASSOC);
            // Fetch campus information (assuming this holds academic year info)
            $stmt = $this->db->prepare("SELECT * FROM campus_info WHERE id = 6");
            $stmt->execute();
            $CampusInfoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $present_school_year = (int) $CampusInfoData[0]['function'];
            // Fetch grade level for the section
            $stmt = $this->db->prepare("SELECT id, level FROM grade_level WHERE FIND_IN_SET(:section_id, section_ids)");
            $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
            $stmt->execute();
            $gradeLevelData = $stmt->fetch(PDO::FETCH_ASSOC);
            $gradeLevelId = $gradeLevelData['id'];
            // Ensure the adviser is allowed to enroll students in the selected section
            if ($sectionData && $sectionData['adviser_id'] == $_SESSION['user_id']) {
                // Loop through all selected students to check if they are already enrolled
                foreach ($studentIds as $studentId) {
                    // Check if the student is already enrolled for this section and academic year
                    $checkEnrollmentStmt = $this->db->prepare("
                        SELECT COUNT(*) 
                        FROM enrollment_history 
                        WHERE user_id = :student_id 
                        AND grade_level_id = :grade_level_id 
                        AND section_id = :section_id 
                        AND academic_year_id = :academic_year_id
                        ");
                    $checkEnrollmentStmt->bindValue(':student_id', (int) $studentId, PDO::PARAM_INT);
                    $checkEnrollmentStmt->bindValue(':grade_level_id', $gradeLevelId, PDO::PARAM_INT);
                    $checkEnrollmentStmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
                    $checkEnrollmentStmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
                    $checkEnrollmentStmt->execute();
                    $enrollmentExists = $checkEnrollmentStmt->fetchColumn();
                    if ($enrollmentExists > 0) {
                        // If the student is already enrolled, skip this student
                        echo "Student with ID $studentId is already enrolled in this section for the current academic year. Skipping enrollment.";
                        continue;
                    }
                    // If the student is not enrolled, proceed with enrollment
                    $stmt = $this->db->prepare("
                        INSERT INTO enrollment_history (user_id, grade_level_id, section_id, adviser_id, academic_year_id, enrollment_date)
                        VALUES (:student_id, :grade_level_id, :section_id, :adviser_id, :academic_year_id, :enrollment_date)
                        ");
                    $stmt->bindValue(':student_id', (int) $studentId, PDO::PARAM_INT);
                    $stmt->bindValue(':grade_level_id', $gradeLevelId, PDO::PARAM_INT);
                    $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
                    $stmt->bindValue(':adviser_id', $_SESSION['user_id'], PDO::PARAM_INT);
                    $stmt->bindValue(':academic_year_id', $present_school_year, PDO::PARAM_INT);
                    $stmt->bindValue(':enrollment_date', date('Y-m-d'), PDO::PARAM_STR);
                    $stmt->execute();
                }
                // Redirect to advisers page after enrollment
                header("Location: /BlissES/myclass-list");
                exit();
            } else {
                echo "Error: You do not have permission to enroll students in this section.";
            }
        } else {
            echo "Error: No students selected or invalid section.";
        }
    }
}
public function update() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id']) && isset($_POST['section_id'])) {
        $studentId = (int) $_POST['student_id'];
        $sectionId = (int) $_POST['section_id'];
        $stmt = $this->db->prepare("
            UPDATE enrollment_history 
            SET section_id = :section_id 
            WHERE user_id = :student_id
            ");
        $stmt->bindValue(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: /BlissES/advisers");
            exit();
        } else {
            echo "Error: Could not update enrollment.";
        }
    }
}
public function unenroll() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
        // Fetch campus information (assuming id = 6 is specific to present school year)
        $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 6");
        $stmt->execute();
        $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
        // Ensure valid data was retrieved
        if (!$campusInfoData) {
            echo "Error: Unable to fetch campus information.";
            return;
        }
        // Extract present school year
        $presentSchoolYear = (int) $campusInfoData['function'];
        // Get current section ID and adviser ID from the session
        $sectionId = isset($_SESSION['section_id']) ? (int) $_SESSION['section_id'] : 0;
        $adviserId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 0;
        // Validate section ID and adviser ID
        if ($sectionId === 0 || $adviserId === 0) {
            echo "Error: Missing section or adviser information.";
            return;
        }
        // Fetch grade level based on section ID
        $stmt = $this->db->prepare("SELECT id, level FROM grade_level WHERE FIND_IN_SET(:section_id, section_ids)");
        $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
        $stmt->execute();
        $gradeLevelData = $stmt->fetch(PDO::FETCH_ASSOC);
        // Ensure valid grade level data was retrieved
        if (!$gradeLevelData) {
            echo "Error: Unable to fetch grade level data.";
            return;
        }
        $gradeLevelId = (int) $gradeLevelData['id'];
        // Unenroll the student by deleting their enrollment history
        $studentId = (int) $_POST['student_id'];
        $stmt = $this->db->prepare("
            DELETE FROM enrollment_history 
            WHERE user_id = :student_id 
            AND section_id = :section_id 
            AND grade_level_id = :grade_level_id 
            AND academic_year_id = :present_school_year
            AND adviser_id = :adviser_id
            ");
        $stmt->bindValue(':student_id', $studentId, PDO::PARAM_INT);
        $stmt->bindValue(':section_id', $sectionId, PDO::PARAM_INT);
        $stmt->bindValue(':grade_level_id', $gradeLevelId, PDO::PARAM_INT);
        $stmt->bindValue(':present_school_year', $presentSchoolYear, PDO::PARAM_INT);
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            header("Location: /BlissES/myclass-list");
            exit();
        } else {
           echo "Error: Unable to unenroll the student.";
       }
   } else {
    echo "Invalid request.";
}
}
public function showschoolform1() {
    // Get the adviser's user_id
    $adviserId = $_SESSION['user_id'];
    try {
        $result = $this->getAdviserSectionAndGrade($adviserId);
        $_SESSION['section_id'] = $result['section_id'];
    // Fetch the advisory class information
        $stmt = $this->db->prepare("
            SELECT 
            p.lrn,
            CONCAT(p.last_name, ', ', p.first_name, ' ', COALESCE(p.middle_name, '')) AS full_name,
            p.sex,
            DATE_FORMAT(p.birth_date, '%m/%d/%Y') AS birth_date,
            TIMESTAMPDIFF(YEAR, p.birth_date, '2024-10-31') - 
            (DATE_FORMAT(p.birth_date, '%m-%d') > '10-31') AS age,
            COALESCE(p.mother_tongue, 'Not Specified') AS mother_tongue,
            COALESCE(p.ip_ethnic_group, 'Not Specified') AS ethnic_group,
            COALESCE(p.religion, 'Not Specified') AS religion,
            COALESCE(p.fathers_name, 'Not Specified') AS fathers_name,
            COALESCE(p.mother_name, 'Not Specified') AS mother_name,
            COALESCE(p.guardian_name, 'Not Specified') AS guardian_name,
            COALESCE(p.contact_number, 'Not Specified') AS contact_number,
            COALESCE(p.house_street_sitio_purok, 'Not Specified') AS house_street_sitio_purok,
            COALESCE(p.barangay, 'Not Specified') AS barangay,
            COALESCE(p.municipality_city, 'Not Specified') AS municipality_city,
            COALESCE(p.province, 'Not Specified') AS province,
            COALESCE(p.relationship, 'Not Specified') AS relationship
            FROM 
            sections s
            LEFT JOIN 
            enrollment_history eh ON eh.section_id = s.id
            LEFT JOIN 
            profiles p ON eh.user_id = p.profile_id
            WHERE 
            s.adviser_id = :adviser_id;
            ");
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();
        $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo $e->getMessage();
        return;
    }
    // Include the view and pass the data
    include 'views/adviser/schoolform1.php';
}
public function showAttendance(){
    $adviserId = $_SESSION['user_id'];
    // Get today's date for comparison
    date_default_timezone_set('Asia/Manila');
    $todayDate = date('Y-m-d');
    $sectionCheckStmt = $this->db->prepare("
        SELECT id FROM sections WHERE adviser_id = :adviser_id
        ");
    $sectionCheckStmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
    $sectionCheckStmt->execute();
    $assignedSection = $sectionCheckStmt->fetch(PDO::FETCH_ASSOC);
    // If no section is assigned, show an error
    if (!$assignedSection) {
        echo "Error: You are not assigned to a section. Please contact the admin.";
        return;
    }
    // Query to fetch students from the sections the adviser is assigned to
    $stmt = $this->db->prepare(" 
        SELECT 
        eh.id as ehID,
        p.profile_id,
        COALESCE(p.lrn, 'No Data') AS lrn, 
        CONCAT(
            COALESCE(p.last_name, ''), ', ', 
            COALESCE(p.first_name, ''), ' ',
            COALESCE(
                CASE 
                WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                ELSE '' 
                END, '') 
            ) AS fullname
        FROM sections s
        LEFT JOIN enrollment_history eh ON eh.section_id = s.id
        LEFT JOIN profiles p ON eh.user_id = p.profile_id
        WHERE s.adviser_id = :adviser_id
        Order by p.sex ASC, p.last_name ASC;

        ");
    $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
    $stmt->execute();
    $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);




    // Initialize an array to hold attendance data for the view
    $attendanceData = [];
    // Now check the attendance and remarks for each student for today's date
    foreach ($advisoryClass as $student) {
        $profileId = $student['profile_id'];
        // Check if attendance record exists for the student for today
        $attendanceStmt = $this->db->prepare(" 
            SELECT id, status, remarks FROM attendance_records 
            WHERE user_id = :profile_id AND date = :today_date
            ");
        $attendanceStmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
        $attendanceStmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
        $attendanceStmt->execute();
        // If attendance record exists, store the attendance data
        if ($attendanceStmt->rowCount() > 0) {
            $attendanceRecord = $attendanceStmt->fetch(PDO::FETCH_ASSOC);
            $student['attendanceChecked'] = true;
            $student['status'] = $attendanceRecord['status']; // Store the status for later use in the view
            $student['remarks'] = $attendanceRecord['remarks']; // Store the remarks for later use in the view
        } else {
            $student['attendanceChecked'] = false;
            $student['status'] = null; // No attendance record yet
            $student['remarks'] = ''; // No remarks yet
        }
        // Add the updated student data to the attendanceData array
        $attendanceData[] = $student;
    }
    // Pass the data to the view
    include 'views/adviser/schoolform2.php';
}
public function submitAttendance() {
    // Get the data from the AJAX request
    $profileId = $_POST['profile_id'];
    $status = $_POST['status'];
    $eID = $_POST['eid'];
    // Get today's date for comparison
    date_default_timezone_set('Asia/Manila');
    $todayDate = date('Y-m-d');
    // Check if the attendance record already exists for the current user and today's date
    $stmt = $this->db->prepare("
        SELECT id FROM attendance_records 
        WHERE user_id = :profile_id AND date = :today_date AND eh_id = :eid
        ");
    $stmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
    $stmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
    $stmt->bindValue(':eid', $eID, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        // Record exists, so update it
        $stmt = $this->db->prepare("
            UPDATE attendance_records
            SET status = :status, eh_id = :eid, date = NOW()
            WHERE user_id = :profile_id AND date = :today_date
            ");
        // Bind parameters for update
        $stmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
        $stmt->bindValue(':eid', $eID, PDO::PARAM_INT);
    } else {
        // Record does not exist, insert a new record
        $stmt = $this->db->prepare("
            INSERT INTO attendance_records (user_id, status, date, eh_id)
            VALUES (:profile_id, :status, NOW(), :eid)
            ");
        // Bind parameters for insert
        $stmt->bindValue(':profile_id', $profileId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':eid', $eID, PDO::PARAM_INT);
    }
    $stmt->execute();
    // Send response back (optional)
    echo json_encode(['success' => true]);
}
public function updateRemark() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $profileId = $_POST['profile_id'];
        $remarks = $_POST['remarks'];
        $ehId = $_POST['eid'];
            // Get today's date for comparison
        date_default_timezone_set('Asia/Manila');
        $todayDate = date('Y-m-d');
        // Prepare the query to update the remarks
        $stmt = $this->db->prepare("
            UPDATE attendance_records
            SET remarks = :remarks 
            WHERE user_id = :profile_id AND date = :today_date AND eh_id = :eid
            ");
        $stmt->bindParam(':remarks', $remarks, PDO::PARAM_STR);
        $stmt->bindValue(':today_date', $todayDate, PDO::PARAM_STR);
        $stmt->bindParam(':profile_id', $profileId, PDO::PARAM_INT);
        $stmt->bindParam(':eid', $ehId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo 'Remark updated successfully';
        } else {
            echo 'Error updating remark';
        }
    }
}
public function showClassRecord() {
    $adviserId = $_SESSION['user_id'];
    try {
        // Get section and grade level info
        $result = $this->getAdviserSectionAndGrade($adviserId);
        $_SESSION['section_id'] = $result['section_id'];



        $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 8");
        $stmt->execute();
        $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentGrading = (int)$campusInfoData['function'];


        // Fetch advisory class information
        $stmt = $this->db->prepare("
            SELECT 
            s.id AS section_id, 
            s.section_name, 
            s.daytime, 
            COALESCE(p.lrn, 'No Data') AS lrn, 
            CONCAT(
                COALESCE(p.last_name, ''), ', ',
                COALESCE(p.first_name, ''), ' ',
                COALESCE(
                    CASE
                    WHEN p.middle_name IS NOT NULL AND p.middle_name != '' 
                    THEN CONCAT(SUBSTRING(p.middle_name, 1, 1), '.')
                    ELSE ''
                    END, 
                    '') 
                ) AS fullname,
            p.profile_id, 
            p.sex,
            eh.id AS eh_id 
            FROM 
            sections s
            LEFT JOIN 
            enrollment_history eh ON eh.section_id = s.id
            LEFT JOIN 
            profiles p ON eh.user_id = p.profile_id
            WHERE 
            s.adviser_id = :adviser_id
            Order by p.last_name ASC
            ");
        $stmt->bindValue(':adviser_id', $adviserId, PDO::PARAM_INT);
        $stmt->execute();
        $advisoryClass = $stmt->fetchAll(PDO::FETCH_ASSOC);



        // Fetch all subjects in the grade level
        $stmt = $this->db->prepare("
            SELECT 
            s.id AS subject_id,
            s.name AS subject_name
            FROM 
            subjects s
            WHERE 
            FIND_IN_SET(s.id, (
                SELECT 
                gl.subject_ids
                FROM 
                grade_level gl
                WHERE 
                gl.id = :grade_level
                )) > 0
            ");
        $stmt->bindValue(':grade_level', $result['grade_level_id'], PDO::PARAM_INT);
        $stmt->execute();
        $allSubjectInGrade = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Sanitize and check if arrays are empty before querying grades
        $studentIds = array_column($advisoryClass, 'profile_id');
        $subjectIds = array_column($allSubjectInGrade, 'subject_id');
        
        if (empty($studentIds) || empty($subjectIds)) {
            throw new Exception('No students or subjects found');
        }

// Fetch grades for students
        $gradesStmt = $this->db->prepare("
            SELECT 
            gr.user_id, 
            gr.subject_id, 
            gr.grade 
            FROM 
            grade_records gr
            WHERE 
            gr.user_id IN (" . implode(',', array_map('intval', $studentIds)) . ")
            AND gr.subject_id IN (" . implode(',', array_map('intval', $subjectIds)) . ")
            AND gr.grading_id = :grading_id
            ");
        $gradesStmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT); 
        $gradesStmt->execute();
        $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);






        // Transform grades into an associative array for easier lookup
        $gradeMap = [];
        foreach ($grades as $grade) {
            $gradeMap[$grade['user_id']][$grade['subject_id']] = $grade['grade'];
        }

    } catch (Exception $e) {
        echo $e->getMessage();
        return;
    }




    // Include the view for the class record
    include 'views/adviser/class-record.php';
}



public function addOrUpdateClassRecord() {

    $stmt = $this->db->prepare("SELECT function FROM campus_info WHERE id = 8");
    $stmt->execute();
    $campusInfoData = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentGrading = (int)$campusInfoData['function'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate the input data
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : null;
        $subjectId = isset($_POST['subject_id']) ? (int)$_POST['subject_id'] : null;
        $grade = isset($_POST['grade']) ? $_POST['grade'] : null;
        $ehId = isset($_POST['eh_id']) ? (int)$_POST['eh_id'] : null;

        if ($userId && $subjectId && $grade !== null && $ehId) {
            try {

                // Check if the record exists
                $stmt = $this->db->prepare("SELECT id FROM grade_records WHERE user_id = :user_id AND eh_id = :eh_id AND subject_id = :subject_id AND grading_id = :grading_id");
                $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
                $stmt->bindValue(':eh_id', $ehId, PDO::PARAM_INT);
                $stmt->bindValue(':subject_id', $subjectId, PDO::PARAM_INT);
                $stmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT);
                $stmt->execute();
                $existingGrade = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingGrade) {
                    // Update the existing record
                    $updateStmt = $this->db->prepare("UPDATE grade_records SET grade = :grade WHERE id = :id");
                    $updateStmt->bindValue(':grade', $grade, PDO::PARAM_STR);
                    $updateStmt->bindValue(':id', $existingGrade['id'], PDO::PARAM_INT);
                    $updateStmt->execute();
                } else {
                    // Insert a new grade record
                    $insertStmt = $this->db->prepare("INSERT INTO grade_records (user_id, eh_id, subject_id, grade, grading_id) VALUES (:user_id, :eh_id, :subject_id, :grade, :grading_id)");
                    $insertStmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
                    $insertStmt->bindValue(':eh_id', $ehId, PDO::PARAM_INT);
                    $insertStmt->bindValue(':subject_id', $subjectId, PDO::PARAM_INT);
                    $insertStmt->bindValue(':grade', $grade, PDO::PARAM_STR);
                    $insertStmt->bindValue(':grading_id', $currentGrading, PDO::PARAM_INT);
                    $insertStmt->execute();
                }

                // Return a success response
                echo 'Grade updated successfully';
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }
        } else {
            echo 'Invalid data received';
        }
    }
}





}