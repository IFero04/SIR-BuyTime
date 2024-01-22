<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h4 class="text-dark text-center" style="margin-top: 20px;"><strong>&nbsp;</strong></h4>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <a href="./index.php?page=new_user" class="btn btn-block btn-sm btn-default btn-rounder">
              <i class="fa fa-plus"></i>
              <strong>Create New User</strong>
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="list">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                @require_once __DIR__ . '/../../../helpers/project.php';
                @require_once __DIR__ . '/../../../helpers/task.php';
                @require_once __DIR__ . '/../../../helpers/productivity.php';

                $i = 1;
                $type = array('User', 'Admin');

                $users = getEveryUser();

                foreach ($users as $_user):
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++; ?></td>
                  <td><b><?php echo ucwords($_user['name'] . ' ' . $_user['lastname']); ?></b></td>
                  <td><b><?php echo $_user['email']; ?></b></td>
                  <td><b><?php echo $type[$_user['administrator']]; ?></b></td>
                  <td class="text-center">
                    <div class="btn-group">
                      <button class="btn btn-action btn-sm btn-rounder wave-effect dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        Actions
                      </button>
                      <div class="dropdown-menu">
                        <a href="javascript:void(0)" class="dropdown-item view_user" data-id="<?php echo $_user['id']; ?>">View</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./index.php?page=edit_user&id=<?php echo $_user['id'] ?>">Edit</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item delete_user" href="javascript:void(0)" data-id="<?php echo $_user['id'] ?>">Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
	$(document).ready(() => {
		$('#list').dataTable();

		$('.view_user').click(function(){
			uni_modal("<i class='fa fa-id-card'></i> User Details", "view_user.php?id="+$(this).attr('data-id'));
		});

		$('.delete_user').click(function(){
			_conf("Are you sure to delete this user?", "delete_user", [$(this).attr('data-id')])
		});
	});

	function delete_user($id) {
		start_load();

		$.ajax({
			url: '/BuyTime/helpers/ajax.php?action=delete_user',
			method:'POST',
			data: {id:$id},
			success: response => {
				if (response == 1) {
					alert_toast("Data successfully deleted",'success')
					setTimeout(() => {
						location.reload()
					},1500)
				}
			}
		});
	}
</script>