<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"
			  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
			  crossorigin="anonymous">
              </script>
    <script src="https://cdn.datatables.net/1.10.20/css/jquery.dataables.min.js"></script> -->
    <style>
        .error {
  color: red;
  margin-left: 5px;
}
    </style>
</head>
<body>
<div class="container-fluid">
<div class="float-right"> 
<button type="button" id="add_button" data-toggle="modal" data-target="#userModal" class="btn btn-info ">Add</button>
</div>
    <div class="table-responsive">
    <table id="user_data" class="table table-bordered table-striped">
    <thead>
    <tr>
    <th width="10%">Image</th>
    <th width="35%">First Name</th>
    <th width="35%">Last Name</th>
    <th width="35%">Edit</th>
    <th width="35%">Delete</th>
    </tr>
    </thead>
    </table>
    </div>
    </div>
</body>
</html>

<script>


$(document).ready(function(){
 $('#add_button').click(function(){
  $('#user_form')[0].reset();
  $('.modal-title').text("Add User");
  $('#action').val("Add");
  $('#operation').val("Add");
  $('#user_uploaded_image').html('');
 });
 
 var dataTable = $('#user_data').DataTable({
  "processing":true,
  "serverSide":true,
  "order":[],
  "ajax":{
   url:"fetch.php",
   type:"POST"
  },
  "columnDefs":[
   {
    "targets":[0, 3, 4],
    "orderable":false,
   },
  ],

 });



 $(document).ready(function vld() {
   // calls.clear();
    $("#user_form").validate({
        //ignore: [],
        rules: {
            first_name: {
                required: true,
            },
            last_name: {
                required: true
            },
        },
        messages: {
            first_name: {
                required: "enter your name "
            },
            last_name: {
                required: "enter your surname"
            },
        }
    });
    var returnVal = $("#absentList").valid();
    if (returnVal) {
        var fromDate = $('#foDate').val();
        var uptoDate = $('#upDate').val();
        var branchId = null;
        if ($('#branchA').val() != '') {
            branchId = $('#branchA').val();
        }
        $.ajax({
            url: url + 'getAbsentCallList.php',
            type: 'POST',
            dataType: 'json',
            data: { fromDate: fromDate, uptoDate: uptoDate, branchId: branchId },
            success: function(response) {
                if (response.Responsecode == 200) {
                    const count = response.Data.length;
                    for (var i = 0; i < count; i++) {
                        calls.set(response.Data[i].callId, response.Data[i]);
                    }
                }
                listCalls(calls);
            }
        });
    }
})
 




 $(document).on('submit', '#user_form', function(event){
  event.preventDefault();
  var firstName = $('#first_name').val();
  var lastName = $('#last_name').val();
  var extension = $('#user_image').val().split('.').pop().toLowerCase();
  if(extension != '')
  {
   if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
   {
    swal("Invalid Image File");
    $('#user_image').val('');
    return false;
   }
  } 
  if(firstName != '' && lastName != '')
  {
   $.ajax({
    url:"insert.php",
    method:'POST',
    data:new FormData(this),
    contentType:false,
    processData:false,
    success:function(data)
    {
     swal(data);
     $('#user_form')[0].reset();
     $('#userModal').modal('hide');
     dataTable.ajax.reload();
    }
   });
  }
  else
  {
   swal("Both Fields are Required");
  }
 });
 
 $(document).on('click', '.update', function(){
  var user_id = $(this).attr("id");
  console.log();
  $.ajax({
   url:"fetch_single.php",
   method:"POST",
   data:{user_id:user_id},
   dataType:"json",
   success:function(data)
   {
    $('#userModal').modal('show');
    $('#first_name').val(data.first_name);
    $('#last_name').val(data.last_name);
    $('.modal-title').text("Edit User");
    $('#user_id').val(user_id);
    $('#user_uploaded_image').html(data.user_image);
    $('#action').val("Update");
    $('#operation').val("Edit");
   }
  })
 });
 
 $(document).on('click', '.delete', function(){
  var user_id = $(this).attr("id");
  if(confirm("Are you sure you want to delete this?"))
  {
   $.ajax({
    url:"delete.php",
    method:"POST",
    data:{user_id:user_id},
    success:function(data)
    {
     alert(data);
     dataTable.ajax.reload();
    }
   });
  }
  else
  {
   return false; 
  }
 });
 
 
});

</script>

<div id="userModal" class="modal fade">
 <div class="modal-dialog">
  <form method="post" id="user_form" enctype="multipart/form-data">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">&times;</button>
     <h4 class="modal-title">Add User</h4>
    </div>
    <div class="modal-body">
     <label>Enter First Name</label>
     <input type="text" name="first_name" id="first_name" class="form-control" />
     <br />
     <label>Enter Last Name</label>
     <input type="text" name="last_name" id="last_name" class="form-control" />
     <br />
     <label>Select User Image</label>
     <input type="file" name="user_image" id="user_image" />
     <span id="user_uploaded_image"></span>
    </div>
    <div class="modal-footer">
     <input type="hidden" name="user_id" id="user_id" />
     <input type="hidden" name="operation" id="operation" />
     <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
   </div>
  </form>
 </div>
</div>