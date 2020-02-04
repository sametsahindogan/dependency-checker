<div class="modal-header">
    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
        <i class="font-icon-close-2"></i>
    </button>
    <h4 class="modal-title" id="myModalLabel">Confirmation</h4>
</div>
<form id="form-email-remove" method="POST" action="{{route('emails.delete')}}">
    <div class="modal-body text-center">
        Are you sure you want to delete the record?
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        <button class="btn btn-success btn-submit"><i class="fa fa-check"></i> Yes, delete</button>
    </div>
</form>
<script>
    $("form#form-email-remove").submit(function (e) {
        $form = $(this);
        $action = $form.attr('action');
        $method = $form.attr('method');
        $.ajax({
            type: $method,
            url: $action,
            data: {id: '{{$email->id}}'},
            beforeSend: function () {
                $('.btn-submit').attr('disabled', true);
                LoadBlock($form, '<i class="fa fa-circle-o-notch fa-spin"></i><h6>Please wait..</h6>');
            },
            success: function (data) {
                try {
                    if (data.result === true) {
                        notify('Successfull', data.message, 'success', 'fa fa-check');
                        $('#modalsm').modal('hide');
                        $('#emails').bootstrapTable('refresh');
                    } else {
                        notify('Error', data.message, 'error', 'fa fa-times');
                    }
                } catch (err) {
                    console.log(err);
                }
                $('.btn-submit').removeAttr('disabled');
                $form.unblock();
            }
        });

        e.preventDefault();
        return false;
    });
</script>
