    <h1 class="text-shadow">Site CMS > <span class="title-small">Users</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-user icon-white"></i><h3>Users</h3>
        <a  class="btn btn-primary pull-right" href="<?php echo base_url(); ?>admin/users/add">add user &nbsp;&nbsp;<i class="icon-plus icon-white"></i></a>
      </div> 

      <div class="field-type">
        <ul>
          <li><a href="<?php echo base_url(); ?>admin/users/?sort=all">all (<?php echo $user_count['total']; ?>)</a>&nbsp;&nbsp;|</li>
          <li>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/?sort=admin">admin (<?php echo $user_count['admin']; ?>)</a>&nbsp;&nbsp;|</li>
          <li>&nbsp;&nbsp;<a href="<?php echo base_url(); ?>admin/users/?sort=user">users (<?php echo $user_count['users']; ?>)</a></li>
        </ul>  
      </div> 

      <table class="table-layout">
        
        <thead>
          <tr>
            <th></th>
            <th><a href="<?php echo base_url(); ?>admin/users/?sort=<?php echo $get_query['user_role']; ?>&col=username&dir=<?php echo $get_query['sort_dir_opp']; ?>">username</a></th>
            <th><a href="<?php echo base_url(); ?>admin/users/?sort=<?php echo $get_query['user_role']; ?>&col=name&dir=<?php echo $get_query['sort_dir_opp']; ?>">name</a></th>
            <th><a href="<?php echo base_url(); ?>admin/users/?sort=<?php echo $get_query['user_role']; ?>&col=email&dir=<?php echo $get_query['sort_dir_opp']; ?>">email</a></th>
            <th><a href="<?php echo base_url(); ?>admin/users/?sort=<?php echo $get_query['user_role']; ?>&col=role&dir=<?php echo $get_query['sort_dir_opp']; ?>">role</a></th>
            <th><a href="<?php echo base_url(); ?>admin/users/?sort=<?php echo $get_query['user_role']; ?>&col=banned&dir=<?php echo $get_query['sort_dir_opp']; ?>">banned</a></th>
            <th><a href="<?php echo base_url(); ?>admin/users/?sort=<?php echo $get_query['user_role']; ?>&col=last_access&dir=<?php echo $get_query['sort_dir_opp']; ?>">last accessed<a/></th>
            <th>actions</th>
          </tr>  
        </thead> 

        <tbody>

          <form id="" method="POST" action="<?php echo base_url(); ?>admin/users/edit_all_users">

          <?php $i=0; ?>
          <?php foreach($users as $user) { ?>
          <tr <?php echo ($i % 2 == 0) ? 'class="row-bg"' : ''; ?>>
            <td class="user-checkbox"><input type="checkbox" name="user" value="<?php echo $user->id; ?>" class="select-user" /></td>
            <td><?php echo clean_var($user->username); ?></td>
            <td><?php echo ucfirst(clean_var($user->first_name) . ' ' . clean_var($user->last_name)); ?></td>
            <td><?php echo clean_var($user->email); ?></td>
            <td><?php echo ($user->role == 1) ? 'admin' : 'user'; ?></td>
            <td><?php echo ($user->banned == 1) ? 'banned' : ''; ?></td>
            <td><?php echo $user->last_login; ?></td>
            <td><a class="btn btn-mini" href="<?php echo base_url(); ?>admin/users/edit/<?php echo $user->id; ?>"><i class="icon-pencil"></i></a> <a class="btn btn-mini delete-item" data-username="<?php echo $user->username; ?>" href="<?php echo base_url(); ?>admin/users/delete/<?php echo $user->id; ?>"><i class="icon-trash"></i></a></td>
          </tr>
          <?php $i++; ?>
          <?php } // end foreach ?>

          </form>  

        </tbody>  

      </table>  

      <?php echo $pagination; ?>

      <ul id="check-all-ul" class="clearfix">
        <li class="user-checkbox-all button">select all</li>
        <li> | </li>
        <li class="user-checkbox-clear button">clear all</li>  
        <li>
          <select id="users-select">
            <option>bulk actions</option>
            <option value="delete" id="option-delete">delete</option>
          </select>  
        </li>
      </ul>  

    </div> <!-- end .box-bg -->  
