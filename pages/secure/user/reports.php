<?php
require_once __DIR__ . '../../../../infra/middlewares/middleware-user.php';
@require_once __DIR__ . '/../../../helpers/session.php';

$user = user();

include_once __DIR__ . '../../../../templates/header.php';
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
		<h4 class="text-dark text-center" style="margin-top: 20px;"><strong>&nbsp;</strong></h4>
		</div>
	</div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header text-center">
        <strong>Project Progress</strong>
        <div class="card-tools">
          <button class="btn btn-rounder btn-sm btn-print" id="print">
            <i class="fa fa-print"></i> Print
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
		<div class="card-body p-0">
			<div class="table-responsive" id="printable">
				<table class="table m-0 table-bordered">
					<thead>
						<th>#</th>
						<th>Project</th>
						<th>Task</th>
						<th>Completed Task</th>
						<th>Work Duration</th>
						<th>Progress</th>
						<th>Status</th>
					</thead>
					<tbody>
					<?php
					@require_once __DIR__ . '/../../../helpers/project.php';
					@require_once __DIR__ . '/../../../helpers/task.php';
					@require_once __DIR__ . '/../../../helpers/productivity.php';

					$i = 1;
					$status = array("Pending", "Started", "On-Progress", "On-Hold", "Over Due", "Done");

					if (administrator()) {
						$projects = getProjects();
					} else {
						$userProjects = getUserProjects($user['id']);
						$userAddedProjects = getUserAddedProjects($user['id']);
						$projects = array_merge($userProjects, $userAddedProjects);
					}

					foreach ($projects as $project):
						$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
						unset($trans['\"'], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($project['description']), $trans);
						$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);

						$prog = 0;
						$tasksWithProjectId = getTasksWithProjectId($project['id']);
						$tasksWithProjectIdAndStatus = getTasksWithProjectIdAndStatus($project['id'], 3);
						$productivitiesWithProjectId = getProductivitiesWithProjectId($project['id']);
						$summedTimeRendered = getMultipleSummedTimeRenderedWithProjectId($project['id']);

						$tprog = 0;
						$cprog = 0;
						$prod = 0;
						$dur = 0;

						foreach($tasksWithProjectId as $task):
							$tprog++;
						endforeach;

						foreach ($tasksWithProjectIdAndStatus as $task2):
							$cprog++;
						endforeach;

						foreach ($productivitiesWithProjectId as $productivity):
							$prod++;
						endforeach;

						foreach ($summedTimeRendered as $summedTime):
							$dur++;
						endforeach;

						$prog = $tprog > 0 ? ($cprog/$tprog) * 100 : 0;
						$prog = $prog > 0 ? number_format($prog, 2) : $prog;

						$dur = $dur > 0 ? $summedTimeRendered['duration'] : 0;
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
						<td><?php echo $i++; ?></td>
						<td>
							<a><?php echo ucwords($project['title']); ?></a>
							<br>
							<small>
								Due: <?php echo date("d-m-Y", strtotime($project['end_date'])); ?>
							</small>
						</td>
						<td class="text-center">
							<?php echo number_format($tprog); ?>
						</td>
						<td class="text-center">
							<?php echo number_format($cprog); ?>
						</td>
						<td class="text-center">
							<?php echo number_format($dur) . ' Hour(s)'; ?>
						</td>
						<td class="project_progress">
							<div class="progress progress-sm">
								<div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $prog ?>%">
								</div>
							</div>
							<small>
								<?php echo $prog; ?>% Complete
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
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$('#print').click(function(){
		start_load()
		var _h = $('head').clone()
		var _p = $('#printable').clone()
		var _d = "<p class='text-center'><b>Project Progress Report as of (<?php echo date("F d, Y") ?>)</b></p>"
		_p.prepend(_d)
		_p.prepend(_h)
		var nw = window.open("","","width=900,height=600")
		nw.document.write(_p.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
			nw.close()
			end_load()
		},750)
	})
</script>