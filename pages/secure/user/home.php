<?php
require_once __DIR__ . '../../../../infra/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../helpers/session.php';

$user = user();

include_once __DIR__ . '../../../../templates/header.php';
?>

<link rel="stylesheet" href="<?php BASE_URL?>/BuyTime/assets/css/pages/dashboard.css">

<div class="col-12">
	<div class="welcome">
		Hello <?php echo $user['name']; ?>!
	</div>
	<div class="welcome-back" style="margin-left: 20px;">
		<span>Welcome Back!</span>
	</div>
</div>
<hr>

<div class="row">
	<div class="col-md-8">
		<div class="card card-outline card-sucess">
			<div class="card-header">
				<b>Project Progress</b>
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table m-0 table-hover">
						<!-- <colgroup>
							<col width="5">
							<col width="30">
							<col width="35">
							<col width="15">
							<col width="15">
						</colgroup> -->
						<thead>
							<th>#</th>
							<th>Project</th>
							<th>Progress</th>
							<th>Status</th>
							<th>Category</th>
							<th>Priority</th>
							<th>Actions</th>
						</thead>
						<tbody>
							<?php
								@require_once __DIR__ . '/../../../helpers/project.php';
								@require_once __DIR__ . '/../../../helpers/task.php';
								@require_once __DIR__ . '/../../../helpers/productivity.php';

								$i = 0;
								$status = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");
								$categories = array("Undetermined", "Professional", "Academic", "Personal", "Health", "Technology", "Art", "Community", "Business", "General");
								$priorities = array("Undetermined", "Not Important", "Normal", "Important");
								$projects = getProjects();

								foreach ($projects as $project):
									$prog = 0;
									$tasksWithProjectId = getTasksWithProjectId($project['id']);
									$tasksWithProjectIdAndStatus = getTasksWithProjectIdAndStatus($project['id'], 3);
									$productivitiesWithProjectId = getProductivitiesWithProjectId($project['id']);
									
									$tprog = 0;
									$cprog = 0;
									$prod = 0;

									foreach($tasksWithProjectId as $task):
										$tprog++;
									endforeach;

									foreach ($tasksWithProjectIdAndStatus as $task2):
										$cprog++;
									endforeach;

									foreach ($productivitiesWithProjectId as $productivity):
										$prod++;
									endforeach;

									$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
									$prog = $prog > 0 ? number_format($prog, 2) : $prog;
									
									if ($project['status'] == 0 && strtotime(date('Y-m-d')) >= strtotime($project['start_date'])):
										if ($prod > 0 || $cprog > 0)
											$project['status'] = 2;
										else
											$project['status'] = 1;
									elseif ($project['status'] == 0 && strtotime(date('Y-m-d')) > strtotime($project['end_date'])):
										$project['status'] = 4;
									endif;
							?>
							<tr>
								<td>
									<?php echo $i++ ?>
								</td>
								<td>
									<a>
										<?php echo ucwords($project['title']) ?>
									</a>
									<br>
									<small>
										Due: <?php echo date("Y-m-d", strtotime($project['end_date'])) ?>
									</small>
								</td>
								<td class="project_progress">
									<div class="progress progress-sm">
										<div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%"></div>
									</div>
									<small>
										<?php echo $prog ?>% Complete
									</small>
								</td>
								<td class="project-state">
									<?php
										if ($status[$project['status']] == 'Pending') {
											echo "<span class='badge badge-p'>{$status[$project['status']]}</span>";
										} elseif ($status[$project['status']] == 'Started') {
											echo "<span class='badge badge-s'>{$status[$project['status']]}</span>";
										} elseif ($status[$project['status']] == 'On-Progress') {
											echo "<span class='badge badge-op'>{$status[$project['status']]}</span>";
										} elseif ($status[$project['status']] == 'On-Hold') {
											echo "<span class='badge badge-oh'>{$status[$project['status']]}</span>";
										} elseif ($status[$project['status']] == 'Over Due') {
											echo "<span class='badge badge-od'>{$status[$project['status']]}</span>";
										} elseif ($status[$project['status']] == 'Done') {
											echo "<span class='badge badge-d'>{$status[$project['status']]}</span>";
										}
									?>
								</td>
								<td>
									<?php
										echo "<span class='badge badge-bt'>{$categories[$project['category']]}</span>";
									?>
								</td>
								<td>
									<?php
										if ($priorities[$project['priority']] == 'Undetermined') {
											echo "<span class='badge badge-p'>{$priorities[$project['priority']]}</span>";
										} elseif ($priorities[$project['priority']] == 'Not Important') {
											echo "<span class='badge badge-oh'>{$priorities[$project['priority']]}</span>";
										} elseif ($priorities[$project['priority']] == 'Normal') {
											echo "<span class='badge badge-d'>{$priorities[$project['priority']]}</span>";
										} elseif ($priorities[$project['priority']] == 'Important') {
											echo "<span class='badge badge-od'>{$priorities[$project['priority']]}</span>";
										}
									?>
								</td>
								<td>
									<a href="./index.php?page=view_project&id=<?php echo $project['id'] ?>" class="btn btn-color btn-sm">
										<i class="fas fa-folder" style="color: #ffffff;"></i>
										<strong>View</strong>
									</a>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-12">
				<div class="small-box bg-light shadow-sm border">
					<div class="inner">
						<h3><?php echo $i ?></h3>

						<p>Total Projects</p>
					</div>
					<div class="icon">
						<i class="fa fa-layer-group" style="color: #b5b9ed;"></i>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-12">
				<div class="small-box bg-light shadow-sm border">
					<div class="inner">
						<?php
							$totalTasks = 0;
							$tasks = getAllTasks();

							foreach ($tasks as $task):
								$totalTasks++;
							endforeach
						?>
						<h3><?php echo $totalTasks ?></h3>

						<p>Total Tasks</p>
					</div>
					<div class="icon">
						<i class="fa fa-tasks" style="color: #b5b9ed;"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>