<script src="<?=base_url();?>assets/js/task_api.js"></script>
<script>
    $(document).ready(function(){
        $.task('init', '<?=base_url();?>');
        <? foreach($tasks as $task): ?>
        $.task('add', '<?=$task->get_id();?>', '<?=addslashes($task->get_message()); ?>', '<?=$task->get_deadline();?>');
        <? endforeach; ?>
        $.task('show');
        
        $('#create_button').live('click', function(){
           $('#message').attr('disabled', true); 
           
           var unixTime = Math.round(new Date( $('#date').val()).getTime()/1000);

           $.task('create', $('#message').val(), unixTime, function(data){
               if(!data.is_error) {
                   $('#message').val('');
                   $('#date').val('<?=date("Y-m-d");?>')
                   $.task('refresh');
               }
               $('#message').removeAttr('disabled');
           });
           return false;
        });

       $("#cancel_button").live('click', function() {
           $.task.task_id = -1;
           $('#message').removeAttr('disabled');
           $('#message').val('');
           $('#cancel_button').hide();
           $('#update_button').hide();
           $('#create_button').show();
        });

        $("#update_button").live('click', function(){
           $('#message').attr('disabled', true);
           var unixTime = Math.round(new Date( $('#date').val()).getTime()/1000);
           
           $.task('update', {'message':$('#message').val(),'deadline': unixTime}, $.task.task_id, function(data){
               if(!data.is_error) {
                   $('#message').val('');
                   $('#cancel_button').hide();
                   $('#update_button').hide();
                   $('#create_button').show();
                   $.task('refresh');
               }
               $('#message').removeAttr('disabled');
           });
        });
        
        $('.delete').live('click', function(){
           if(confirm('Are you sure?')) {
               $.task('delete', $(this).attr('id'), function(data){
                   $('#message').removeAttr('disabled');
                   $('#message').val('');
                   $('#cancel_button').hide();
                   $('#update_button').hide();
                   $('#create_button').show();
                   if(!data.is_error) {
                        $.task('refresh');
                   }
               });
           }
           return false;
        });
        
        $(".update").live('click', function(){
            $('#create_button').hide();
            
            $.task('get_by_id', $(this).attr('id'), function(data){
                if(!data.is_error) {
                   $.task.task_id = data.task.id;
                   $('#update_button').show();
                   $('#cancel_button').show();
                   $('#message').val(data.task.message);
                   var unixTime = new Date( data.task.deadline *1000 );
                   $('#date').val(unixTime.getFullYear()+"-"+(unixTime.getMonth()+1)+"-"+unixTime.getDate());
                   $('#message').focus();
                   $('#message').select();
                }
            });
           return false;
        });
        
        $("span.status").live('click', function() {
            var status;
            if($(this).hasClass('selected')) {
                status = $.task.STATUS_WAITING;
                $(this).removeClass('selected');
                $(this).parent().css({'opacity':1,'filter':'alpha(opacity=100)','text-decoration':'none'});
                $(this).parent().find('.options .update').show();
            }else{
                status = $.task.STAUS_COMPLETE;
                $(this).addClass('selected');
                $(this).parent().css({'opacity':0.4,'filter':'alpha(opacity=40)','text-decoration':'line-through'});
                $(this).parent().find('.options .update').hide();
            }
            console.log(status);
            $.task('update', {'status_id': status}, $(this).attr('id'), function(data){
                console.log(data);
            });
        });
        
        $('form').bind('submit', function(){
            if($('#create_button').is(':visible')) {
                //create
                $("#create_button").click();
            }else{
                //update
                $("#update_button").click();
            }
            return false;
        }); 
    });
</script>

<div style="display:none" class="error"></div>
    <form>
        <input type="text" id="message" required autofocus/>
        <input type="date" id="date" value="<?=date("Y-m-d");?>" required />
        <input type="hidden" id="task_id" />
    </form>
<div style="float:left;padding-top:25px;">
    <a href="#">Task list</a> | <a href="#">All task</a> | <a href="#">Done task</a>
</div>
    <div style="width:100%;height:50px">
        <a id="create_button" class="large button add">Add</a>
        <a id="update_button" id="" class="large button add" style="display:none">Update</a>
        <a id="cancel_button" class="large button cancel" style="display:none">Cancel</a>
    </div>

<!-- tasks list -->
<div id="tasks">
    <!-- empty -->
</div>