<div class="modal-header">
    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
        <i class="font-icon-close-2"></i>
    </button>
    <h4 class="modal-title">Add Git Repository</h4>
</div>
<form id="form-git-repository-add" method="POST" action="{{ route('repositories.create') }}">
    <div class="modal-body">
        <fieldset class="form-group title">
            <label class="form-label">Git Provider</label>
            <select data-class="select2" class="select2" name="type_id">
                @foreach($gitTypes as $gitType)
                    <option value="{{$gitType->id}}">{{$gitType->title}}</option>
                @endforeach
            </select>
        </fieldset>
        <fieldset class="form-group title">
            <label class="form-label">Repo URL</label>
            <input type="text" class="form-control" name="repo_url" autocomplete="off" placeholder="Repo URL">
        </fieldset>
        <fieldset class="form-group is_group_company">
            <label class="form-label">E-Mails</label>
            <select data-class="select2" class="select2" name="emails[]" multiple="multiple">
                @foreach($emails as $email)
                    <option value="{{$email->id}}">{{$email->title}}</option>
                @endforeach
            </select>
        </fieldset>
        <div class="clearfix"></div>
    </div>
    <div class="modal-footer">
        <button type="reset" class="btn btn-default btn-sm hidden btn-reset">Clear</button>
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <button class="btn btn-primary btn-save btn-sm"><i class="fa fa-save"></i> Add</button>
    </div>
</form>
<script>

    $("form#form-git-repository-add").submit(function (e) {
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
                LoadBlock($form, '<i class="fa fa-circle-o-notch fa-spin"></i><h6>Please wait..</h6>');
            },
            success: function (data) {
                try {
                    if (data.result === true) {
                        notify('Successful', data.message, 'success', 'fa fa-check');
                        $('.btn-reset').trigger('click');
                        $('#modalsm').modal('hide');
                        $('#git-repositories').bootstrapTable('refresh');
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
        $('.select2').select2({
            allowClear: true,
            placeholder: "Select",
        });
        $("form#form-git-repository-add input").on('keypress', function (e) {
            $('.' + $(this).attr('name')).removeClass('error');
        });
    });
</script>
