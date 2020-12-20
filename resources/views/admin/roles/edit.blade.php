@extends('admin.master')

@section('title','Chỉnh sửa quyền')

@section('css')
<link rel="stylesheet" type="text/css" href="{{url('/public/admin')}}/css/bootstrap-duallistbox.css">
@stop()
@section('main')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Chỉnh sửa vai trò</h2>
        </div>
    </div>
</div>


<form action="" method="POST" role="form" id="form_demo">
    @csrf
    <div class="form-group">
        <label for="" class="control-label">Tên</label>
        <input type="text" class="form-control" id="name" value="{{ $role->name }}" name="name">
    </div>
    <div class="form-group">
        <label for="" class="control-label">Quyền</label>
        <select name="permission[]" id="" class="permissions form-control select2" id="permission[]" multiple="multiple" >
                <?php foreach($permission as $value):
             ?>
              <option value="{{ $value->id }}"<?php foreach ($rolePermissions as $rolePermission):?>{{$selected = $value->id == $rolePermission ? 'selected' : ''}}<?php endforeach; ?>>{{ $value->name }}</option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <span id="form_result"></span>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="hidden_id" id="hidden_id" value="{{ $role->id }}">
        <button type="submit" class="btn btn-success" value="" id="edit">Sửa</button>
    </div>
</form>

<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: red !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        border: 1px solid white !important;
        border-radius: 0px !important;
    }

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        color: black !important;
    }
</style>
@endsection

@section('js')
 <script src="{{url('/public/admin')}}/js/jquery.bootstrap-duallistbox.js"></script>
<script>
      $('.select2').select2();
    $('#form_demo').on('submit',function(event){
        event.preventDefault();
        var id = $('#hidden_id').val();
        var data = new FormData(this);
        data.append('_method','PUT');
        data.append('id',id);
        for (var value of data.values()) {
           console.log(value); 
        }
        $.ajax({
            url: "{{ route('roles.update') }}",
            method: "POST",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){
                var html = '';
                if(data.errors){
                    html = '<div class="alert alert-danger">';
                    for(var count = 0;count<data.errors.length;count++){
                    html += '<p>'+data.errors[count]+'</p>';
                }
                html +='</div>';
                }
                $('#form_result').html(html);
                if (data.success) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-right',
                        showConfirmButton: false,
                        timer: 1000
                    });
                    Toast.fire({
                        type: 'success',
                        title: data.success
                    });
                    window.location.href = "http://localhost:88/project_2/admin/roles";
                }
            }
        });
    });
</script>
@stop()