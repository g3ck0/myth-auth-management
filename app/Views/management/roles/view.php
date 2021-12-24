<?= $this->extend('template') ?>
<?= $this->section('javascript_head') ?>
<style type="text/css">
    .bootstrap-duallistbox-container.moveonselect .moveall
    , .bootstrap-duallistbox-container.moveonselect .removeall {
        border: 1px solid #ccc !important;
        color: #fff;
        background-color: #6c757d;
    }
    .bootstrap-duallistbox-container.moveonselect .moveall:hover
    , .bootstrap-duallistbox-container.moveonselect .removeall:hover {
        background-color: #fff;
        color: #6c757d;
    }
</style>
<?= $this->endSection() ?>
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
<div class="modal fade" id="modal_permissions" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="text-center bg-info p-3">
                <h4 class="modal-title text-white" id="info-header-modalLabel">Asignar Permisos</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="RoleId" name="RoleId" class="form-control" required>
                <select multiple="multiple" size="10" name="Permisos" title="Permisos">
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="assign_permissions()" class="btn btn-primary"><?= lang('Utils.save') ?></button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang('Utils.cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<div hidden>
    <select name="TodosPermisos" title="TodosPermisos">
    </select>
</div>

<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script type="text/javascript" src="<?=base_url()?>/assets/scripts/bootstrap-duallistbox-4/jquery.bootstrap-duallistbox.js"></script>
<link href="<?=base_url()?>/assets/scripts/bootstrap-duallistbox-4/bootstrap-duallistbox.css" rel="stylesheet">-
<script>
    var save_method; //for save method string
    var table;

    $(function () {
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

        llenarPermisos();
    });

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function llenarPermisos()
    {
        $.ajax({
            url: '<?php echo base_url('permissions/getPermisos') ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                if(response.status)
                {
                    for (var item of response.items)
                    {
                        option = $('<option>').val(item).text(item);
                        $('select[name="TodosPermisos"]').append(option);
                    }
                }

            }
        });
    }

    function add_item()
    {
        save_method = 'add';
        clean_form('form');
        $('#modal_form').modal('show'); // show bootstrap modal
        $('#btnSave').attr('disabled',false); //set button enable
        $('.modal-title').text('<?= lang('Mythauth.role_new_title') ?>'); // Set Title to Bootstrap modal title
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
            data: {RolId: id},
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
                    $('.modal-title').text('<?= lang('Mythauth.role_edit_title') ?>'); // Set title to Bootstrap modal title
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
            title: '<?= lang('Mythauth.role_remove') ?>',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: '<?= lang('Utils.yes') ?>',
            denyButtonText: `<?= lang('Utils.no') ?>`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url : "<?php echo site_url($controller.'/ajax_delete/')?>",
                    data: {RolId: id},
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

    function show_permissions(id)
    {
        $('#modal_permissions').modal('show'); // show bootstrap modal
        $("#RoleId").val(id);
        $('select[name="Permisos"]').bootstrapDualListbox({
            nonSelectedListLabel: '<?= lang('Mythauth.role_permissions_availables') ?>',
            selectedListLabel: '<?= lang('Mythauth.role_permissions_assigned') ?>',
            preserveSelectionOnMove: 'moved',
            /*moveOnSelect:false,*/
            showFilterInputs: false,
            infoText: 'Mostrando todos {0}',
            infoTextEmpty: '<?= lang('Mythauth.list_empty') ?>',
            btnMoveAllText: '<?= lang('Mythauth.list_move_all') ?>',
            btnRemoveAllText: '<?= lang('Mythauth.list_remove_all') ?>'
        });
        $.ajax({
            url: '<?php echo base_url($controller.'/getPermisos') ?>',
            type: 'post',
            data: {RoleId: id},
            dataType: 'json',
            success: function(response) {
                if(!response.status)
                {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'error',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
                else
                {
                    $('select[name="Permisos"]').empty();
                    for (var item of response.items)
                    {
                        option = $('<option>').val(item).text(item).attr('selected','selected');
                        $('select[name="Permisos"]').append(option);
                    }
                    $('select[name="TodosPermisos"] option').each(function()
                    {
                        if(!response.items.includes($(this).val()))
                        {
                            option = $('<option>').val($(this).val()).text($(this).val());
                            $('select[name="Permisos"]').append(option);
                        }
                    });
                    $('select[name="Permisos"]').bootstrapDualListbox('refresh');
                }

            }
        });
    }

    function llenarRoles()
    {
        $.ajax({
            url: '<?php echo base_url('roles/getRoles') ?>',
            type: 'get',
            dataType: 'json',
            success: function(response) {
                if(response.status)
                {
                    for (var item of response.items)
                    {
                        option = $('<option>').val(item).text(item);
                        $('select[name="TodosRoles"]').append(option);
                    }
                }

            }
        });
    }

    function assign_permissions()
    {
        let permisos = $('[name="Permisos"]').val()
        let id = $('#RoleId').val();
        if(permisos.length>0)
        {
            $.ajax({
                url: '<?php echo base_url($controller.'/setPermisos') ?>',
                type: 'post',
                data: {RoleId: id, Permisos: permisos},
                dataType: 'json',
                success: function(response) {
                    if(!response.status)
                    {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    else
                    {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            $('#modal_permissions').modal('hide');
                        })
                    }
                }
            });
        }
        else
        {
            Swal.fire({
                title: '<?= lang('Mythauth.role_remove_all_permissions') ?>',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: '<?= lang('Utils.yes') ?>',
                denyButtonText: `<?= lang('Utils.no') ?>`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        url : "<?php echo site_url($controller.'/permissionsRemove/')?>",
                        data: {RoleId: id},
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
                                $('#modal_permissions').modal('hide');
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

    }


</script>
<?= $this->endSection() ?>
