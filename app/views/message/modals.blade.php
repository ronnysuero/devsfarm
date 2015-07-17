<div class="modal fade" id="viewMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-primary text-white">
				<button type="button" class="close text-white" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">Subject</h3>
			</div>
			<div class="modal-body">
				<div class="icon-show"></div>
			</div>
			<div class="modal-footer">
				<textarea class="form-control" rows="4"></textarea>
				<br>
				<button type="button" class="btn bg-primary text-white">Send Reply! </button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="Enviar mensaje" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="Enviar mensaje"><i class="fa fa-send"></i> {{Lang::get('send_message.title')}}</h4>
			</div>
			<div class="modal-body">
				{{ Form::open(array('url' => Lang::get('routes.send_message'), 'id' => 'sendMessage_form', 'role' => 'form')) }}
				<div class="form-group">
					<label>{{Lang::get('send_message.to')}}</label>
					<input data-validate="required,validateMail" class="form-control" id="receptor" name="receptor" placeholder="{{Lang::get('send_message.to_placeholder')}}">
					<p class="help-block">{{Lang::get('send_message.to_title')}}</p>
				</div>
				<div class="form-group">
					<label>{{Lang::get('send_message.subject')}}</label>
					<input data-validate="required" class="form-control" id="subject" name="subject" placeholder="{{Lang::get('send_message.subject_placeholder')}}">
				</div>
				<div class="form-group">
					<label>{{Lang::get('send_message.body')}}</label>
					<textarea class="form-control" rows="5" id="content" name="content"></textarea>
				</div>
				{{ Form::close() }}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
				<button type="submit" form="sendMessage_form" class="btn btn-primary pull-right">{{Lang::get('send_message.title')}}</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="Ver mensaje" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><i class="fa fa-envelope-o"></i> {{Lang::get('list_message.details')}}</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<h3 class="page-header" id="to"></h3>
						<br/>
						<h4 id="title"></h4>
						<br/>
						<p id="body"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="Eliminar mensaje" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="Eliminar mensaje"><i class="fa fa-trash-o"></i> {{Lang::get('list_message.delete_msg')}}</h4>
			</div>
			<div class="modal-body">
				{{Lang::get('list_message.agree')}}
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('list_teacher.cancel')}}</button>
				<button type="button" class="btn btn-primary" id="delete_btn">{{Lang::get('list_teacher.disable')}}</button>
			</div>
		</div>
	</div>
</div>