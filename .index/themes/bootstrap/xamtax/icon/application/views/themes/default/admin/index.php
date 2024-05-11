<div class="container">
    <br />
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'admin/account/'; ?>">Account</a></li>
        <li class="nav-item"><a class="nav-link active" href="<?php echo base_url().'admin'; ?>">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="<?php echo base_url().'admin/logout'; ?>">Logout</a></li>
    </ul>
    <br />
    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>ICON</th>
                <th>URL</th>
                <th>IP ADDRESS</th>
                <th>ACTION</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>ICON</th>
                <th>URL</th>
                <th>IP ADDRESS</th>
                <th>ACTION</th>
            </tr>
        </tfoot>
        <tbody>
            
            <?php foreach($all as $item): ?>
            
            <tr>
                <td><?php echo $item['id'];?></td>
                <td><img src="<?php echo base_url();?>upload/<?php echo $item['image_name'];?>.ico" class="ui avatar image"></td>
                <td><?php echo $item['url'];?></td>
                <td><?php echo $item['ip_address'];?></td>
                <td>
                    <div class="btn-group">
                        <a href="<?php echo base_url();?>admin/status/<?php echo $item['image_name'];?>" class="btn btn-sm btn-primary" data-inverted="" data-tooltip="Click to change status" data-position="bottom right"><?php if($item['public'] == 1){echo 'Public';}else{echo 'Private';}?></a>
                        <a href="<?php echo base_url();?>admin/delete/<?php echo $item['image_name'];?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="remove icon"></i>Delete</a>
                    </div>
                </td>
            </tr>

            <?php endforeach; ?>
            
        </tbody>
    </table>
</div>


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
        "order": [[ 0, "desc" ]]
        } );
    } );
</script>