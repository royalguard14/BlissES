<?php
ob_start();
$pageTitle = 'Registrar Dashboard'; 
?>

        <div class="row">
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-none">
              <span class="info-box-icon bg-default"><img src="assets/img/icons/male-student.png" style="width: 50vh;"></span>

              <div class="info-box-content">
                <span class="info-box-text" >Male Learners</span>
                <span class="info-box-number"><?php echo htmlspecialchars($totalMale); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-sm">
              <span class="info-box-icon bg-default"><img src="assets/img/icons/female-student.png" style="width: 50vh;"></span>

              <div class="info-box-content">
               <span class="info-box-text" >Female Learners</span>
                <span class="info-box-number"><?php echo htmlspecialchars($totalFemale); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow">
              <span class="info-box-icon bg-default"><img src="assets/img/icons/teacher.png" style="width: 50vh;"></span>

              <div class="info-box-content">
                <span class="info-box-text">Teachers</span>
                <span class="info-box-number"><?php echo htmlspecialchars($totalTeachers); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box shadow-lg">
              <span class="info-box-icon bg-default"><img src="assets/img/icons/parents.png" style="width: 50vh;"></span>

              <div class="info-box-content">
                <span class="info-box-text">Parents</span>
                 <span class="info-box-number"><?php echo htmlspecialchars($totalParents); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">
          

          Sales
        </h3>
      </div>
      <div class="card-body">
            <table class="table table-bordered table-striped" id="summarys">
          <thead>
            <tr>
        <th>Grade</th>
        <th>Section</th>
        <th>Adviser Name</th>
        <th>Total Male</th>
        <th>Total Female</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($registrarSummary as $index => $data): ?>
              <tr>
              
                <td><?php echo htmlspecialchars($data['level']); ?></td>
                <td><?php echo htmlspecialchars($data['section_name']); ?></td>
                <td><?php echo htmlspecialchars($data['adviser_name']); ?></td>
                <td><?php echo htmlspecialchars($data['total_male']); ?></td>
                <td><?php echo htmlspecialchars($data['total_female']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

</div>

<script>
    $(document).ready(function () {
        $('#summarys').DataTable({
            "paging": true,        // Enable pagination
            "searching": true,     // Enable search bar
            "info": true,          // Show table info
            "lengthChange": true,  // Allow changing number of rows displayed
            "ordering": true       // Enable column ordering
        });
    });
</script>
<?php
$content = ob_get_clean();
include 'views/master.php';
?>