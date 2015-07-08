<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1" >
	<div class="modal-dialog modal-lg" style="width:700px">
		<div class="modal-content">
			<div class="avatar-form">
				<div class="modal-header">
					<button class="close" data-dismiss="modal" type="button">&times;</button>
					<h4 class="modal-title" id="avatar-modal-label">{{Lang::get('crop.change_avatar')}}</h4>
				</div>
				<div class="modal-body">
					<div class="avatar-body">
						<div class="avatar-upload">
							<input form="form" class="avatar-src" name="avatar_src" type="hidden">
							<input form="form" class="avatar-data" name="avatar_data" type="hidden">
							<label for="avatarInput">{{Lang::get('crop.search')}}</label>
							<input form="form" data-validate="image" class="avatar-input" id="avatarInput" name="avatar_file" type="file" accept="image/x-png, image/gif, image/jpeg">
						</div>
						<div class="row">
							<div class="col-md-9">
								<div class="avatar-wrapper"></div>
							</div>
							<div class="col-md-2">
								<div id="preview" style="width:140px; height:140px" class="avatar-preview preview-lg"></div>
							</div>
						</div>
						<div class="row avatar-btns">
							<div class="col-md-9">
							</div>
							<div class="col-md-3">
								<button id="crop" class="btn btn-primary btn-block avatar-save" type="submit">{{Lang::get('crop.done')}}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>