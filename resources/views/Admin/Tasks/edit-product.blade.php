<div class="modal fade editTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="position:relative;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form method="post" action="{{route('update.task.details')}}" id="update-task-form">
                    @csrf
                    <input type="hidden" name="task_id">

                     <div class="form-group">
                         <label for="">Task Title</label>
                         <input type="text" class="form-control" name="title" placeholder="Enter Product name">
                         <span class="text-danger error-text title_error"></span>
                     </div>

                     <div class="form-group">
                         <label for="">Task Description</label>
                         <textarea name="description" class="form-control" id="" cols="30" rows="5"></textarea>
                         <span class="text-danger error-text description_error"></span>
                     </div>
                     <div class="form-group">
                         <label for="">Due Date</label>
                         <input type="date" class="form-control" name="due_date">
                         <span class="text-danger error-text due_date_error"></span>
                     </div>

                     <div class="form-group">
                         <label for="">Priority</label>
                         <input type="number" class="form-control" name="priority" placeholder="Enter Task Priority">
                         <span class="text-danger error-text priority_error"></span>
                     </div>

                     <div class="form-group">
                         <button type="submit" class="btn btn-block btn-success">Save Changes</button>
                     </div>

                 </form>


            </div>
        </div>
    </div>
</div>
