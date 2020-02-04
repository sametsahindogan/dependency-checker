<div class="modal-header">
    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
        <i class="font-icon-close-2"></i>
    </button>
    <h4 class="modal-title">Update E-Mail Address</h4>
</div>
<form id="form-email-edit" method="POST" action="{{route('emails.update')}}">
    <input type="hidden" name="id" value="{{ $email->id }}">
    <div class="modal-body">
        <fieldset class="form-group title">
            <label class="form-label">E-Mail Address</label>
            <input type="email" class="form-control" name="title" autocomplete="off" placeholder="E-Mail Address" value="{{ $email->title }}" required>
        </fieldset>
        <div class="clearfix"></div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm hidden btn-reset"> Clear</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"> Close</button>
        <button class="btn btn-primary btn-save btn-sm"><i class="fa fa-save"></i> Add</button>
    </div>
</form>
<script>
    $("form#form-email-edit").submit(function (e) {
        $('.error').removeClass('error');
        $form = $(this);
        $action = $form.attr('action');
        $method = $form.attr('method');
        $data = new FormData($form[0]);

        $.ajax({
            type: $method,
            url: $action,
            data: $data,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('.btn-submit').attr('disabled', true);
                LoadBlock($form, '<i class="fa fa-circle-o-notch fa-spin"></i><h6>Lütfen Bekleyin..</h6>');
            },
            success: function (data) {
                try {
                    if (data.result === true) {
                        notify('Successful', data.message, 'success', 'fa fa-check');
                        $('.btn-reset').trigger('click');
                        $('#modalsm').modal('hide');
                        $('#emails').bootstrapTable('refresh');
                    } else {
                        $.each(data.fields, function (key, value) {
                            $('.' + key).addClass('error');
                        });
                        notify('Error', data.message, 'error', 'fa fa-exclamation-triangle');
                    }
                } catch (err) {
                    console.log(err);
                }
                $('.btn-submit').attr('disabled', false);
                $form.unblock();
            }
        });

        e.preventDefault();
        return false;
    });
    $(document).ready(function () {
        $("form#form-email-edit input").on('keypress', function (e) {
            $('.' + $(this).attr('name')).removeClass('error');
        });
    });
</script>
