<?php
ob_start();
$pageTitle = 'Adviser Dashboard'; 
?>

<?php
// Sample male and female count variables (replace with your actual data)
$maleCount = 10;  // Example male count
$femaleCount = 15;  // Example female count

// Prepare the data for Chart.js (male and female counts)
$gender_labels = json_encode(['Male', 'Female']);
$gender_counts = json_encode([$maleCount, $femaleCount]);


?>



  <style>

    canvas {
      max-width: 800px;
      margin: 0 auto;
    }
    .chart-container {
      text-align: center;
    }
  </style>

<div class="row">
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-info">
			<div class="inner">
				<h3><?php echo $maleCount; ?></h3>
				<p>Total Male Enrolled</p>
			</div>
			<div class="icon">
				<i class="ion ion-bag"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-success">
			<div class="inner">
				<h3><?php echo $femaleCount; ?></h3>
				<p>Total Female Enrolled</p>
			</div>
			<div class="icon">
				<i class="ion ion-stats-bars"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-warning">
			<div class="inner">
				<h3><?php echo htmlspecialchars(count($presentStudents)+count($tardyStudents)); ?></h3>
				<p>Total Present Today</p>
			</div>
			<div class="icon">
				<i class="ion ion-person-add"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
	<div class="col-lg-3 col-6">
		<!-- small box -->
		<div class="small-box bg-danger">
			<div class="inner">
				<h3><?php echo htmlspecialchars(count($absentStudents)+count($exuseStudents)); ?></h3>
				<p>Total Absent Today</p>
			</div>
			<div class="icon">
				<i class="ion ion-pie-graph"></i>
			</div>
		</div>
	</div>
	<!-- ./col -->
</div>
<!-- /.row -->







<div class="row">
	<section class="col-lg-6 connectedSortable">



<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Attendance Chart for this month</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="attendanceChart" width="800" height="400"></canvas>
        </div>
    </div>
</div>









		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					Top 10 Students Quarterly
				</h3>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Rank</th>
							<th>Name</th>
							<th>Average Grade</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($top10Students as $index => $student): ?>
							<tr>
								<td><?php echo $index + 1; ?></td>
								<td><?php echo htmlspecialchars($student['fullname']); ?></td>
								<td><?php echo number_format($student['average_grade'], 2); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					Top Subject Performers Quarterly
				</h3> 
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Award</th>
							<th>Top Student</th>
							<th>Grade</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($topStudentsPerSubject as $subject): ?>
							<tr>
								<td>Best in <?php echo htmlspecialchars($subject['subject_name']); ?></td>
								<td><?php echo htmlspecialchars($subject['fullname']); ?></td>
								<td><?php echo number_format($subject['grade'], 2); ?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<section class="col-lg-6 connectedSortable">





<!-- Second chart (duplicated) -->
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Gender Chart</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
            <canvas id="attendanceChart2" width="800" height="400"></canvas>
        </div>
    </div>
</div>














		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					Students with Birthdays (This Month)
				</h3>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Full Name</th>
							<th>Birth Date</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($studentsWithBirthday)): ?>
							<?php foreach ($studentsWithBirthday as $index => $student): ?>
								<tr>
									<td><?php echo $index + 1; ?></td>
									<td><?php echo htmlspecialchars($student['fullname']); ?></td>
									<td><?php echo date('F d, Y', strtotime($student['birth_date'])); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="3" class="text-center">No students with birthdays this month.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">
					Attendance Today
				</h3>
			</div>
			<div class="card-body">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>Attendance Status</th>
							<th>Students</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><strong>Present</strong></td>
							<td>
								<?php if (!empty($presentStudents)): ?>
									<ul class="list-unstyled mb-0">
										<?php foreach ($presentStudents as $student): ?>
											<li><?php echo htmlspecialchars($student['fullname']); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php else: ?>
									<em>No students present</em>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td><strong>Absent</strong></td>
							<td>
								<?php if (!empty($absentStudents)): ?>
									<ul class="list-unstyled mb-0">
										<?php foreach ($absentStudents as $student): ?>
											<li><?php echo htmlspecialchars($student['fullname']); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php else: ?>
									<em>No students absent</em>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td><strong>Tardy</strong></td>
							<td>
								<?php if (!empty($tardyStudents)): ?>
									<ul class="list-unstyled mb-0">
										<?php foreach ($tardyStudents as $student): ?>
											<li><?php echo htmlspecialchars($student['fullname']); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php else: ?>
									<em>No students tardy</em>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td><strong>Excused</strong></td>
							<td>
								<?php if (!empty($exuseStudents)): ?>
									<ul class="list-unstyled mb-0">
										<?php foreach ($exuseStudents as $student): ?>
											<li><?php echo htmlspecialchars($student['fullname']); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php else: ?>
									<em>No students excused</em>
								<?php endif; ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<script>
// First Chart
const ctx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo $day_labels_json; ?>,
        datasets: [{
            label: 'Present',
            data: <?php echo $present_counts_json; ?>, // Present count (y-axis)
            backgroundColor: 'green',
            borderColor: 'green',
            borderWidth: 1
        }, {
            label: 'Absent',
            data: <?php echo $absent_counts_json; ?>, // Absent count (y-axis)
            backgroundColor: 'red',
            borderColor: 'red',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Second Chart (Duplicated)
const ctx2 = document.getElementById('attendanceChart2').getContext('2d');
const attendanceChart2 = new Chart(ctx2, {
    type: 'pie',
    data: {
         labels: <?php echo $gender_labels; ?>, 
            datasets: [{
                label: 'Gender Distribution',
                data: <?php echo $gender_counts; ?>, // counts of Male, Female
                backgroundColor: ['#36A2EB', '#FF6384'], // Colors for Male and Female
                borderColor: ['#FFFFFF', '#FFFFFF'], // Border color
                borderWidth: 1
            }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


<?php
$content = ob_get_clean();
include 'views/master.php';
?>