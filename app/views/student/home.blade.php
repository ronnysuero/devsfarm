@extends('student.master')

@section('title', 'Dashboard - Teacher')
@stop
@section('content')
<br>

 <script type="text/javascript">


 function findGroup(x){

    var group =  x;
    $("#group_code").val(group);
    $("#form_groups").submit();

    
}
     
</script>    
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><i class="fa fa-list"></i> {{Lang::get('show_groups.my_groups')}}</h1>
        <div class="panel-body">
            @if (count($groups) >= 1)
                <div class="table-responsive">
                    @include('alert')
                    <table id="tableOrder" class="table table-striped table-bordered table-hover tablesorter">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{Lang::get('show_groups.edit')}}</th>
                                <th>{{Lang::get('register_group.name')}}</th>
                                <th>{{Lang::get('register_group.project_name')}}</th>
                                <th>{{Lang::get('show_groups.delete')}}</th>
                                <th>{{Lang::get('show_groups.see')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $index =>$group)    
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>
                                    <a href="#">
                                        <i class="fa fa-edit" data-toggle="modal" data-target="#editModal" style="color:#337ab7;"></i>
                                    </a>
                                </td>
                                <td>{{$group->name}}</td>
                                <td>{{$group->project_name}}</td>
                   
                                <td>
                                   <a onclick="$('#_id').val('{{$group->_id}}')" class="pull-right">
                                            <i class="fa fa-trash-o" data-toggle="modal" data-target="#deleteModal" style="color:#d9534f;"></i>
                                    </a>
                                </td>

                                <td>

                                <div class="see">
                                    <a href="#" onclick="findGroup('{{$group->_id}}')">
                                       <i class="fa fa-eye" style="color: #0097A7;"></i>
                                    </a>
                                </div>
                                </td>

                                
                            </tr>
                            @endforeach
                             {{ Form::open(array('url' => Lang::get('routes.find_Group'), 'id' => 'form_groups', 'class' => 'hide')) }}
                                <div class="form-group">
                                <input type="hidden" id="group_code" name="group_code" value="" >
                                <input type="hidden" id="_id", name="_id" value="">
                                
                            </div>
                            {{Form::close()}}
                        </tbody>
                    </table>
                </div>
                <!--
            @else
                <p>
                
                    <a href="{{Lang::get('routes.add_subject')}}">
                        <i class="fa fa-plus" style="color: #0097A7;"></i>
                        {{Lang::get('list_subject.add_subject')}}
                    </a>
                </p>-->
            @endif
        </div>
    </div>
    @stop
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar Grupo" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="Eliminar grupo"><i class="fa fa-trash-o"></i> {{Lang::get('list_teacher.confirm')}}</h4>
            </div>
            <div class="modal-body">
                {{Lang::get('list_teacher.agree')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
                <button onclick="dropGroup();" type="button" class="btn btn-primary">{{Lang::get('list_teacher.disable')}}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function dropGroup()
    {
        $.post("{{Lang::get('routes.drop_group')}}",
        { 
            group_id: $('#_id').val()
        })
        .done(function( data ) 
        {
            if(data === '00')
                location.reload();
        });
    }
</script>