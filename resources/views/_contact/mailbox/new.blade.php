@extends("_contact.mailbox.mailapp")
@section("mailheader")
   <link rel="stylesheet" href="{{ asset('assets/plugins/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection
@section("mailcontent")
        <div class="box box-primary">
            <div class="overlay hide">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans("buzzycontact.ComposeNewMessage") }}</h3>
            </div><!-- /.box-header -->
            {!!   Form::open(array('action' => 'Admin\ContactController@newmailsent', 'method' => 'POST', 'onsubmit' => 'return false', 'enctype' => 'multipart/form-data')) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::text('email-to', isset($lastmail) ? $lastmail->email : '', ['id' => 'name','placeholder' => trans("buzzycontact.to"),'class' => 'form-control inoutuh']) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('email-subject', isset($lastmail) ? 'RE: '.$lastmail->subject : '', ['id' => 'name','placeholder' => trans("buzzycontact.Subject"),'class' => 'form-control inoutuh']) !!}

                </div>
                <div class="form-group">
                    <textarea name="email-body" id="compose-textarea" class="form-control">
                        {!!   get_buzzy_config('BuzzyContactSignature') ? '<br><br><br>'.get_buzzy_config('BuzzyContactSignature'): '' !!}
                        {{ isset($lastmail) ? '<blockquote><br><hr>'.$lastmail->text.'</blockquote>' : '' }}
                    </textarea>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <div class="pull-right">
                    <button class="btn btn-default sendmail" data-type="draftsave"><i class="fa fa-pencil"></i> {{ trans("buzzycontact.Draft") }}</button>
                    <button type="submit" class="btn btn-primary sendmail"  data-type="sendit"><i class="fa fa-envelope-o"></i> {{ trans("buzzycontact.send") }}</button>
                </div>
                <a href="{{ route('admin.mailbox', ['type' => 'inbox']) }}" class="btn btn-default"><i class="fa fa-times"></i> {{ trans("buzzycontact.cancel") }}</a>
            </div><!-- /.box-footer -->
            {!! Form::close() !!}
        </div><!-- /. box -->

@endsection
@section("mailfooter")
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('assets/plugins/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
@endsection
