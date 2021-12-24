<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<!-- Main content -->
<div class="pagetitle">
    <h1><?=$title?></h1>
</div>
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-outline-info" onclick="add_item()"><i class="bx bx-plus-medical"></i> <?= lang('Utils.add') ?></button>
                    <button class="btn btn-secondary" onclick="reload_table()"><i class="bx bx-refresh"></i> <?= lang('Utils.refresh') ?></button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="data_table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<?= $this->endSection() ?>
<?= $this->section('modals') ?>
<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Rol</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="form" class="row g-3">
                    <input type="hidden" value="" name="id"/>
                    <div class="col-12">
                        <label class="control-label">Name</label>
                        <div>
                            <input name="name" placeholder="Name" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="control-label">Description</label>
                        <div>
                            <textarea name="description" placeholder="Description" class="form-control"></textarea>
                            <span class="help-block"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><?= lang('Utils.save') ?></button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang('Utils.cancel') ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script>
    var save_method; //for save method string
    var table;

    $(function ()
    {
        table = $('#data_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ajax": {
                "url": '<?php echo base_url($controller.'/getAll') ?>',
                "type": "POST",
                "dataType": "json",
                async: "true"
            },
        });
    });

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function add_item()
    {
        save_method = 'add';
        clean_form('form');
        $('#modal_form').modal('show'); // show bootstrap modal
        $('#btnSave').attr('disabled',false); //set button enable
        $('.modal-title').text('<?= lang('Mythauth.permision_new_title') ?>'); // Set Title to Bootstrap modal title
    }

    function save()
    {
        $('#btnSave').text('<?= lang('Utils.saving') ?>...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url($controller.'/ajax_add')?>";
        } else {
            url = "<?php echo site_url($controller.'/ajax_update')?>";
        }

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                clean_errors();
                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                }
                else
                {
                    check_errors('#form', data.errores);
                    msg_error(data.message);
                }

                $('#btnSave').text('<?= lang('Utils.save') ?>'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                msg_error('<?= lang('Utils.error_ajax') ?>');
                $('#btnSave').text('<?= lang('Utils.save') ?>'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }

    function edit_item(id)
    {
        save_method = 'update';
        clean_form('form');

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url($controller.'/ajax_edit/')?>",
            data: {PermissionId: id},
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if(!data.status)
                {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                else
                {
                    $('#form [name="id"]').val(data.item.id);
                    $('#form [name="name"]').val(data.item.name);
                    $('#form [name="description"]').val(data.item.description);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('#btnSave').attr('disabled',false); //set button enable
                    $('.modal-title').text('<?= lang('Mythauth.permission_edit_title') ?>'); // Set title to Bootstrap modal title
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                msg_error('<?= lang('Utils.error_ajax') ?>');
            }
        });
    }

    function remove(id)
    {
        Swal.fire({
            title: '<?= lang('Mythauth.permission_remove') ?>',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: '<?= lang('Utils.yes') ?>',
            denyButtonText: `<?= lang('Utils.no') ?>`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url : "<?php echo site_url($controller.'/ajax_delete/')?>",
                    data: {PermissionId: id},
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(!data.status)
                        {
                            Swal.fire({
                                position: 'bottom-end',
                                icon: 'error',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        else
                        {
                            reload_table();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        msg_error('<?= lang('Utils.error_ajax') ?>');
                    }
                });
            }
        })
    }
</script>
<?= $this->endSection() ?>
