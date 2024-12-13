<?php
ob_start();
$pageTitle = 'Dashboard'; 
?>
<div class="row">
  <!-- Left Column -->
  <section class="col-lg-5 connectedSortable">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          List of my Children
        </h3>
      </div>
      <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th style="text-align: center;">#</th>
              <th style="text-align: center;">Name</th>
            </tr>
          </thead>
          <tbody>
           <?php if(isset($childrens)): ?>
            <?php $index = 1; ?>
            <?php foreach ($childrens as $data): ?>
              <tr>
               <td style="text-align: center;"><?php echo $index++; ?></td> 
               <td style="text-align: left;">
                 <a href="#" onclick="summary('<?php echo $data['id']; ?>')">
                   <?php echo $data['fullname']; ?>
                 </a>
               </td>
             </tr>
           <?php endforeach; ?>
         <?php endif; ?>
       </tbody>
     </table>
   </div>
 </div>
</section>

<!-- Right Column -->
<section class="col-lg-7 connectedSortable">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">
        Report
      </h3>
    </div>
    <div class="card-body">
      <!-- Direct Chat Section -->
      <div class="card card-default card-tabs">
        <div class="card-header p-0 pt-1">
          <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Attendance</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Grade</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-one-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">

             <table id="example3" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th style="text-align: center;">#</th>
                  <th style="text-align: center;">Date</th>
                  <th style="text-align: center;">Status</th>
                </tr>
              </thead>
              <tbody>
                <!-- Attendance data will be populated here via AJAX -->
              </tbody>
            </table>
          </div>

          <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">





<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;" id="gradesTable">
  <thead>
    <tr>
      <th rowspan="2" style="text-align: center;">Subject</th>
      <th colspan="4" style="text-align: center;">Grades</th>
      <th rowspan="2" style="text-align: center;">Average</th>
    </tr>
    <tr>
      <th style="text-align: center;">1st Grading</th>
      <th style="text-align: center;">2nd Grading</th>
      <th style="text-align: center;">3rd Grading</th>
      <th style="text-align: center;">4th Grading</th>
    </tr>
  </thead>
  <tbody id="gradesTableBody">
    <!-- Data will be inserted here by JavaScript -->
  </tbody>
  <tfoot>
    <tr>
      <td colspan="5" style="text-align: right;"><strong>Overall Average</strong></td>
      <td style="text-align: center;" id="overallAverage">
        <!-- Overall Average will be calculated and inserted here -->
      </td>
    </tr>
  </tfoot>
</table>

<script type="text/javascript">
  // Function to generate the grades table dynamically
  function renderGradesTable() {
    var totalGrades = 0;
    var completedSubjects = 0;
    var tableBody = document.getElementById("gradesTableBody");
    var overallAverageElement = document.getElementById("overallAverage");

    // Clear the previous table rows
    tableBody.innerHTML = '';

    allSubjectInGrade.forEach(function(subject) {
      // Ensure that if no grade is found, it shows 'No Grade' instead
      var grades = {
        '1st Grading': (gradeMap[subject.subject_id] && gradeMap[subject.subject_id][1]) ? gradeMap[subject.subject_id][1] : 'No Grade',
        '2nd Grading': (gradeMap[subject.subject_id] && gradeMap[subject.subject_id][2]) ? gradeMap[subject.subject_id][2] : 'No Grade',
        '3rd Grading': (gradeMap[subject.subject_id] && gradeMap[subject.subject_id][3]) ? gradeMap[subject.subject_id][3] : 'No Grade',
        '4th Grading': (gradeMap[subject.subject_id] && gradeMap[subject.subject_id][4]) ? gradeMap[subject.subject_id][4] : 'No Grade'
      };

      // Filter out non-numeric grades and retain 'No Grade' as a string
      var numericGrades = Object.values(grades).filter(function(grade) {
        return !isNaN(grade) && grade !== 'No Grade';
      });

      // Calculate the average only if there are numeric grades
      var averageGrade = numericGrades.length > 0 ? numericGrades.reduce(function(a, b) { return a + b; }, 0) / numericGrades.length : 'Incomplete';

      // Create the table row for this subject
      var row = document.createElement("tr");

      row.innerHTML = `
        <td style="text-align: center;">${subject.subject_name}</td>
        <td style="text-align: center;">${grades['1st Grading']}</td>
        <td style="text-align: center;">${grades['2nd Grading']}</td>
        <td style="text-align: center;">${grades['3rd Grading']}</td>
        <td style="text-align: center;">${grades['4th Grading']}</td>
        <td style="text-align: center;">${isNaN(averageGrade) ? averageGrade : averageGrade.toFixed(2)}</td>
      `;

      // Append the row to the table body
      tableBody.appendChild(row);

      // If the average grade is numeric, add it to the total grades
      if (!isNaN(averageGrade)) {
        totalGrades += averageGrade;
        completedSubjects++;
      }
    });

    // Calculate and display the overall average
    if (completedSubjects > 0) {
      var overallAverage = totalGrades / completedSubjects;
      overallAverageElement.textContent = overallAverage.toFixed(2);
    } else {
      overallAverageElement.textContent = 'Incomplete Grades';
    }
  }

  // Render the grades table on page load
  renderGradesTable();
</script>















</div>
</div>












</div>
</div>
</div>
</div>
</section>
</div>










<script type="text/javascript">
  var allSubjectInGrade = <?php echo json_encode($allSubjectInGrade); ?>;
  var gradeMap = <?php echo json_encode($gradeMap); ?>;
</script>

<script type="text/javascript">
function summary(childId) {
    $.ajax({
        url: 'attendance-grade',  // Endpoint to fetch attendance and grades
        method: 'POST',
        data: { child_id: childId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                var attendanceData = response.attendance_records;
                var gradeMap = response.grades;  // Grades data
                var allSubjects = response.subjects; // Subjects data

                var attendanceTableBody = $('#example3 tbody');
                attendanceTableBody.empty();  // Clear the existing table rows

                // Map status codes to their full descriptions
                var statusMap = {
                    'P': 'Present',
                    'A': 'Absent',
                    'E': 'Excused',
                    'T': 'Tardy'
                };

                // Populate attendance data
                attendanceData.forEach(function(record, index) {
                    var status = statusMap[record.status] || 'Unknown';  // Default to 'Unknown' if status code is not recognized
                    attendanceTableBody.append(`
                        <tr>
                            <td style="text-align: center;">${index + 1}</td>
                            <td style="text-align: center;">${record.date}</td>
                            <td style="text-align: center;">${status}</td>
                        </tr>
                    `);
                });

                // For grades
                var gradeTableBody = $('#gradesTable tbody'); // Assuming you have another table for grades
                gradeTableBody.empty();

                // Loop through the subjects and grades
                allSubjects.forEach(function(subject) {
                    var subjectName = subject.subject_name;
                    var gradesRow = `<tr>
                        <td>${subjectName}</td>
                        <td style="text-align: center;">${gradeMap[subject.subject_id][1] || 'No Grade'}</td>
                        <td style="text-align: center;">${gradeMap[subject.subject_id][2] || 'No Grade'}</td>
                        <td style="text-align: center;">${gradeMap[subject.subject_id][3] || 'No Grade'}</td>
                        <td style="text-align: center;">${gradeMap[subject.subject_id][4] || 'No Grade'}</td>
                    </tr>`;
                    gradeTableBody.append(gradesRow);
                });

            } else {
                alert('Failed to load data.');
            }
        },
        error: function() {
            alert('No Data yet');
        }
    });
}


  // Initialize DataTable
  $('#example3').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": true,
    "info": true,
    "autoWidth": false,
    "responsive": true,
  });
</script>

<?php
$content = ob_get_clean();
include 'views/master-top.php';
?>