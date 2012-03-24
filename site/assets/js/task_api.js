(function( $ ){
    var methods = {    
    /**
     * initiation method
     * - create array
     * - set base_url (param)
     */
    _init : function(base_url) {
        $.task.tasks_array = new Array();
        $.task.base_url = base_url;
        $.task.STATUS_WAITING = 0;
        $.task.STATUS_IN_PROGRESS = 1;
        $.task.STAUS_COMPLETE = 2;
        $.task.PRIORITY_NORMAL = 1;
        $.task.PRIORITY_HIGH = 2;
    },
    /**
     * add
     */
    _add : function(id, message, deadline, status) {
        var tasks_str = '<div class="task">';
        tasks_str += '<span id="'+id+'" class="status"></span><strong>'+message+'</strong>';
        tasks_str += '<div class="options"><a href="#" id="'+id+'" class="update"> </a>';
        tasks_str += '<a href="#" id="'+id+'" class="delete">Delete</a></div>';
        tasks_str += '</div>';
        $.task.tasks_array.push(tasks_str);
    },
    _show : function() {
        var tasks_str = '<ul>';
        for(var i=0; i<$.task.tasks_array.length; i++) {
            tasks_str += $.task.tasks_array[i];
        }
        tasks_str += '</ul>';
        $('#tasks').html(tasks_str);
        /**
         * clear tasks list
         */
        $.task.tasks_array = new Array();
    },
    _refresh : function() {
        $.api_post($.task.base_url+'api/tasks/get', {}, function(data){
           for(var i=0; i<data.tasks.length; i++)
               $.task('add', data.tasks[i].id, data.tasks[i].message, data.tasks[i].deadline, data.tasks[i].status);
           $.task('show');
        });
    },
    _create : function(message, deadline, callback) {
        $.api_post($.task.base_url+'api/tasks/create', {'message': message, 'status_id': 0, 'priority': 1, 'deadline': deadline}, callback);
    },
    _update : function(parms, task_id, callback) {
        parms['task_id'] = task_id;
        $.api_post($.task.base_url+'api/tasks/update', parms, callback);
    },
    _delete : function(task_id, callback) {
        $.api_post($.task.base_url+'api/tasks/delete', {'task_id': task_id}, callback);
    },
    _get_by_id : function(task_id, callback) {
        $.api_post($.task.base_url+'api/tasks/get', {'task_id': task_id}, callback);
    },
    _get_all : function(callback) {
        $.api_post($.task.base_url+'api/tasks/get', {}, callback);
    }
  };
  jQuery.extend({ 
     task: function( method ) {
        var tasks_array;
        var task_id = -1;
        var base_url = '';
        var STATUS_WAITING = 0;
        var STATUS_IN_PROGRESS = 1;
        var STAUS_COMPLETE = 2;

        var PRIORITY_NORMAL = 1;
        var PRIORITY_HIGH = 2;
        
        if ( methods['_'+method] ) {
          return methods[ '_'+method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
          return methods.init.apply( this, arguments );
        }
     },
     api_post: function(url, post, callback) {
        $.post(url, post, function(data) {
             if(!data) {
                $('.error').html('Connection error');
                $('.error').fadeIn(500);
                $('.error').delay(5000).fadeOut(500);
                return;
             }
             
             if(data.is_error) {
                $('.error').html(data.error_message.toString());
                $('.error').fadeIn(500);
                $('.error').delay(5000).fadeOut(500);
             }
             if(typeof callback == 'function'){
                callback.call(this, data);
             }
        }, 'json');
     }
  });
  })(jQuery);