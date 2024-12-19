<?php 
// Get the current page from the URL
$current_page = basename($_SERVER['REQUEST_URI'], ".php");
?>

<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

    <!-- Dashboard Item -->
    <li class="nav-item">
      <a href="dashboard" class="nav-link <?= ($current_page == 'dashboard') ? 'active' : ''; ?>">
        <img class="icon-white" src="assets/img/icons/dashboard.png" alt="Custom Icon" >
        <p>Dashboard</p>
      </a>
    </li>





    <?php if ($_SESSION['role_id'] === 2): ?>

      <li class="nav-header">Advisory Class</li>
      <li class="nav-item">
        <a href="myclass-list" class="nav-link <?= ($current_page == 'myclass-list') ? 'active' : ''; ?>">
          <img class="icon-white" src="assets/img/icons/students.png" alt="Custom Icon" >
          <p>Enrolled Student</p>
        </a>
      </li>

      <li class="nav-item">
        <a href="class-record" class="nav-link <?= ($current_page == 'class-record') ? 'active' : ''; ?>">
          <img class="icon-white" src="assets/img/icons/marking.png" alt="Custom Icon" >
          <p>Class Record</p>
        </a>
      </li>

      <li class="nav-item <?= ($current_page == 'schoolform1' || $current_page == 'schoolform2') ? 'menu-is-opening menu-open' : ''; ?>">
        <a href="#" class="nav-link <?= ($current_page == 'schoolform1' || $current_page == 'schoolform2') ? 'active' : ''; ?>">
          <img class="icon-white" src="assets/img/icons/google-forms.png" alt="Custom Icon" >
          <p>
            School Form
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="schoolform1" class="nav-link <?= ($current_page == 'schoolform1') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>SF1</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="schoolform2" class="nav-link <?= ($current_page == 'schoolform2') ? 'active' : ''; ?>">
              <i class="far fa-circle nav-icon"></i>
              <p>SF2</p>
            </a>
          </li>
        </ul>
      </li>











      <li class="nav-item ">
        <a href="#" class="nav-link ">
          <img class="icon-white" src="assets/img/icons/report.png" alt="Custom Icon" >
          <p>
            Generate Report
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="#" class="nav-link" onclick="generateStudentList()">
              <i class="far fa-circle nav-icon"></i>
              <p>Student List</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>
               SF 2 Report
               <i class="right fas fa-angle-left"></i>
             </p>
           </a>
           <ul class="nav nav-treeview reportdate">
            <li class="nav-item">
              <a href="#" class="nav-link" onclick="generateSF2R()" data-id="dynamic-item"> <!-- Add a custom data-id to easily target this link -->
                <i class="far fa-dot-circle nav-icon"></i>
                <p>Loading...</p> <!-- Default text while waiting for the AJAX call -->
              </a>
            </li>
          </ul>

        </li>


      <li class="nav-item">
            <a href="#" class="nav-link" onclick="generateGradeRecord()">
              <i class="far fa-circle nav-icon"></i>
              <p>Grade Report</p>
            </a>
          </li>





  </ul>
</li>

<?php endif; ?>


<?php if ($_SESSION['role_id'] === 4): ?>
  <li class="nav-header">Registrar</li>
  <li class="nav-item">
    <a href="teacher-list" class="nav-link <?= ($current_page == 'teacher-list') ? 'active' : ''; ?>">
      <img class="icon-white" src="assets/img/icons/training.png" alt="Custom Icon" >
      <p>Employee's</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="students-list" class="nav-link <?= ($current_page == 'students-list') ? 'active' : ''; ?>">
      <img class="icon-white" src="assets/img/icons/student.png" alt="Custom Icon" >
      <p>Learner's</p>
    </a>
  </li>
  <li class="nav-item">
    <a href="parents-list" class="nav-link <?= ($current_page == 'parents-list') ? 'active' : ''; ?>">
      <img class="icon-white" src="assets/img/icons/family.png" alt="Custom Icon" >
      <p>Parents's</p>
    </a>
  </li>



<?php endif; ?>

<!-- Check if the user is an admin -->
<?php if ($_SESSION['role_id'] === 1): ?>

  <li class="nav-header">School Setting</li>
  <li class="nav-item <?= ($current_page == 'campus-profile' || $current_page == 'campus-grades' || $current_page == 'campus-sections' || $current_page == 'campus-subjects') ? 'menu-is-opening menu-open' : ''; ?>">
    <a href="#" class="nav-link <?= ($current_page == 'campus-profile' || $current_page == 'campus-grades' || $current_page == 'campus-sections' || $current_page == 'campus-subjects') ? 'active' : ''; ?>">
      <img class="icon-white" src="assets/img/icons/campus.png" alt="Custom Icon" >
      <p>
        Campus
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="campus-profile" class="nav-link <?= ($current_page == 'campus-profile') ? 'active' : ''; ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Profile</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="campus-grades" class="nav-link <?= ($current_page == 'campus-grades') ? 'active' : ''; ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Grade</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="campus-sections" class="nav-link <?= ($current_page == 'campus-sections') ? 'active' : ''; ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Section</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="campus-subjects" class="nav-link <?= ($current_page == 'campus-subjects') ? 'active' : ''; ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Subject</p>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-header">Administrative Setting</li>
  <li class="nav-item <?= ($current_page == 'roles' || $current_page == 'permissions' || $current_page == 'accounts') ? 'menu-is-opening menu-open' : ''; ?>">
    <a href="#" class="nav-link <?= ($current_page == 'roles' || $current_page == 'permissions' || $current_page == 'accounts') ? 'active' : ''; ?>">
      <img class="icon-white" src="assets/img/icons/gears.png" alt="Custom Icon" >
      <p>
        Developer
        <i class="fas fa-angle-left right"></i>
      </p>
    </a>
    <ul class="nav nav-treeview">
      <li class="nav-item">
        <a href="roles" class="nav-link <?= ($current_page == 'roles') ? 'active' : ''; ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Roles</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="permissions" class="nav-link <?= ($current_page == 'permissions') ? 'active' : ''; ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Permissions</p>
        </a>
      </li>
      <li class="nav-item">
        <a href="accounts" class="nav-link <?= ($current_page == 'accounts') ? 'active' : ''; ?>">
          <i class="far fa-circle nav-icon"></i>
          <p>Accounts</p>
        </a>
      </li>
    </ul>
  </li>
<?php endif; ?>

</ul>
</nav>
<!-- /.sidebar-menu -->




<script>
  function generateSF2R(month) {
    $.ajax({
      url: 'generateSF2Report', 
      method: 'GET',
      data: { month_id: month },
      success: function(response) {
        var printWindow = window.open('', '', 'height=1248,width=816');
        
        // Writing the full HTML structure
        printWindow.document.write(`
          <!DOCTYPE html>
          <html lang="en">
          <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>School Form 2</title>
          <style>
              /* Global Styles */
          body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
          }

          .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
          }

          .header .logo {
            width: 72px;
            height: auto;
            background-color: transparent;
          }

          .header .text {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            flex-grow: 1;
          }

          .header .left-logo {
            margin-right: auto;
          }

          .header .right-logo {
            margin-left: auto;
          }

          .horizontal-line {
            width: 100%;
            height: 1px;
            background-color: #000;
            margin-top: 10px;
          }

              /* Table Styles */
          table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #fff;
          }

          th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
          }

          th {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
          }

          tr:nth-child(even) {
            background-color: #f9f9f9;
          }

          tr:hover {
            background-color: #f1f1f1;
          }

          .student-name {
            text-align: left;
            padding-left: 10px;
            font-weight: bold;
          }

          .summary {
            text-align: center;
          }
          h2 {
            text-align: center;
            font-family: Arial, sans-serif;
          }
          </style>
          </head>
          <body>
          <div class="header">
          <img src="assets/deped_logo.png" alt="Logo 1" class="logo left-logo">
          <div class="text">
          Republic of the Philippines<br>
          Department of Education<br>
          Region XIII CARAGA<br>
          BLISS ELEMENTARY SCHOOL<br>
          SY: 2024-2025
          </div>
          <img src="assets/logo1.png" alt="Logo 2" class="logo right-logo">
          </div>

          <h2>School Attendance Report</h2>
          `);

        // Injecting the response content (the generated report)
        printWindow.document.write(response);
        
        // Horizontal line after content
        printWindow.document.write(`
          <div class="horizontal-line"></div>
          `);
        
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
      },
      error: function() {
        alert('Error fetching SF2 report details');
      }
    });
  }
</script>

()
<script type="text/javascript">
 function generateStudentList() {
  $.ajax({
    url: 'generateStudentList', 
    method: 'GET',
    data: {},
    success: function(response) {
      var printWindow = window.open('', '', 'height=1248,width=816');

        // Writing the full HTML structure
      printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student List</title>
        <style>
              /* Global Styles */
        body {
          font-family: Arial, sans-serif;
          background-color: #f4f4f9;
          margin: 0;
          padding: 20px;
        }

        .header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 10px 20px;
          border-bottom: 2px solid #000;
          margin-bottom: 20px;
        }

        .header .logo {
          width: 72px;
          height: auto;
          background-color: transparent;
        }

        h2 {
          text-align: center;
          font-family: Arial, sans-serif;
        }

        .header .text {
          text-align: center;
          font-size: 16px;
          font-weight: bold;
          flex-grow: 1;
        }

        .header .left-logo {
          margin-right: auto;
        }

        .header .right-logo {
          margin-left: auto;
        }

        .horizontal-line {
          width: 100%;
          height: 1px;
          background-color: #000;
          margin-top: 10px;
        }

              /* Table Styles */
        table {
          width: 100%;
          border-collapse: collapse;
          margin: 20px 0;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          background: #fff;
        }

        th, td {
          border: 1px solid #ddd;
          padding: 8px;
          text-align: center;
        }

        th {
          background-color: #007BFF;
          color: white;
          font-weight: bold;
        }

        tr:nth-child(even) {
          background-color: #f9f9f9;
        }

        tr:hover {
          background-color: #f1f1f1;
        }

        .student-name {
          text-align: left;
          padding-left: 10px;
          font-weight: bold;
        }

        .summary {
          text-align: center;
        }
        </style>
        </head>
        <body>
        <div class="header">
        <img src="assets/deped_logo.png" alt="Logo 1" class="logo left-logo">
        <div class="text">
        Republic of the Philippines<br>
        Department of Education<br>
        Region XIII CARAGA<br>
        BLISS ELEMENTARY SCHOOL<br>
        SY: 2024-2025
        </div>
        <img src="assets/logo1.png" alt="Logo 2" class="logo right-logo">
        </div>

        <h2>Student List</h2>
        `);

        // Injecting the response content (the generated report)
      printWindow.document.write(response);

        // Horizontal line after content
      printWindow.document.write(`
        <div class="horizontal-line"></div>
        `);

      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    },
    error: function() {
      alert('Error fetching SF2 report details');
    }
  });
}




</script>




<script type="text/javascript">
 function generateGradeRecord() {
  $.ajax({
    url: 'generateGradeRecord', 
    method: 'GET',
    data: {},
    success: function(response) {
      var printWindow = window.open('', '', 'height=1248,width=816');

        // Writing the full HTML structure
      printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Grades</title>
        <style>
              /* Global Styles */
        body {
          font-family: Arial, sans-serif;
          background-color: #f4f4f9;
          margin: 0;
          padding: 20px;
        }

        .header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          padding: 10px 20px;
          border-bottom: 2px solid #000;
          margin-bottom: 20px;
        }

        .header .logo {
          width: 72px;
          height: auto;
          background-color: transparent;
        }

        h2 {
          text-align: center;
          font-family: Arial, sans-serif;
        }

        .header .text {
          text-align: center;
          font-size: 16px;
          font-weight: bold;
          flex-grow: 1;
        }

        .header .left-logo {
          margin-right: auto;
        }

        .header .right-logo {
          margin-left: auto;
        }

        .horizontal-line {
          width: 100%;
          height: 1px;
          background-color: #000;
          margin-top: 10px;
        }

              /* Table Styles */
        table {
          width: 100%;
          border-collapse: collapse;
          margin: 20px 0;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          background: #fff;
        }

        th, td {
          border: 1px solid #ddd;
          padding: 8px;
          text-align: center;
        }

        th {
          background-color: #007BFF;
          color: white;
          font-weight: bold;
        }

        tr:nth-child(even) {
          background-color: #f9f9f9;
        }

        tr:hover {
          background-color: #f1f1f1;
        }

        .student-name {
          text-align: left;
          padding-left: 10px;
          font-weight: bold;
        }

        .summary {
          text-align: center;
        }
        </style>
        </head>
        <body>
        <div class="header">
        <img src="assets/deped_logo.png" alt="Logo 1" class="logo left-logo">
        <div class="text">
        Republic of the Philippines<br>
        Department of Education<br>
        Region XIII CARAGA<br>
        BLISS ELEMENTARY SCHOOL<br>
        SY: 2024-2025
        </div>
        <img src="assets/logo1.png" alt="Logo 2" class="logo right-logo">
        </div>

        <h2>General Average Report</h2>
        `);

        // Injecting the response content (the generated report)
      printWindow.document.write(response);

        // Horizontal line after content
      printWindow.document.write(`
        <div class="horizontal-line"></div>
        `);

      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    },
    error: function() {
      alert('Error fetching SF2 report details');
    }
  });
}




</script>



        <script>
    // Function to fetch date data (month-year) and update the nav list
          function fetchDateData() {
            $.ajax({
            url: 'getDateBackend', // Replace with your actual backend URL to fetch the date info
            method: 'GET',
            success: function(response) {
                const data = JSON.parse(response); // Assuming the response is in JSON format
                
                // Get the nav link container
                const navContainer = document.querySelector('.reportdate');

                // Clear any existing content (e.g., Loading...)
                navContainer.innerHTML = '';

                // Loop through the response and create list items dynamically
                data.forEach(function(item) {
                    // Assuming `item.month_id` is in `-YYYY` format, we add the month part dynamically
                    const monthYear = item.month_id.split('-'); // Split to get month and year
                    const monthNumber = monthYear[0]; // e.g., "11"
                    const year = monthYear[1]; // e.g., "2024"
                    
                    // Format the month id to MM-YYYY
                    const formattedMonthYear = `${monthNumber}-${year}`;

                    const navItem = document.createElement('li');
                    navItem.classList.add('nav-item');
                    
                    const navLink = document.createElement('a');
                    navLink.classList.add('nav-link');
                    navLink.href = '#';
                    navLink.setAttribute('onclick', `generateSF2R('${formattedMonthYear}')`); // Attach formatted month-year as parameter for the function

                    navLink.innerHTML = `
                    <i class="far fa-dot-circle nav-icon"></i>
                    <p>${item.date}</p> <!-- This will show the month-year (e.g., November 2024) -->
                    `;

                    // Append the new nav item to the nav container
                    navItem.appendChild(navLink);
                    navContainer.appendChild(navItem);
                  });
              },
              error: function() {
                console.log('Error fetching date data');
              }
            });
          }

    // Run fetchDateData after page load
          window.onload = function() {
        fetchDateData(); // Trigger the AJAX request after the page loads
      };
    </script>

