<div class="modal fade" id="studentDetailsModal" style="color: #000000;"
     tabindex="-1" role="dialog" aria-labelledby="Register University" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel" style="color: #26A69A;"><i class="fa fa-eye"></i> {{ Lang::get('teacher_section_groups.modal_information')  }}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3"><img id="photo_display" name="photo_display" src="http://placehold.it/150x150" alt=""/></div>
                    <div class="col-lg-8" style="margin-left: 10px; font-size: 1.2em;">

                        <table class="table">
                            <tr><th>{{Lang::get('student_profile.name')}}</th><td id="name" name="name"></td></tr>
                            <tr><th>{{Lang::get('student_profile.nip')}}</th><td id="last_name" name="last_name"></td></tr>
                            <tr><th>{{Lang::get('student_profile.email')}}</th> <td id="mail" name="mail"></td></tr>
                            <tr><th>{{Lang::get('student_profile.job')}}</th> <td id="job" name="job"></td></tr>
                            <tr><th>{{Lang::get('student_profile.phone')}}</th> <td id="phone" name="phone"></td></tr>
                            <tr><th>{{Lang::get('student_profile.cellphone')}}</th> <td id="cellphone" name="cellphone"></td></tr>
                            <tr><th>{{Lang::get('student_profile.genre')}}</th> <td id="genre" name="genre"></td></tr>
                        </table>
                    </div>
                </div>
                <hr />
            </div>
        </div>
    </div>
</div>