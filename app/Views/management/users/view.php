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

    .form-control option {
        padding: 10px;  !important;
        border-bottom: 1px solid #efefef; !important;
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
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="data_table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
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
<!-- Add modal content -->
<div id="edit-modal" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="basicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="text-center bg-info p-3">
                <h4 class="modal-title text-white" id="info-header-modalLabel"><?= lang('Mythauth.user_edit_title') ?></h4>
            </div>
            <div class="modal-body">
                <form id="edit-form" class="pl-3 pr-3">
                    <div class="row">
                        <input type="hidden" id="id" name="id" class="form-control" placeholder="Id" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="Ban" id="Ban" class="custom-control-input">
                                    <label class="custom-control-label" for="Ban"><?= lang('Mythauth.user_suspend') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <input type="text" name="reason" id="reason" class="form-control" placeholder="<?= lang('Mythauth.user_suspend_reason') ?>" maxlength="40">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="activate" id="activate" class="custom-control-input">
                                    <label class="custom-control-label" for="activate"><?= lang('Mythauth.user_activate') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" name="forcepassword" id="forcepassword" class="custom-control-input">
                                    <label class="custom-control-label" for="forcepassword"><?= lang('Mythauth.user_force_change_pwd') ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success" id="edit-form-btn" onclick="save_details();"><?= lang('Utils.update') ?></button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang('Utils.cancel') ?></button>
                        </div>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="modal-roles" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="basicModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="text-center bg-info p-3">
                <h4 class="modal-title text-white" id="info-header-modalLabel">Roles</h4>
            </div>
            <div class="modal-body">
                <form id="form-roles" class="pl-3 pr-3">
                    <input type="hidden" id="UserId" name="UserId" class="form-control" placeholder="Id" required>
                    <select multiple="multiple" size="10" name="roles" title="roles">
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="asignarRoles()" class="btn btn-primary"><?= lang('Utils.save') ?></button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><?= lang('Utils.cancel') ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div hidden>
    <select name="TodosRoles" title="TodosRoles">
    </select>
</div>
<?= $this->endSection() ?>
<?= $this->section('javascript') ?>
<script type="text/javascript" src="<?=base_url()?>/assets/scripts/bootstrap-duallistbox-4/jquery.bootstrap-duallistbox.js"></script>
<link href="<?=base_url()?>/assets/scripts/bootstrap-duallistbox-4/bootstrap-duallistbox.css" rel="stylesheet">-
<script>
    $(function () {
        $('#data_table').DataTable({
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
        $('#Ban').change(function() {
            if($(this).prop('checked'))
            {
                $('#reason').removeAttr("disabled");
            }
            else
                $('#reason').attr("disabled", "disabled");
        });
        llenarRoles();
    });

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

    function edit(id) {
        $.ajax({
            url: '<?php echo base_url($controller.'/getOne') ?>',
            type: 'post',
            data: {
                id: id
            },
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
                    // reset the form
                    $("#edit-form")[0].reset();
                    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
                    $('#edit-modal').modal('show');
                    $("#edit-form #id").val(id);
                    $('#Ban').prop('checked', false).change();
                    $('#activate').prop('checked', false).change();
                    $('#forcepassword').prop('checked', false).change();

                    if(response.isBanned)
                    {
                        $('#Ban').prop('checked', true).change();
                    }
                    if(response.isActivated)
                    {
                        $('#activate').prop('checked', true).change();
                    }
                }
            }
        });
    }

    function save_details()
    {

        var form = $('#edit-form');
        $(".text-danger").remove();
        $.ajax({
            url: '<?php echo base_url($controller.'/edit') ?>' ,
            type: 'post',
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('#edit-form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            success: function(response) {

                if (response.status === true) {
                    Swal.fire({
                        position: 'bottom-end',
                        icon: 'success',
                        title: response.messages,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        $('#edit-modal').modal('hide');
                    })
                } else {
                    if (response.message instanceof Object) {
                        $.each(response.message, function(index, value) {
                            var id = $("#" + index);

                            id.closest('.form-control')
                                .removeClass('is-invalid')
                                .removeClass('is-valid')
                                .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');

                            id.after(value);

                        });
                    } else {
                        Swal.fire({
                            position: 'bottom-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }
                }
                $('#edit-form-btn').html('<?= lang('Utils.update') ?>');
            }
        });
        return false;
    }

    function roles(id) {
        // reset the form
        $("#form-roles")[0].reset();
        $('#modal-roles').modal('show');
        $("#form-roles #UserId").val(id);
        $('select[name="roles"]').bootstrapDualListbox({
            nonSelectedListLabel: '<?= lang('Mythauth.user_roles_list_availables') ?>',
            selectedListLabel: '<?= lang('Mythauth.user_roles_list_assigned') ?>',
            preserveSelectionOnMove: 'moved',
            /*moveOnSelect:false,*/
            showFilterInputs: false,
            infoText: 'Mostrando todos {0}',
            infoTextEmpty: '<?= lang('Mythauth.list_empty') ?>',
            btnMoveAllText: '<?= lang('Mythauth.list_move_all') ?>',
            btnRemoveAllText: '<?= lang('Mythauth.list_remove_all') ?>'
        });
        $.ajax({
            url: '<?php echo base_url($controller.'/getRoles') ?>',
            type: 'post',
            data: {id: id},
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
                    $('select[name="roles"]').empty();
                    for (var item of response.items)
                    {
                        option = $('<option>').val(item).text(item).attr('selected','selected');
                        $('select[name="roles"]').append(option);
                    }
                    $('select[name="TodosRoles"] option').each(function()
                    {
                        if(!response.items.includes($(this).val()))
                        {
                            option = $('<option>').val($(this).val()).text($(this).val());
                            $('select[name="roles"]').append(option);
                        }
                    });
                    $('select[name="roles"]').bootstrapDualListbox('refresh');
                }

            }
        });
    }

    function asignarRoles()
    {
        let roles = $('#form-roles [name="roles"]').val()
        let id = $('#form-roles #UserId').val();

        $.ajax({
            url: '<?php echo base_url($controller.'/setRoles') ?>',
            type: 'post',
            data: {UserId: id, roles: roles},
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
                        $('#modal-roles').modal('hide');
                    })

                }

            }
        });
    }

</script>
<?= $this->endSection() ?>
