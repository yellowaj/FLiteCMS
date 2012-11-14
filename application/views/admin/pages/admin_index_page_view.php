    <h1 class="text-shadow">Site CMS > <span class="title-small">Pages</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-file icon-white"></i><h3>Pages</h3>
        <a  class="btn btn-primary pull-right" href="<?php echo base_url(); ?>admin/pages/create">add page &nbsp;&nbsp;<i class="icon-plus icon-white"></i></a>
      </div> 

      <table class="table-layout">
        
        <thead>
          <tr>
            <th></th>
            <th>title</th>
            <th>url</th>
            <th>type</th>
            <th>status</th>
            <th>actions</th>
          </tr>  
        </thead> 

        <tbody>

          <?php if(!empty($pages)) { ?>
          <?php $i=0; ?>
          <?php foreach($pages as $page) { ?>
          <tr <?php echo ($i % 2 == 0) ? 'class="row-bg"' : ''; ?>>
            <td class="user-checkbox"><input type="checkbox" name="page" value="<?php echo $page->id; ?>" class="select-page" /></td>
            <td><?php echo clean_var($page->title); ?></td>
            <td>/<?php echo clean_var($page->url); ?></td>
            <td><?php echo clean_var($page->page_type); ?></td>
            <td><?php echo ($page->publish == 1) ? 'published' : 'draft'; ?></td>
            <td><a class="btn btn-mini" href="<?php echo base_url(); ?>admin/pages/edit/<?php echo $page->id; ?>"><i class="icon-pencil"></i></a> <a class="btn btn-mini delete-item" data-username="<?php echo clean_var($page->title); ?>" href="<?php echo base_url(); ?>admin/pages/delete/<?php echo $page->id; ?>"><i class="icon-trash"></i></a></td>
          </tr>
          <?php $i++; ?>
          <?php } // end foreach ?>
          <?php } else { ?>
          <tr>
            <td></td>
            <td>No pages created.</td>
          </tr>  
          <?php } ?>

        </tbody>

      </table>  

      <?php echo $pagination; ?>

      <ul id="check-all-ul" class="clearfix">
        <li class="page-checkbox-all button">select all</li>
        <li> | </li>
        <li class="page-checkbox-clear button">clear all</li>  
        <li>
          <select id="pages-select">
            <option>bulk actions</option>
            <option value="delete" id="option-delete">delete</option>
          </select>  
        </li>
      </ul>

    </div> <!-- end .box-bg -->  
